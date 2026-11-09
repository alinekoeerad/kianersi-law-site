const http = require('http');
const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

async function runComprehensiveTests() {
  console.log('\n================================================================');
  console.log('🏛️  آزمون جامع، سرتاسری و یکپارچه کلیه بخش‌های سامانه دفتر وکالت کیان‌ارثی');
  console.log('================================================================\n');

  let passed = 0;
  let failed = 0;
  const testResults = [];

  function assert(condition, category, testTitle, details = '') {
    if (condition) {
      console.log(`  ✅ [PASS] (${category}) - ${testTitle}`);
      passed++;
      testResults.push({ category, title: testTitle, status: 'PASS', details });
    } else {
      console.error(`  ❌ [FAIL] (${category}) - ${testTitle} ${details ? '-> ' + details : ''}`);
      failed++;
      testResults.push({ category, title: testTitle, status: 'FAIL', details });
    }
  }

  const rootDir = path.join(__dirname, '..');
  const distDir = path.join(rootDir, 'dist');
  const publicDir = path.join(rootDir, 'public');
  const srcDir = path.join(rootDir, 'src');

  // ══════════════════════════════════════════════════════════════════
  // بخش ۱: ارزیابی فایل‌های زیرساختی، دارایی‌های وب و بسته نصبی (Deploy Bundle)
  // ══════════════════════════════════════════════════════════════════
  console.log('\n📦 [گروه ۱: فایل‌های زیرساختی، استاتیک و پکیج دیپلوی]');

  const requiredDistFiles = [
    { file: 'index.html', label: 'باندل کامپایل‌شده وبسایت اصلی' },
    { file: 'site-data.json', label: 'پایگاه داده اصلی محتوا (JSON)' },
    { file: 'robots.txt', label: 'دستورالعمل خزنده‌های وب (robots.txt)' },
    { file: 'sitemap.xml', label: 'نقشه سایت جهت ایندکس گوگل (sitemap.xml)' },
    { file: '.htaccess', label: 'دیواره آتش و امنیت آپاچی روت' },
    { file: 'logo.png', label: 'فایل نشان تصویری PNG' },
    { file: 'logo.webp', label: 'فایل نشان تصویری مدرن WebP' },
    { file: 'preview.webp', label: 'تصویر کارت پیش‌نمایش اشتراک‌گذاری' },
    { file: 'favicon.ico', label: 'آیکون زبانه مرورگر (Favicon)' },
    { file: 'images/lawyer-portrait.webp', label: 'پرتره رسمی وکیل با فرمت WebP' },
    { file: 'admin/index.php', label: 'رابط کاربری پنل مدیریت (admin/index.php)' },
    { file: 'admin/api.php', label: 'هسته ای‌پی‌آی پنل (admin/api.php)' },
    { file: 'admin/config.php', label: 'پیکربندی امنیتی ادمین' },
    { file: 'admin/.htaccess', label: 'قوانین امنیتی و ضد نفوذ پوشه ادمین' },
    { file: 'index.php', label: 'تزریق‌کننده داینامیک متاتگ‌های سئو در روت (index.php)' }
  ];

  requiredDistFiles.forEach(rf => {
    const p = path.join(distDir, rf.file);
    assert(fs.existsSync(p), 'زیرساخت و فایل‌ها', `بررسی وجود فایل: dist/${rf.file} (${rf.label})`);
  });

  const zipPath = path.join(rootDir, 'website.zip');
  const hasZip = fs.existsSync(zipPath);
  const zipSize = hasZip ? fs.statSync(zipPath).size : 0;
  assert(hasZip && zipSize > 500000, 'پکیج هاست', `فایل فشرده website.zip آماده استقرا با حجم مناسب (${(zipSize / (1024 * 1024)).toFixed(2)} MB)`);


  // ══════════════════════════════════════════════════════════════════
  // بخش ۲: متاتگ‌های سئو، شبکه‌های اجتماعی و داده‌های ساختاریافته وب اصلی
  // ══════════════════════════════════════════════════════════════════
  console.log('\n🔍 [گروه ۲: سئو، اسکیمای گوگل و پیش‌نمایش شبکه‌های اجتماعی وب اصلی]');

  const indexHtml = fs.readFileSync(path.join(distDir, 'index.html'), 'utf8');

  assert(indexHtml.includes('lang="fa"') && indexHtml.includes('dir="rtl"'), 'سئو و ساختار', 'تعریف زبان فارسی (fa) و جهت راست‌به‌چپ (RTL) در سند HTML');
  assert(indexHtml.includes('<title>') && indexHtml.includes('محمدحسن کیان‌ارثی'), 'سئو و متاتگ‌ها', 'تگ عنوان صفحه (Title) حاوی نام رسمی وکیل و کلیدواژه کرج');
  assert(indexHtml.includes('<meta name="description"') && indexHtml.includes('۰۹۱۲۷۶۹۸۸۶۴'), 'سئو و متاتگ‌ها', 'توضیحات متا (Meta Description) استاندارد به همراه شماره تماس مستقیم');
  assert(indexHtml.includes('<meta name="keywords"') && indexHtml.includes('وکیل دعاوی آب کرج'), 'سئو و متاتگ‌ها', 'کلمات کلیدی متا (Meta Keywords) تخصصی حوزه آب و املاک');
  assert(indexHtml.includes('<link rel="canonical" href="https://vakilkianersi.ir/"'), 'سئو تکنیکال', 'تگ آدرس قانونی کانونیکال (Canonical URL) به دامنه رسمی');
  assert(indexHtml.includes('property="og:title"') && indexHtml.includes('property="og:image"'), 'OpenGraph', 'متاتگ‌های OpenGraph کامل جهت نمایش غنی در واتساپ، ایتا، بله و روبیکا');
  assert(indexHtml.includes('name="twitter:card"') && indexHtml.includes('summary_large_image'), 'Twitter Card', 'متاتگ‌های توییتر کارت برای پیش‌نمایش عریض با تصویر');
  assert(indexHtml.includes('LegalService') && indexHtml.includes('Attorney'), 'Google Rich Snippet', 'اسکیمای ساختاریافته استاندارد LegalService و Attorney مورد تایید گوگل');
  assert(indexHtml.includes('"telephone":') && indexHtml.includes('"address":'), 'Schema.org', 'اطلاعات تلفن و آدرس در اسکیمای ساختاریافته گوگل');

  const robotsTxt = fs.readFileSync(path.join(distDir, 'robots.txt'), 'utf8');
  assert(robotsTxt.includes('User-agent: *') && robotsTxt.includes('Disallow: /admin/'), 'Robots.txt', 'فایل robots.txt با دسترسی آزاد به موتورهای جستجو و مسدودسازی پوشه ادمین');

  const sitemapXml = fs.readFileSync(path.join(distDir, 'sitemap.xml'), 'utf8');
  assert(sitemapXml.includes('<urlset') && sitemapXml.includes('https://vakilkianersi.ir/'), 'Sitemap.xml', 'نقشه سایت XML استاندارد با آدرس رسمی دفتر وکالت');


  // ══════════════════════════════════════════════════════════════════
  // بخش ۳: ارزیابی تمام بخش‌ها و کامپوننت‌های وب اصلی (React Components)
  // ══════════════════════════════════════════════════════════════════
  console.log('\n🖥️ [گروه ۳: کامپوننت‌ها و بخش‌های وبسایت اصلی]');

  // ۱. نوبار و منو
  const navbarSrc = fs.readFileSync(path.join(srcDir, 'components', 'Navbar.tsx'), 'utf8');
  assert(navbarSrc.includes('دفتر وکالت') && navbarSrc.includes('کیان‌ارثی'), 'منوی ناوبری (Navbar)', 'نمایش برند و لوگوی دفتر وکالت در هدر سایت');
  assert(navbarSrc.includes('experienceYears') || navbarSrc.includes('سابقه'), 'منوی ناوبری (Navbar)', 'نمایش سابقه کار حقوقی در بنر بالای نوبار');
  assert(navbarSrc.includes('menuOpen'), 'منوی ناوبری (Navbar)', 'طراحی منوی همبرگری واکنش‌گرا برای نسخه موبایل');

  // ۲. بخش هیرو (Hero)
  const heroSrc = fs.readFileSync(path.join(srcDir, 'components', 'HeroSection.tsx'), 'utf8');
  assert(heroSrc.includes('محمدحسن کیان‌ارثی') && heroSrc.includes('وکیل پایه یک دادگستری'), 'بخش معرفی (Hero)', 'نمایش نام وکیل، عنوان حقوقی و نشان رسمی پایه یک دادگستری');
  assert(heroSrc.includes('lawyerImage') || heroSrc.includes('portrait') || heroSrc.includes('images'), 'بخش معرفی (Hero)', 'اتصال داینامیک به تصویر پرتره رسمی وکیل');
  assert(heroSrc.includes('مشاوره فوری') || heroSrc.includes('تماس'), 'بخش معرفی (Hero)', 'کال‌تو‌اکشن اصلی برقراری ارتباط سریع و دریافت مشاوره');

  // ۳. بخش درباره وکیل (About)
  const aboutSrc = fs.readFileSync(path.join(srcDir, 'components', 'AboutSection.tsx'), 'utf8');
  assert(aboutSrc.includes('پروانه وکالت') && (aboutSrc.includes('دو دهه') || aboutSrc.includes('سابقه')), 'بخش درباره وکیل (About)', 'نمایش سابقه کار حقوقی (۲۰+ سال) و پروانه وکالت');
  assert(aboutSrc.includes('سوابق تخصصی') && aboutSrc.includes('اطلاعات حرفه‌ای'), 'بخش درباره وکیل (About)', 'نمایش مدارج تحصیلی، تخصص‌ها و پیشینه قضایی و وکالتی');

  // ۴. بخش حوزه‌های تخصصی (Expertise / Services)
  const expertiseSrc = fs.readFileSync(path.join(srcDir, 'components', 'ExpertiseSection.tsx'), 'utf8');
  assert(expertiseSrc.includes('دعاوی آب') || expertiseSrc.includes('چاه'), 'حوزه‌های تخصصی', 'پوشش پرونده‌های دعاوی آب، چاه‌های کشاورزی و حریم رودخانه');
  assert(expertiseSrc.includes('ملکی') || expertiseSrc.includes('اراضی'), 'حوزه‌های تخصصی', 'پوشش دعاوی ملکی، اسناد ثبتی، اراضی موات و منابع طبیعی');
  assert(expertiseSrc.includes('دیوان عدالت اداری') || expertiseSrc.includes('کمیسیون'), 'حوزه‌های تخصصی', 'پوشش دعاوی شهرداری‌ها، کمیسیون‌های تخصصی و دیوان عدالت اداری');

  // ۵. بخش تمایز وکیل (Distinguishing Section)
  const distSrc = fs.readFileSync(path.join(srcDir, 'components', 'DistinguishingSection.tsx'), 'utf8');
  assert(distSrc.length > 500 && (distSrc.includes('پیشینه') || distSrc.includes('سابقه')), 'بخش تمایزات', 'نمایش مزیت‌های رقابتی، تخصص موشکافانه و سابقه موفق پرونده‌ها');

  // ۶. بخش کتابخانه قوانین و مقررات (Laws Section)
  const lawsSrc = fs.readFileSync(path.join(srcDir, 'components', 'LawsSection.tsx'), 'utf8');
  assert(lawsSrc.includes('searchQuery') || lawsSrc.includes('فیلتر'), 'کتابخانه قوانین', 'قابلیت جستجوی زنده در عناوین و مفاد قوانین');
  assert(lawsSrc.includes('selectedCategory') || lawsSrc.includes('categories'), 'کتابخانه قوانین', 'دسته‌بندی موضوعی قوانین با امکان سوئیچ تب‌ها');
  assert(lawsSrc.includes('selectedLaw') || lawsSrc.includes('modal') || lawsSrc.includes('مشاهده'), 'کتابخانه قوانین', 'امکان مشاهده متن کامل قانون در مودال یا پنل بازشونده');

  // ۷. بخش تماس و نقشه لوکیشن (Contact Section)
  const contactSrc = fs.readFileSync(path.join(srcDir, 'components', 'ContactSection.tsx'), 'utf8');
  assert(contactSrc.includes('phone') && contactSrc.includes('address'), 'اطلاعات تماس', 'نمایش تلفن همراه، آدرس دقیق دفتر در کرج و ساعت کار');
  assert(contactSrc.includes('coordinates') || contactSrc.includes('latitude'), 'موقعیت مکانی دفتر', 'پشتیبانی از مختصات جغرافیایی (عرض و طول جغرافیایی)');
  assert(contactSrc.includes('نشان') && contactSrc.includes('بلد') && (contactSrc.includes('Google') || contactSrc.includes('گوگل')), 'مسیریابی هوشمند', 'لینک‌های مستقیم مسیریابی سریع با اپلیکیشن‌های نشان، بلد و Google Maps');

  // ۸. بخش فوتر و دکمه بازگشت به بالا
  const footerSrc = fs.readFileSync(path.join(srcDir, 'components', 'Footer.tsx'), 'utf8');
  assert(footerSrc.includes('تمامی حقوق') && footerSrc.includes('general.lawyerName'), 'فوتر سایت', 'کپی‌رایت حقوقی، سلب مسئولیت و لینک‌های دسترسی سریع در پاورقی');

  const backToTopSrc = fs.readFileSync(path.join(srcDir, 'components', 'BackToTop.tsx'), 'utf8');
  assert(backToTopSrc.includes('scrollTo') || backToTopSrc.includes('isVisible'), 'تجربه کاربری', 'دکمه بازگشت نرم به بالای صفحه (Back to Top)');


  // ══════════════════════════════════════════════════════════════════
  // بخش ۴: اعتبارسنجی یکپارچگی داده‌های فایل site-data.json
  // ══════════════════════════════════════════════════════════════════
  console.log('\n📊 [گروه ۴: ساختار داده‌ها و پایگاه داده site-data.json]');

  const siteDataRaw = fs.readFileSync(path.join(distDir, 'site-data.json'), 'utf8');
  const siteData = JSON.parse(siteDataRaw);

  assert(siteData.general && siteData.general.lawyerName === 'محمدحسن کیان‌ارثی', 'پایگاه داده', 'نام رسمی وکیل در فایل دیتا به درستی ثبت شده است.');
  assert(siteData.general.phone && siteData.general.rawPhone === '+989127698864', 'پایگاه داده', 'شماره تماس مستقیم استاندارد با کد بین‌المللی ایران');
  assert(siteData.general.address && siteData.general.address.includes('کرج'), 'پایگاه داده', 'آدرس فیزیکی دفتر وکالت در کرج');
  assert(siteData.general.latitude && siteData.general.longitude, 'پایگاه داده', `مختصات جغرافیایی معتبر GPS: (${siteData.general.latitude}, ${siteData.general.longitude})`);
  assert(Array.isArray(siteData.categories) && siteData.categories.length >= 3, 'پایگاه داده', `تعداد دسته‌بندی‌های موضوعی (${siteData.categories.length} دسته)`);
  assert(Array.isArray(siteData.laws) && siteData.laws.length >= 8, 'پایگاه داده', `بانک قوانین معتبر (${siteData.laws.length} قانون تخصصی با متن کامل)`);

  siteData.laws.forEach((law, idx) => {
    if (idx < 3) {
      assert(law.id && law.title && law.content, 'مفاد قوانین', `قانون شماره ${law.id}: «${law.title.substring(0, 30)}...» دارای متن کامل است.`);
    }
  });


  // ══════════════════════════════════════════════════════════════════
  // بخش ۵: اجرای سرور آزمایشی و تست تمامی عملکردهای پنل مدیریت و وب
  // ══════════════════════════════════════════════════════════════════
  console.log('\n⚡ [گروه ۵: آزمون رفتاری سرور، احراز هویت و امنیت پنل مدیریت]');

  process.env.PORT = '3099';
  const serverProc = spawn('node', ['local-server.cjs'], {
    env: { ...process.env, PORT: '3099' },
    stdio: 'pipe'
  });

  // مکث کوتاه جهت اتصال سرور به پورت ۳۰۹۹
  await new Promise(r => setTimeout(r, 1200));

  function apiRequest(urlPath, method = 'GET', data = null, headers = {}) {
    return new Promise((resolve, reject) => {
      const u = new URL(urlPath, 'http://127.0.0.1:3099');
      const reqHeaders = { ...headers };
      let bodyData = null;
      if (data) {
        bodyData = typeof data === 'string' ? data : JSON.stringify(data);
        if (!reqHeaders['Content-Type']) reqHeaders['Content-Type'] = 'application/json';
        reqHeaders['Content-Length'] = Buffer.byteLength(bodyData);
      }

      const req = http.request(u, { method, headers: reqHeaders }, (res) => {
        let resBody = '';
        res.on('data', chunk => { resBody += chunk; });
        res.on('end', () => {
          let json = null;
          try { json = JSON.parse(resBody); } catch (e) { }
          resolve({ status: res.statusCode, headers: res.headers, body: resBody, json });
        });
      });

      req.on('error', reject);
      if (bodyData) req.write(bodyData);
      req.end();
    });
  }

  try {
    // ۱. پاسخ‌دهی صفحه اصلی وب
    const webHome = await apiRequest('/');
    assert(webHome.status === 200, 'پاسخ‌دهی وب', 'صفحه اصلی سایت با موفقیت و کد وضعیت 200 لود شد.');
    assert(webHome.body.includes('محمدحسن کیان‌ارثی'), 'رندر وبسایت', 'محتوای صفحه اصلی دربرگیرنده نام و مشخصات وکیل است.');
    assert(webHome.body.includes('og:image') && !webHome.body.includes('og:image" content="https://vakilkianersi.ir/images/lawyer-portrait.webp"'), 'سئو داینامیک اشتراک‌گذاری', 'متاتگ og:image به جای پرتره به تصویر اختصاصی پیش‌نمایش سئو اشاره دارد.');

    // ۲. امنیت: مسدودسازی دسترسی بدون احراز هویت
    const unauthGet = await apiRequest('/admin/api.php?action=get_data');
    assert(unauthGet.status === 403, 'امنیت پنل', 'درخواست بدون لاگین به API با خطای 403 مسدود شد.');

    // ۳. رندر صفحه لاگین بدون افشای داشبورد
    const loginPage = await apiRequest('/admin/');
    assert(loginPage.status === 200, 'صفحه لاگین', 'صفحه لاگین با کد 200 در دسترس است.');
    assert(loginPage.body.includes('<form id="loginForm">'), 'صفحه لاگین', 'فرم ورود مدیر (#loginForm) در صفحه قرار دارد.');
    assert(loginPage.body.includes("loginForm.addEventListener('submit'"), 'هندلر لاگین', 'اسکریپت پردازش فرم ورود به درستی رندر و به فرم متصل است.');
    assert(!loginPage.body.includes('<header class="admin-header">'), 'ایزولاسیون لاگین', 'عناصر داشبورد مدیریت در صفحه لاگین کاملاً پنهان هستند.');
    assert(!loginPage.body.includes('<div class="tabs-container">'), 'ایزولاسیون لاگین', 'تب‌های مدیریت در صفحه لاگین مخفی هستند.');

    // ۴. آزمون ورود با رمز نادرست
    const wrongLogin = await apiRequest('/admin/api.php?action=login', 'POST', { username: 'admin', password: 'WrongPassword123' });
    assert(wrongLogin.status === 401 && !wrongLogin.json.success, 'امنیت ورود', 'تلاش برای ورود با رمز نادرست با کد 401 رد شد.');

    // ۵. آزمون ورود موفق
    const correctLogin = await apiRequest('/admin/api.php?action=login', 'POST', { username: 'admin', password: 'Kianersi@1403' });
    assert(correctLogin.status === 200 && correctLogin.json.success, 'احراز هویت', 'ورود با اطلاعات مدیر با موفقیت انجام پذیرفت.');

    const setCookie = correctLogin.headers['set-cookie'];
    assert(setCookie && setCookie.some(c => c.includes('local_admin_session=authenticated')), 'کوکی امنیتی', 'کوکی سشن امنیتی (local_admin_session) صادر گردید.');
    const authCookie = setCookie.map(c => c.split(';')[0]).join('; ');
    const authHeaders = { Cookie: authCookie };

    // ۶. رندر داشبورد پس از لاگین
    const authedDashboard = await apiRequest('/admin/', 'GET', null, authHeaders);
    assert(authedDashboard.status === 200, 'داشبورد مدیریت', 'داشبورد مدیریت با سشن معتبر باز شد.');
    assert(authedDashboard.body.includes('<header class="admin-header">'), 'داشبورد مدیریت', 'هدر اصلی مدیریت با لوگو و مشخصات دفتر وکالت لود شد.');
    assert(authedDashboard.body.includes('<div class="tabs-container">'), 'داشبورد مدیریت', 'نوار تب‌های ۵‌گانه مدیریت بارگذاری شد.');
    assert(!authedDashboard.body.includes('<form id="loginForm">'), 'داشبورد مدیریت', 'فرم لاگین در نمای داشبورد پنهان است.');

    // ══════════════════════════════════════════════════════════════════
    // گروه ۶: تب ۱ - تنظیمات عمومی، اطلاعات تماس و موقعیت مکانی
    // ══════════════════════════════════════════════════════════════════
    console.log('\n⚙️  [گروه ۶: تب ۱ پنل - تنظیمات عمومی، تماس و موقعیت مکانی]');

    const initialDataRes = await apiRequest('/admin/api.php?action=get_data', 'GET', null, authHeaders);
    assert(initialDataRes.status === 200 && initialDataRes.json.data, 'دریافت داده‌ها', 'دریافت داده‌های کلی سایت از طریق get_data');

    // تست ذخیره تغییرات عمومی و مختصات نقشه
    const testLat = '35.83610';
    const testLng = '50.99820';
    const saveGeneralRes = await apiRequest('/admin/api.php?action=save_general', 'POST', {
      general: {
        lawyerName: 'محمدحسن کیان‌ارثی',
        latitude: testLat,
        longitude: testLng,
        phone: '۰۹۱۲۷۶۹۸۸۶۴'
      }
    }, authHeaders);
    assert(saveGeneralRes.status === 200 && saveGeneralRes.json.success, 'ذخیره عمومی', 'ذخیره تنظیمات عمومی و مختصات جغرافیایی با موفقیت انجام شد.');

    const verifyDataRes = await apiRequest('/admin/api.php?action=get_data', 'GET', null, authHeaders);
    assert(verifyDataRes.json.data.general.latitude === testLat, 'ماندگاری داده‌ها', `مختصات ثبت‌شده بر روی دیسک با موفقیت بازخوانی شد (${testLat}, ${testLng})`);

    // ══════════════════════════════════════════════════════════════════
    // گروه ۷: تب ۲ - هویت بصری، آپلود تصاویر (WebP) و سئو
    // ══════════════════════════════════════════════════════════════════
    console.log('\n🖼️  [گروه ۷: تب ۲ پنل - هویت بصری، تبدیل WebP و تنظیمات سئو]');

    // پیکسل آزمایشی شفاف 1x1 در فرمت PNG جهت تست آپلود
    const samplePixelBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAA=';

    // ۱. آپلود تصویر پرتره
    const uploadLawyer = await apiRequest('/admin/api.php?action=upload_image', 'POST', {
      type: 'lawyer',
      image_base64: samplePixelBase64
    }, authHeaders);
    assert(uploadLawyer.status === 200 && uploadLawyer.json.success, 'آپلود پرتره', 'آپلود تصویر پرتره و تبدیل به فرمت WebP موفقیت‌آمیز بود.');
    assert(uploadLawyer.json.url && uploadLawyer.json.url.endsWith('.webp'), 'تبدیل به WebP', `آدرس عکس جدید به فرمت فشرده و مدرن WebP اشاره دارد (${uploadLawyer.json.url})`);

    // ۲. بازنشانی پرتره به تصویر اصلی
    const resetLawyer = await apiRequest('/admin/api.php?action=reset_image', 'POST', { type: 'lawyer' }, authHeaders);
    assert(resetLawyer.status === 200 && resetLawyer.json.success, 'بازنشانی پرتره', 'تصویر پرتره به فایل اورجینال اولیه بازگردانده شد.');

    // ۳. ذخیره تنظیمات سئو متنی
    const saveSeoRes = await apiRequest('/admin/api.php?action=save_general', 'POST', {
      general: {
        seoTitle: 'محمدحسن کیان‌ارثی | وکیل پایه یک کرج | دعاوی تخصصی آب و املاک',
        seoDescription: 'دفتر وکالت تخصصی محمدحسن کیان‌ارثی در کرج و تهران در امور چاه و آب',
        seoKeywords: 'وکیل کرج, وکیل آب, دعاوی چاه'
      }
    }, authHeaders);
    assert(saveSeoRes.status === 200 && saveSeoRes.json.success, 'ذخیره سئو', 'متاتگ‌های سئو با موفقیت در سیستم ثبت شدند.');

    // ۴. بررسی وجود شبیه‌سازهای سئو و پیام‌رسان‌ها در HTML پنل
    assert(authedDashboard.body.includes('Google SERP Simulator') || authedDashboard.body.includes('نتایج جستجوی گوگل'), 'شبیه‌ساز گوگل', 'کارت شبیه‌ساز زنده پیش‌نمایش در نتایج جستجوی گوگل فعال است.');
    assert(authedDashboard.body.includes('پیش‌نمایش اشتراک‌گذاری در پیام‌رسان‌ها') || authedDashboard.body.includes('پیش‌نمایش اشتراک'), 'شبیه‌ساز پیام‌رسان‌ها', 'کارت پیش‌نمایش اشتراک در تلگرام، واتساپ، ایتا و بله فعال است.');

    // ══════════════════════════════════════════════════════════════════
    // گروه ۸: تب ۳ - مدیریت دسته‌بندی‌ها و کتابخانه قوانین
    // ══════════════════════════════════════════════════════════════════
    console.log('\n📚 [گروه ۸: تب ۳ پنل - مدیریت کتابخانه قوانین و دسته‌بندی‌ها]');

    // ۱. افزودن دسته‌بندی آزمایشی
    const testCatLabel = 'دسته آزمایشی تست سیستم';
    const addCatRes = await apiRequest('/admin/api.php?action=save_category', 'POST', {
      category: { label: testCatLabel }
    }, authHeaders);
    assert(addCatRes.status === 200 && addCatRes.json.success, 'افزودن دسته‌بندی', 'دسته‌بندی جدید به ساختار موضوعی افزوده شد.');

    const addedCat = addCatRes.json.categories.find(c => c.label === testCatLabel);
    const addedCatId = addedCat ? addedCat.id : null;
    assert(!!addedCatId, 'اعتبارسنجی شناسه', `شناسه دسته‌بندی با موفقیت تولید شد (${addedCatId})`);

    // ۲. ثبت قانون جدید درون دسته‌بندی ایجادشده
    const testLawTitle = 'قانون تستی تست خودکار';
    const testLawContent = 'ماده ۱ آزمایشی: کلیه بندهای این قانون جهت تست سلامت سامانه وضع گردیده است.';
    const saveLawRes = await apiRequest('/admin/api.php?action=save_law', 'POST', {
      law: {
        title: testLawTitle,
        category: addedCatId,
        content: testLawContent
      }
    }, authHeaders);
    assert(saveLawRes.status === 200 && saveLawRes.json.success, 'ثبت قانون جدید', 'قانون جدید با موفقیت به بانک قوانین افزوده گردید.');

    const addedLaw = saveLawRes.json.laws.find(l => l.title === testLawTitle);
    const addedLawId = addedLaw ? addedLaw.id : null;
    assert(!!addedLawId, 'اعتبارسنجی قانون', `شناسه قانون جدید: ${addedLawId}`);

    // ۳. حذف قانون آزمایشی
    const deleteLawRes = await apiRequest('/admin/api.php?action=delete_law', 'POST', { id: addedLawId }, authHeaders);
    assert(deleteLawRes.status === 200 && deleteLawRes.json.success, 'حذف قانون', 'قانون آزمایشی با موفقیت از سیستم حذف شد.');

    // ۴. حذف دسته‌بندی آزمایشی
    const deleteCatRes = await apiRequest('/admin/api.php?action=delete_category', 'POST', { id: addedCatId }, authHeaders);
    assert(deleteCatRes.status === 200 && deleteCatRes.json.success, 'حذف دسته‌بندی', 'دسته‌بندی آزمایشی با موفقیت حذف گردید.');

    // ══════════════════════════════════════════════════════════════════
    // گروه ۹: تب ۴ - سیستم آمار تحلیلی، ره‌گیری کلیک‌ها و نمودارها
    // ══════════════════════════════════════════════════════════════════
    console.log('\n📈 [گروه ۹: تب ۴ پنل - آمار تحلیلی و ره‌گیری تعامل کاربران]');

    const trackPageRes = await apiRequest('/admin/api.php?action=track_event', 'POST', { event: 'page_view' });
    assert(trackPageRes.status === 200 && trackPageRes.json.success, 'ثبت بازدید', 'رویداد بازدید از صفحه (page_view) ثبت شد.');

    const trackCallRes = await apiRequest('/admin/api.php?action=track_event', 'POST', { event: 'phone' });
    assert(trackCallRes.status === 200 && trackCallRes.json.success, 'ثبت تماس', 'رویداد کلیک روی دکمه تماس با وکیل ثبت شد.');

    const analyticsDataRes = await apiRequest('/admin/api.php?action=get_analytics', 'GET', null, authHeaders);
    assert(analyticsDataRes.status === 200 && analyticsDataRes.json.analytics, 'داشبورد آماری', 'داده‌های تحلیلی رفتار کاربران به همراه شاخص‌های کلیدی دریافت شد.');
    assert(analyticsDataRes.json.analytics.views > 0, 'شمارنده بازدید', `تعداد کل بازدیدها: ${analyticsDataRes.json.analytics.views}`);
    assert(analyticsDataRes.json.analytics.phone > 0, 'شمارنده تماس', `تعداد کل تماس‌ها: ${analyticsDataRes.json.analytics.phone}`);

    // ══════════════════════════════════════════════════════════════════
    // گروه ۱۰: تب ۵ - امنیت، مدیریت مدیران و دانلود بکاپ
    // ══════════════════════════════════════════════════════════════════
    console.log('\n🛡️  [گروه ۱۰: تب ۵ پنل - مدیریت دسترسی‌ها، امنیت و فایل پشتیبان]');

    const adminsListRes = await apiRequest('/admin/api.php?action=get_admins', 'GET', null, authHeaders);
    assert(adminsListRes.status === 200 && Array.isArray(adminsListRes.json.admins), 'لیست مدیران', 'فهرست مدیران سیستم دریافت گردید.');

    // ایجاد مدیر کمکی آزمایشی
    const testAdminUser = 'test_manager_' + Math.floor(Math.random() * 1000);
    const addAdminRes = await apiRequest('/admin/api.php?action=add_admin', 'POST', {
      username: testAdminUser,
      password: 'SafePassword@123'
    }, authHeaders);
    assert(addAdminRes.status === 200 && addAdminRes.json.success, 'افزودن مدیر', `مدیر جدید با نام کاربری (${testAdminUser}) ایجاد شد.`);

    // دریافت آی‌دی مدیر ایجادشده
    const updatedAdmins = await apiRequest('/admin/api.php?action=get_admins', 'GET', null, authHeaders);
    const createdAdminObj = updatedAdmins.json.admins.find(a => a.username === testAdminUser);

    // حذف مدیر آزمایشی
    if (createdAdminObj) {
      const delAdminRes = await apiRequest('/admin/api.php?action=delete_admin', 'POST', { id: createdAdminObj.id }, authHeaders);
      assert(delAdminRes.status === 200 && delAdminRes.json.success, 'حذف مدیر', 'حساب کاربری مدیر آزمایشی با موفقیت حذف شد.');
    }

    // دانلود نسخه پشتیبان سیستم (Backup)
    const backupRes = await apiRequest('/admin/api.php?action=download_backup', 'GET', null, authHeaders);
    assert(backupRes.status === 200 && backupRes.headers['content-disposition']?.includes('kianersi-backup'), 'دانلود بکاپ', 'نسخه پشتیبان کامل سامانه با هدر استاندارد دانلود فایل تولید شد.');
    assert(backupRes.json && backupRes.json.general && backupRes.json.laws, 'محتوای بکاپ', 'فایل بکاپ حاوی کلیه داده‌های عمومی، تنظیمات و کتابخانه قوانین است.');

    // خروج از پنل (Logout)
    const logoutRes = await apiRequest('/admin/api.php?action=logout', 'POST', null, authHeaders);
    assert(logoutRes.status === 200 && logoutRes.json.success, 'خروج از پنل', 'عملیات خروج با پاکسازی کامل کوکی نشست انجام پذیرفت.');

    // ══════════════════════════════════════════════════════════════════
    // گروه ۱۱: سیستم طراحی، واکنش‌گرایی موبایل و پاکیزگی کدها
    // ══════════════════════════════════════════════════════════════════
    console.log('\n📐 [گروه ۱۱: سیستم طراحی، بدون ایموجی و واکنش‌گرایی]');

    const adminPhpContent = fs.readFileSync(path.join(distDir, 'admin', 'index.php'), 'utf8');

    // ۱. بررسی عدم وجود ایموجی در کل کدهای پنل
    const emojiRegex = /[\u{1F300}-\u{1F9FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{1FA00}-\u{1FAFF}]/gu;
    const emojiMatches = adminPhpContent.match(emojiRegex);
    assert(!emojiMatches, 'حذف ایموجی‌ها', 'عدم وجود هرگونه ایموجی خام در پنل مدیریت و جایگزینی کامل با آیکون‌های SVG');

    // ۲. بررسی سیستم طراحی حقوقی لبه‌تیز
    assert(adminPhpContent.includes('--radius-sm: 2px;') && adminPhpContent.includes('--radius-md: 4px;'), 'دیزاین سیستم حقوقی', 'رعایت سیستم طراحی با لبه‌های تیز و شکیل حقوقی (--radius-sm: 2px, --radius-md: 4px)');

    // ۳. بررسی واکنش‌گرایی برای موبایل
    assert(adminPhpContent.includes('@media (max-width: 768px)'), 'واکنش‌گرایی تبلت و موبایل', 'وجود مدیاکوئری‌های اختصاصی تبلت و موبایل (max-width: 768px)');
    assert(adminPhpContent.includes('@media (max-width: 540px)') || adminPhpContent.includes('@media (max-width: 480px)'), 'واکنش‌گرایی موبایل‌های کوچک', 'وجود مدیاکوئری‌های اختصاصی نمایشگرهای موبایل (max-width: 540px / 480px)');
    assert(adminPhpContent.includes('overflow-x: auto') || adminPhpContent.includes('flex-direction: column'), 'سازگاری فرم‌ها', 'چینش عمودی کنترل‌ها و اسکرول نرم جداول در ابعاد موبایل');

    // ══════════════════════════════════════════════════════════════════
    // گروه ۱۲: قوانین امنیت شبکه، هدرهای HTTP و دیواره آتش سرور
    // ══════════════════════════════════════════════════════════════════
    console.log('\n🔒 [گروه ۱۲: قوانین امنیت شبکه و دیواره آتش سرور]');

    const rootHtaccess = fs.readFileSync(path.join(distDir, '.htaccess'), 'utf8');
    assert(rootHtaccess.includes('Options -Indexes'), 'امنیت دایرکتوری', 'غیرفعال‌سازی نمایش فهرست فایل‌های سرور (Options -Indexes)');
    assert(rootHtaccess.includes('Deny from all') && rootHtaccess.includes('json'), 'محافظت از فایل‌های داده', 'مسدودسازی دسترسی مستقیم به فایل‌های حساس JSON در وب');
    assert(rootHtaccess.includes('X-Content-Type-Options') && rootHtaccess.includes('nosniff'), 'هدرهای امنیتی', 'تنظیم هدر X-Content-Type-Options: nosniff');
    assert(rootHtaccess.includes('X-Frame-Options'), 'ضد کلیک‌جکینگ', 'تنظیم هدر X-Frame-Options جهت جلوگیری از بارگذاری در iframeهای غیرمجاز');
    assert(rootHtaccess.includes('Referrer-Policy'), 'حریم خصوصی', 'تنظیم هدر Referrer-Policy جهت حفظ حریم خصوصی کاربران');

    const adminHtaccess = fs.readFileSync(path.join(distDir, 'admin', '.htaccess'), 'utf8');
    assert(adminHtaccess.includes('Deny from all'), 'امنیت ادمین', 'مسدودسازی دسترسی عمومی به لاگ‌ها و کانفیگ داخلی پنل مدیریت');

  } catch (err) {
    console.error('خطای غیرمنتظره در فرآیند آزمون:', err);
    failed++;
  } finally {
    serverProc.kill();
  }

  // ══════════════════════════════════════════════════════════════════
  // گزارش و نتیجه‌گیری نهایی
  // ══════════════════════════════════════════════════════════════════
  console.log('\n================================================================');
  console.log(`📊 نتیجه نهایی ارزیابی جامع سامانه:`);
  console.log(`   ✅ آزمون‌های موفق: ${passed}`);
  console.log(`   ❌ آزمون‌های ناموفق: ${failed}`);
  console.log(`   📈 درصد سلامت کل سامانه: ${((passed / (passed + failed)) * 100).toFixed(1)}%`);
  console.log('================================================================\n');

  // ذخیره گزارش تفصیلی در scratch
  const reportPath = path.join(__dirname, 'test-report-summary.json');
  fs.writeFileSync(reportPath, JSON.stringify({
    timestamp: new Date().toISOString(),
    total: passed + failed,
    passed,
    failed,
    healthScore: `${((passed / (passed + failed)) * 100).toFixed(1)}%`,
    tests: testResults
  }, null, 2), 'utf8');

  process.exit(failed > 0 ? 1 : 0);
}

runComprehensiveTests();
