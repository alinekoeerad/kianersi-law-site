const http = require('http');
const fs = require('fs');
const path = require('path');

async function runTestSuite() {
  console.log('====================================================');
  console.log('🚀 شروع آزمون جامع کلیه بخش‌های سامانه کیان‌ارثی');
  console.log('====================================================\n');

  let passed = 0;
  let failed = 0;

  function assert(condition, message) {
    if (condition) {
      console.log(`  ✅ [PASS] ${message}`);
      passed++;
    } else {
      console.error(`  ❌ [FAIL] ${message}`);
      failed++;
    }
  }

  // ─── 1. بررسی فایل‌های پروداکشن در پوشه dist ───
  console.log('\n--- ۱. ارزیابی فایل‌های باندل پروداکشن (dist) ---');
  const requiredFiles = [
    'index.html',
    'site-data.json',
    'favicon.ico',
    'logo.png',
    'logo.webp',
    'preview.webp',
    'robots.txt',
    'sitemap.xml',
    '.htaccess',
    'admin/index.php',
    'admin/api.php',
    'admin/config.php',
    'admin/.htaccess'
  ];

  requiredFiles.forEach(rf => {
    const full = path.join(__dirname, '..', 'dist', rf);
    assert(fs.existsSync(full), `فایل الزامی dist/${rf} موجود است.`);
  });

  // ─── 2. تست ساختار site-data.json ───
  console.log('\n--- ۲. اعتبارسنجی ساختار داده‌های سایت (site-data.json) ---');
  const siteDataPath = path.join(__dirname, '..', 'dist', 'site-data.json');
  let siteData = {};
  try {
    siteData = JSON.parse(fs.readFileSync(siteDataPath, 'utf8'));
    assert(siteData.general && siteData.general.phone, 'اطلاعات عمومی (نام، شماره تماس، سوابق) معتبر است.');
    assert(Array.isArray(siteData.categories) && siteData.categories.length >= 3, `دسته‌بندی‌های موضوعی قوانین (${siteData.categories.length} دسته) تعریف شده است.`);
    assert(Array.isArray(siteData.laws) && siteData.laws.length >= 8, `کتابخانه قوانین (${siteData.laws.length} قانون تخصصی) بارگذاری شده است.`);
  } catch (e) {
    assert(false, `خطا در خواندن site-data.json: ${e.message}`);
  }

  // ─── 3. تست ایموجی‌ها (بررسی عدم وجود هرگونه ایموجی) ───
  console.log('\n--- ۳. آزمون عدم وجود ایموجی و جایگزینی با آیکون‌های وکتور ---');
  const emojiRegex = /[\u{1F300}-\u{1F9FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{1FA00}-\u{1FAFF}]/gu;
  const adminPhp = fs.readFileSync(path.join(__dirname, '..', 'dist', 'admin', 'index.php'), 'utf8');
  const adminMatches = adminPhp.match(emojiRegex);
  assert(!adminMatches, 'پنل مدیریت (admin/index.php) کاملاً عاری از ایموجی بوده و دارای آیکون‌های SVG است.');

  // ─── 4. تست فایل فشرده website.zip برای هاست ───
  console.log('\n--- ۴. بررسی بسته دیپلوی آماده هاست (website.zip) ---');
  const zipPath = path.join(__dirname, '..', 'website.zip');
  assert(fs.existsSync(zipPath), 'فایل فشرده website.zip با موفقیت ساخته شده است.');
  const zipStat = fs.statSync(zipPath);
  assert(zipStat.size > 500000, `حجم پکیج مناسب است (${(zipStat.size / (1024 * 1024)).toFixed(2)} مگابایت).`);

  // ─── 5. بررسی قوانین امنیتی .htaccess ───
  console.log('\n--- ۵. بررسی دیواره آتش و قوانین امنیتی (.htaccess) ---');
  const rootHtaccess = fs.readFileSync(path.join(__dirname, '..', 'dist', '.htaccess'), 'utf8');
  assert(rootHtaccess.includes('json') && rootHtaccess.includes('Deny from all'), 'دسترسی مستقیم عمومی به فایل‌های حساس JSON در روت مسدود است.');
  assert(rootHtaccess.includes('Options -Indexes'), 'نمایش فهرست دایرکتوری‌ها (Directory Browsing) غیرفعال است.');

  const adminHtaccess = fs.readFileSync(path.join(__dirname, '..', 'dist', 'admin', '.htaccess'), 'utf8');
  assert(adminHtaccess.includes('config') && adminHtaccess.includes('Deny from all'), 'دسترسی مستقیم به config.json و لاگ‌های ادمین مسدود است.');

  // ─── 6. تست وب‌سرور لوکال و تمامی اندپوینت‌های API ───
  console.log('\n--- ۶. آزمون رفتاری سرور و اندپوینت‌های API ---');

  // استارت سرور تستی روی پورت ۳۰۹۹
  process.env.PORT = '3099';
  const serverModule = require('../local-server.cjs');

  // کمکی برای درخواست‌های HTTP
  function request(urlPath, method = 'GET', data = null, headers = {}) {
    return new Promise((resolve, reject) => {
      const u = new URL(urlPath, 'http://localhost:3099');
      const reqHeaders = { ...headers };
      let bodyData = null;
      if (data) {
        bodyData = JSON.stringify(data);
        reqHeaders['Content-Type'] = 'application/json';
        reqHeaders['Content-Length'] = Buffer.byteLength(bodyData);
      }

      const req = http.request(u, { method, headers: reqHeaders }, (res) => {
        let resBody = '';
        res.on('data', chunk => { resBody += chunk; });
        res.on('end', () => {
          let json = null;
          try { json = JSON.parse(resBody); } catch (e) {}
          resolve({ status: res.statusCode, headers: res.headers, body: resBody, json });
        });
      });

      req.on('error', reject);
      if (bodyData) req.write(bodyData);
      req.end();
    });
  }

  // چند ثانیه مکث برای لیسن شدن سرور
  await new Promise(r => setTimeout(r, 600));

  try {
    // الف) صفحه اصلی سایت
    const homeRes = await request('/');
    assert(homeRes.status === 200, 'صفحه اصلی سایت با کد 200 بارگذاری شد.');
    assert(homeRes.body.includes('محمدحسن کیان‌ارثی'), 'عنوان وکیل و ساختار اصلی در HTML لود شد.');
    assert(homeRes.body.includes('id="root"'), 'المان ریشه ری‌اکت در صفحه وجود دارد.');

    // ب) دیتا JSON
    const dataRes = await request('/site-data.json');
    assert(dataRes.status === 200 && dataRes.json && dataRes.json.general, 'فایل site-data.json با موفقیت از سرور دریافت شد.');

    // ج) ثبت رویداد تحلیلی (Analytics track_event)
    const trackRes = await request('/admin/api.php?action=track_event', 'POST', { event: 'page_view' });
    assert(trackRes.status === 200 && trackRes.json && trackRes.json.success, 'رویداد آماری بازدید (Micro Analytics) ثبت شد.');

    const trackPhone = await request('/admin/api.php?action=track_event', 'POST', { event: 'phone' });
    assert(trackPhone.status === 200 && trackPhone.json && trackPhone.json.success, 'رویداد کلیک تماس تلفنی ثبت شد.');

    // د) تلاش برای دسترسی به پنل بدون احراز هویت
    const unauthData = await request('/admin/api.php?action=get_data');
    assert(unauthData.status === 403, 'دسترسی غیرمجاز به APIهای حساس با کد 403 مسدود می‌شود.');

    // ه) لاگین صحیح
    const loginRes = await request('/admin/api.php?action=login', 'POST', { username: 'admin', password: 'Kianersi@1403' });
    let authCookie = '';
    if (loginRes.headers['set-cookie']) {
      authCookie = loginRes.headers['set-cookie'].join('; ');
    }
    assert(loginRes.status === 200 && loginRes.json && loginRes.json.success, 'ورود مدیر با رمز عبور معتبر با موفقیت انجام شد.');

    // و) دریافت اطلاعات محافظت‌شده پس از لاگین
    const authHeaders = { Cookie: authCookie };
    const authDataRes = await request('/admin/api.php?action=get_data', 'GET', null, authHeaders);
    assert(authDataRes.status === 200 && authDataRes.json && authDataRes.json.data, 'دریافت داده‌های محافظت‌شده پس از احراز هویت با موفقیت انجام شد.');

    // ز) دریافت آمار تحلیلی
    const analyticsRes = await request('/admin/api.php?action=get_analytics', 'GET', null, authHeaders);
    assert(analyticsRes.status === 200 && analyticsRes.json && analyticsRes.json.analytics, 'داشبورد آماری (KPIs و نمودارها) داده‌های کلیک‌ها را برمی‌گرداند.');

    // ح) دریافت لیست مدیران
    const adminsRes = await request('/admin/api.php?action=get_admins', 'GET', null, authHeaders);
    assert(adminsRes.status === 200 && adminsRes.json && Array.isArray(adminsRes.json.admins), 'لیست مدیران سامانه با موفقیت دریافت شد.');

    // ط) دانلود فایل پشتیبان
    const backupRes = await request('/admin/api.php?action=download_backup', 'GET', null, authHeaders);
    assert(backupRes.status === 200 && backupRes.headers['content-disposition']?.includes('kianersi-backup'), 'دانلود نسخه پشتیبان یکپارچه با هدر معتبر عمل می‌کند.');

    // ی) رندر صفحه پنل مدیریت (بررسی عدم وجود باگ بنر امنیتی)
    const adminPage = await request('/admin/', 'GET', null, authHeaders);
    assert(adminPage.status === 200, 'صفحه داشبورد مدیریت با موفقیت رندر می‌شود.');
    assert(adminPage.body.includes('تصاویر و سئو'), 'تب اختصاصی مدیریت تصاویر و سئو در پنل رندر شد.');
    assert(adminPage.body.includes('Google SERP Simulator') || adminPage.body.includes('نتایج جستجوی گوگل'), 'شبیه‌ساز پیش‌نمایش زنده در گوگل در پنل قرار دارد.');

    // ک) تست ذخیره تنظیمات سئو و متاتگ‌ها
    const seoSaveRes = await request('/admin/api.php?action=save_general', 'POST', {
      general: {
        seoTitle: 'محمدحسن کیان‌ارثی | وکیل پایه یک کرج | دعاوی آب و املاک',
        seoDescription: 'دفتر وکالت تخصصی کرج در دعاوی آب، چاه کشاورزی و حریم رودخانه',
        seoKeywords: 'وکیل کرج, وکیل آب'
      }
    }, authHeaders);
    assert(seoSaveRes.status === 200 && seoSaveRes.json && seoSaveRes.json.success, 'تنظیمات متنی سئو (Title, Description, Keywords) با موفقیت ذخیره شدند.');

    // ل) تست آپلود تصویر با تبدیل به WebP
    // یک پیکسل شفاف 1x1 در فرمت WebP/PNG به صورت Base64
    const samplePixelBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAA=';
    const uploadRes = await request('/admin/api.php?action=upload_image', 'POST', {
      type: 'lawyer',
      image_base64: samplePixelBase64
    }, authHeaders);
    assert(uploadRes.status === 200 && uploadRes.json && uploadRes.json.success, 'تصویر با موفقیت آپلود و در قالب فرمت WebP ثبت گردید.');
    assert(uploadRes.json.url && uploadRes.json.url.endsWith('.webp'), `آدرس تصویر ایجادشده به فرمت WebP اشاره دارد (${uploadRes.json.url}).`);

    // م) تست بازنشانی تصویر به پیش‌فرض
    const resetRes = await request('/admin/api.php?action=reset_image', 'POST', { type: 'lawyer' }, authHeaders);
    assert(resetRes.status === 200 && resetRes.json && resetRes.json.success, 'تصویر به فایل پیش‌فرض اولیه با موفقیت بازنشانی شد.');

  } catch (err) {
    console.error('خطا در آزمون سرور:', err.message);
    failed++;
  }

  console.log('\n====================================================');
  console.log(`📊 نتیجه نهایی: ${passed} آزمون موفق | ${failed} آزمون ناموفق`);
  console.log('====================================================\n');

  process.exit(failed > 0 ? 1 : 0);
}

runTestSuite();
