// Import required UI components
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function AboutSection() {
  // Define certificates data arrays for organized rendering
  const waterCertificates = [
    'دوره قوانین و دستورالعمل‌های جاری بهره‌برداری منابع آب - وزارت نیرو (۱۴۰۰)',
    'دوره کلیات حقوق آب - وزارت نیرو (۱۳۹۸)',
    'دوره حقوق قراردادها و معاهدات آب - دانشگاه شهید بهشتی (۱۴۰۰)'
  ];

  const adminCertificates = [
    'دوره قانون اساسی - وزارت نیرو (۱۴۰۱)',
    'دوره آشنایی با قانون محاسبات عمومی - دانشگاه شهید بهشتی (۱۴۰۰)',
    'دوره آشنایی با قراردادهای اداری - دانشگاه شهید بهشتی (۱۴۰۰)'
  ];

  const financeCertificates = [
    'دوره حقوق مالی - وزارت نیرو (۱۴۰۱)',
    'دوره قانون تجارت - دانشگاه شهید بهشتی (۱۳۹۹)',
    'دوره آشنایی با مسائل حقوقی و قراردادهای بازرگانی - وزارت نیرو (۱۳۹۷)'
  ];

  const otherCertificates = [
    'گواهینامه دوره امنیت کاربری فناوری اطلاعات از موسسه آموزش و پژوهش آروین (۱۴۰۰)',
    'دوره قانون کار و تأمین اجتماعی (۱۳۹۷)',
    'دوره پولشویی (۱۳۹۶)',
    'دوره پدافند غیرعامل (۱۳۹۸)',
    'دوره شناخت تهدیدات مشترک صنعت آب و برق (۱۴۰۱)'
  ];

  return (
    <section id="about" className="py-20 bg-deep">
      <div className="max-w-7xl mx-auto px-6">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>سرمقاله ویژه</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              مدیریت و صیانت از منابع حیاتی
            </h2>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Main Content Grid */}
        <div className="magazine-grid">
          
          {/* Left Column: Editorials, Quote, and National Projects */}
          <AnimSection>
            <div>
              <p className="body-text text-justify mb-6 text-base leading-9" style={{ fontFamily: 'Noto Naskh Arabic, serif', fontSize: '1.05rem' }}>
                در سپهر حقوقی معاصر، مدیریت و صیانت از منابع حیاتی نظیر آب و اراضی، نه یک امر اداری ساده، بلکه حوزه‌ای استراتژیک، فنی و به‌شدت تخصصی است. پرونده‌های این عرصه به جهت تداخل منافع حاکمیتی و حقوق مالکانه اشخاص، نیازمند هوشمندی قضایی، تسلط بی‌بدیل بر مقررات موضوعه و شناخت دقیق از فرآیندهای اجرایی است.
              </p>
              
              <div className="newspaper-columns mt-6">
                <p className="body-text text-sm leading-9 mb-4 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                  آقای محمدحسن کیان‌ارثی با توشه‌ای دوجانبه از دانش آکادمیک و «بیش از دو دهه حضور کلیدی در دفاتر حقوقی شرکت‌های آب منطقه‌ای تهران و البرز»، به عنوان یکی از خوش‌نام‌ترین و خبره‌ترین وکلای این حوزه تخصصی در پایتخت و استان البرز شناخته می‌شوند. طرح و دفاع از دعاوی در محاکم عمومی، دادسراهای عمومی و انقلاب، دیوان عدالت اداری و سایر مراجع قضایی و شبه‌قضایی بخش مهمی از سوابق اجرایی ایشان است.
                </p>
                <p className="body-text text-sm leading-9 mb-4 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                  این تجارب گران‌سنگ، بستری بی‌بدیل برای دفاع علمی، مستدل و پیروزمندانه از حقوق موکلین فراهم آورده است. تجربه طولانی ایشان در ساختارهای حقوقی و سازمانی مرتبط با وزارت نیرو، در کنار دانش آکادمیک موجب شده تا در پرونده‌های حساس عملکردی قابل اتکا داشته باشند.
                </p>
              </div>

              {/* Floating Quote Box */}
              <div className="floating-quote mt-10 rounded-sm">
                <p className="text-base leading-9 text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif' }}>
                  “حقوق آب و اراضی ملی، عرصه‌ای نیست که بتوان در آن آزمون و خطا کرد. هرگونه اقدام نسنجیده یا تاخیر در مواجهه با تصمیمات اداری و آراء کمیسیون‌ها، می‌تواند به تضییع ابدی حقوق مکتسبه و دارایی‌های حیاتی شما منجر شود.”
                </p>
              </div>

              {/* National and Infrastructure Projects Section */}
              <div className="mt-12 p-6 rounded-sm" style={{ border: '1px solid rgba(14,116,144,0.3)', backgroundColor: 'rgba(10,30,40,0.6)' }}>
                <p className="section-label mb-4" style={{ color: '#7dd3fc' }}>سوابق تخصصی در طرح‌های ملی و عمرانی</p>
                <ul className="space-y-3">
                  {[
                    'کارشناس حقوقی طرح جلوگیری از آلودگی آب شرب تهران',
                    'کارشناس حقوقی طرح انتقال اهالی واریان ناشی از احداث سد کرج',
                    'کارشناس حقوقی طرح انتقال آب طالقان به نظرآباد و اشتهارد',
                    'کارشناس حقوقی استملاک و تملک اراضی و طرح‌های تملک دارایی‌های سرمایه‌ای',
                    'کارشناس حقوقی شرکت پلشیر'
                  ].map((project, idx) => (
                    <li key={idx} className="flex items-start gap-3 text-sm" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.85)' }}>
                      <span className="mt-1" style={{ color: '#0e7490' }}>■</span>
                      <span className="leading-7">{project}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          </AnimSection>

          {/* Right Column: Image and Professional Info Box */}
          <AnimSection delay={200}>
            <div className="space-y-6">
              {/* Image Box */}
              <div className="relative">
                <img
                  src="./images/water-pipe.webp"
                  alt="دعاوی دستگاه های اجرایی"
                  loading="lazy"
                  className="w-full object-cover rounded-sm image-glow"
                  style={{ height: '280px' }}
                />
                <div className="absolute inset-0 rounded-sm" style={{ background: 'linear-gradient(to bottom, transparent 50%, rgba(2,15,26,0.85))' }} />
                <div className="absolute bottom-4 right-4 left-4">
                  <p className="text-xs tracking-widest" style={{ color: '#7dd3fc', fontFamily: 'Noto Sans Arabic' }}>
                    صیانت از منابع آب و حقوق اراضی
                  </p>
                </div>
              </div>

              {/* Professional Information Card */}
              <div className="p-6 rounded-sm" style={{ border: '1px solid rgba(14,116,144,0.3)', backgroundColor: 'rgba(14,116,144,0.05)' }}>
                <p className="section-label mb-4">اطلاعات حرفه‌ای</p>
                <div className="space-y-4">
                  {[
                    { label: 'پروانه وکالت', value: 'وکیل پایه یک دادگستری' },
                    { label: 'عضویت', value: 'عضو رسمی کانون وکلای دادگستری البرز' },
                    { label: 'مدرک تحصیلی', value: 'کارشناس ارشد حقوق بین‌الملل' },
                    { label: 'سابقه خدمت', value: 'شرکت آب منطقه‌ای تهران و البرز' },
                  ].map(item => (
                    <div key={item.label} className="flex flex-col gap-1 pb-3" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)' }}>
                      <span className="text-xs" style={{ color: '#0e7490', fontFamily: 'Noto Sans Arabic', letterSpacing: '0.05em' }}>{item.label}</span>
                      <span className="text-sm font-medium" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>{item.value}</span>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </AnimSection>

        </div>

        {/* Certificates Section - Changed from dashed to solid line */}
        <AnimSection delay={300}>
          <div className="mt-20 pt-16" style={{ borderTop: '1px solid rgba(14,116,144,0.3)' }}>
            <div className="text-center mb-12">
              <SectionLabel>دانش تخصصی و آکادمیک</SectionLabel>
              <h3 className="text-2xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                گواهینامه‌های تخصصی اخذ شده
              </h3>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              
              {/* Category 1: Water & Natural Resources */}
              <div className="p-5 rounded-sm" style={{ backgroundColor: 'rgba(10,30,40,0.4)', border: '1px solid rgba(14,116,144,0.2)' }}>
                <h4 className="font-semibold text-sm mb-4 pb-2" style={{ color: '#7dd3fc', borderBottom: '1px solid rgba(14,116,144,0.3)', fontFamily: 'Noto Naskh Arabic, serif' }}>
                  زمینه آب و منابع طبیعی
                </h4>
                <ul className="space-y-3">
                  {waterCertificates.map((cert, i) => (
                    <li key={i} className="text-xs leading-6 text-gray-300" style={{ fontFamily: 'Noto Sans Arabic' }}>• {cert}</li>
                  ))}
                </ul>
              </div>

              {/* Category 2: Public & Administrative */}
              <div className="p-5 rounded-sm" style={{ backgroundColor: 'rgba(10,30,40,0.4)', border: '1px solid rgba(14,116,144,0.2)' }}>
                <h4 className="font-semibold text-sm mb-4 pb-2" style={{ color: '#7dd3fc', borderBottom: '1px solid rgba(14,116,144,0.3)', fontFamily: 'Noto Naskh Arabic, serif' }}>
                  عمومی و اداری
                </h4>
                <ul className="space-y-3">
                  {adminCertificates.map((cert, i) => (
                    <li key={i} className="text-xs leading-6 text-gray-300" style={{ fontFamily: 'Noto Sans Arabic' }}>• {cert}</li>
                  ))}
                </ul>
              </div>

              {/* Category 3: Financial & Economic */}
              <div className="p-5 rounded-sm" style={{ backgroundColor: 'rgba(10,30,40,0.4)', border: '1px solid rgba(14,116,144,0.2)' }}>
                <h4 className="font-semibold text-sm mb-4 pb-2" style={{ color: '#7dd3fc', borderBottom: '1px solid rgba(14,116,144,0.3)', fontFamily: 'Noto Naskh Arabic, serif' }}>
                  حقوق مالی و اقتصادی
                </h4>
                <ul className="space-y-3">
                  {financeCertificates.map((cert, i) => (
                    <li key={i} className="text-xs leading-6 text-gray-300" style={{ fontFamily: 'Noto Sans Arabic' }}>• {cert}</li>
                  ))}
                </ul>
              </div>

              {/* Category 4: Other Specialized */}
              <div className="p-5 rounded-sm" style={{ backgroundColor: 'rgba(10,30,40,0.4)', border: '1px solid rgba(14,116,144,0.2)' }}>
                <h4 className="font-semibold text-sm mb-4 pb-2" style={{ color: '#7dd3fc', borderBottom: '1px solid rgba(14,116,144,0.3)', fontFamily: 'Noto Naskh Arabic, serif' }}>
                  سایر دوره‌های مرتبط
                </h4>
                <ul className="space-y-3">
                  {otherCertificates.map((cert, i) => (
                    <li key={i} className="text-xs leading-6 text-gray-300" style={{ fontFamily: 'Noto Sans Arabic' }}>• {cert}</li>
                  ))}
                </ul>
              </div>

            </div>
          </div>
        </AnimSection>

      </div>
    </section>
  );
}