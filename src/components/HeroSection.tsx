// Import necessary UI components
import { SectionLabel, OrnamentDivider, StatCard } from './SharedUI';

export default function HeroSection() {
  return (
    <section id="hero" className="relative overflow-hidden bg-deep">
      {/* Background image overlay */}
      <div className="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-20 mix-blend-overlay"
        style={{ backgroundImage: "url('./images/hero-bg.webp')" }} />
      
      {/* Decorative corner borders for desktop screens */}
      <div className="absolute top-8 right-8 w-24 h-24 opacity-20 hidden md:block"
        style={{ border: '1px solid #0e7490', borderLeft: 'none', borderBottom: 'none' }} />
      <div className="absolute top-8 left-8 w-24 h-24 opacity-20 hidden md:block"
        style={{ border: '1px solid #0e7490', borderRight: 'none', borderBottom: 'none' }} />

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-10 md:pt-16 pb-0">
        {/* Top section label and divider */}
        <div className="text-center mb-8">
          <SectionLabel>پرونده ویژه — حقوق آب و اراضی</SectionLabel>
          <OrnamentDivider className="max-w-lg mx-auto" />
        </div>

        {/* Main hero grid layout */}
        <div className="grid md:grid-cols-12 gap-6 md:gap-0 items-start">
          
          {/* Right Column: Title, description, CTA buttons, and statistics */}
          <div className="md:col-span-5 md:pt-4 order-2 md:order-1 pb-10 md:pb-0">
            <div className="md:pl-8">
              <SectionLabel className="mb-3">تخصص و سوابق وکالت</SectionLabel>
              
              <h1 className="text-2xl md:text-3xl lg:text-4xl mb-3 leading-snug font-bold" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                محمدحسن کیان‌ارثی<br />
                <span className="text-xl md:text-2xl font-light text-cyan-200">وکیل پایه یک دادگستری کرج</span>
              </h1>

              <p className="text-sm md:text-base mb-5 font-medium leading-relaxed" style={{ color: '#7dd3fc', fontFamily: 'Noto Naskh Arabic, serif' }}>
                متخصص دعاوی حقوقی منابع آب، کمیسیون‌های آب‌های زیرزمینی و دیوان عدالت اداری
              </p>

              <div className="styled-hr my-4" />

              {/* Comprehensive 20-year experience text */}
              <p className="body-text text-sm leading-8 mb-6 text-justify" style={{ color: '#e2e8f0', fontFamily: 'Noto Sans Arabic' }}>
                بیش از ۲۰ سال تجربه تخصصی در حوزه حقوق آب، دعاوی حقوقی و اداری، دفاع از پرونده‌های مطروحه در محاکم قضایی و دیوان عدالت اداری، عضویت در کمیسیون‌های تخصصی وزارت نیرو و ارائه مشاوره حقوقی در طرح‌های ملی انتقال آب، استملاک اراضی و پروژه‌های عمرانی.
              </p>

              {/* High-Converting CTA Buttons */}
              <div className="flex flex-col sm:flex-row gap-3 my-6">
                <a 
                  href="tel:+989127698864" 
                  className="flex items-center justify-center gap-2 px-5 py-3 text-xs md:text-sm font-semibold rounded-sm transition-all duration-300 hover:brightness-110 shadow-lg text-center"
                  style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic' }}
                >
                  <span>📞</span>
                  <span>تماس و مشاوره فوری: ۰۹۱۲۷۶۹۸۸۶۴</span>
                </a>
                
                <a 
                  href="#contact" 
                  className="flex items-center justify-center gap-2 px-4 py-3 text-xs md:text-sm font-medium rounded-sm transition-all duration-300 hover:bg-cyan-900/40 text-center"
                  style={{ border: '1px solid rgba(14,116,144,0.6)', color: '#7dd3fc', fontFamily: 'Noto Sans Arabic' }}
                >
                  <span>📍</span>
                  <span>نشانی دفتر و اطلاعات تماس</span>
                </a>
              </div>

              {/* Statistics cards */}
              <div className="grid grid-cols-3 mt-6 rounded-sm overflow-hidden" style={{ border: '1px solid rgba(14,116,144,0.4)', backgroundColor: 'rgba(10,30,40,0.5)' }}>
                <StatCard number="۲۰" label="سال تجربه" suffix="+" hasBorderLeft={true} />
                <StatCard number="۱۳" label="سال در کمیسیون" hasBorderLeft={true} />
                <div className="text-center py-3 sm:py-6 px-1.5 sm:px-4">
                  <div className="stat-number text-2xl sm:text-4xl md:text-5xl mb-1 sm:mb-2" style={{ fontFamily: 'Playfair Display, serif' }}>M.A</div>
                  <div className="text-[10px] sm:text-xs tracking-tight sm:tracking-widest section-label">حقوق بین‌الملل</div>
                </div>
              </div>
            </div>
          </div>

          {/* Center Column: Lawyer's portrait and name plate */}
          <div className="md:col-span-4 order-1 md:order-2 flex justify-center md:block">
            <div className="relative editorial-frame mx-auto max-w-[320px] md:max-w-[380px]">
              <img 
                src="./images/lawyer-portrait.webp" 
                alt="محمدحسن کیان‌ارثی وکیل پایه یک دادگستری کرج و متخصص دعاوی آب و اراضی" 
                title="محمدحسن کیان‌ارثی وکیل دادگستری کرج"
                className="w-full object-cover h-[360px] md:h-[520px]"
                style={{ objectPosition: 'center top', filter: 'saturate(0.9) contrast(1.05)' }} 
              />
              
              {/* Gradient overlay for text readability */}
              <div className="absolute bottom-0 right-0 left-0 p-5 pt-16" 
                style={{ background: 'linear-gradient(to top, rgba(2,15,26,0.95) 0%, rgba(2,15,26,0.8) 40%, transparent 100%)' }}>
                <p className="masthead-title text-xl md:text-2xl font-bold drop-shadow-2xl" 
                  style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif', textShadow: '0px 2px 8px rgba(0,0,0,0.9)' }}>
                  محمدحسن کیان‌ارثی
                </p>
                <p className="text-xs mt-1 font-medium" 
                  style={{ color: '#7dd3fc', fontFamily: 'Noto Sans Arabic', letterSpacing: '0.05em', textShadow: '0px 1px 5px rgba(0,0,0,0.9)' }}>
                  وکیل پایه یک دادگستری
                </p>
              </div>
            </div>
          </div>

          {/* Left Column: Key executive records and quick expertise list */}
          <div className="md:col-span-3 order-3 md:pt-4 pb-10 md:pb-0">
            <div className="md:pr-4">
              {/* Key Executive Records Box */}
              <div className="p-4 mb-6 rounded-sm" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', color: '#ffffff', border: '1px solid rgba(14,116,144,0.3)' }}>
                <p className="section-label mb-2" style={{ color: '#7dd3fc' }}>سوابق کلیدی</p>
                <p className="text-xs md:text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.9)' }}>
                  عضو حقوقی کمیسیون صدور پروانه چاه به مدت ۵ سال
                </p>
                <div className="my-2 h-px" style={{ backgroundColor: 'rgba(14,116,144,0.4)' }} />
                <p className="text-xs md:text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.9)' }}>
                  عضو حقوقی کمیسیون رسیدگی به اعتراضات بستر وحریم رودخانه ها (هیات سه نفره موضوع ماده ۳) به مدت ۱۳ سال
                </p>
                <div className="my-2 h-px" style={{ backgroundColor: 'rgba(14,116,144,0.4)' }} />
                <p className="text-xs md:text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.9)' }}>
                  ۱۴ سال کارشناس حقوقی امور آب کرج و فعالیت در دفتر حقوقی شرکت آب منطقه‌ای تهران
                </p>
              </div>

              {/* Approach Quote Box */}
              <div className="p-4 mb-6" style={{ borderRight: '3px solid #0e7490', backgroundColor: 'rgba(14,116,144,0.08)' }}>
                <p className="text-xs md:text-sm leading-7 italic text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc' }}>
                  دقت در تحلیل پرونده، راهبردی متفاوت برای احقاق حق موکل در پیچیده‌ترین دعاوی دستگاه‌های اجرایی.
                </p>
              </div>

              {/* Simplified Expertise List */}
              <p className="section-label mb-3" style={{ color: '#7dd3fc' }}>حوزه‌های تخصصی</p>
              <div className="space-y-2">
                {['حقوق آب و منابع آبی', 'دیوان عدالت اداری', 'استملاک و تملک اراضی', 'قراردادهای اداری', 'دعاوی دستگاه‌های اجرایی'].map(area => (
                  <div key={area} className="flex items-center gap-2 text-xs" style={{ color: '#e2e8f0', fontFamily: 'Noto Sans Arabic' }}>
                    <span style={{ color: '#38bdf8', fontSize: '0.5rem' }}>◆</span> {area}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Banner Title */}
        <div className="mt-14 mb-10 py-8 text-center border-t border-b" style={{ borderColor: 'rgba(14,116,144,0.3)' }}>
          <h2 className="article-title text-xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight" style={{ fontFamily: 'Noto Naskh Arabic, serif', fontWeight: 700, color: '#ffffff' }}>
            رویکردی نوین و مقتدرانه در حقوق تخصصی آب و اراضی
          </h2>
        </div>
      </div>
    </section>
  );
}
