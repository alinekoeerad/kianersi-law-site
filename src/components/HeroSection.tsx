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

      <div className="relative z-10 max-w-7xl mx-auto px-6 pt-16 pb-0">
        {/* Top section label and divider */}
        <div className="text-center mb-8">
          <SectionLabel>پرونده ویژه — حقوق آب و اراضی</SectionLabel>
          <OrnamentDivider className="max-w-lg mx-auto" />
        </div>

        {/* Main hero grid layout */}
        <div className="grid md:grid-cols-12 gap-0 items-start">
          
          {/* Right Column: Title, description, and statistics */}
          <div className="md:col-span-5 md:pt-8 order-2 md:order-1 pb-10 md:pb-0">
            <div className="md:pl-8">
              <SectionLabel className="mb-4">تخصص و سوابق</SectionLabel>
              <h2 className="text-2xl md:text-3xl mb-6 leading-relaxed font-light" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                وکیل پایه یک دادگستری<br/>
                <em style={{ color: '#7dd3fc', fontStyle: 'normal', fontSize: '1.2rem' }}>متمرکز بر دعاوی حقوقی منابع آب در دیوان عدالت و دعاوی اداری</em>
              </h2>
              <div className="styled-hr" />
              {/* Comprehensive 20-year experience text */}
              <p className="body-text text-sm leading-8 mb-6 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                بیش از ۲۰ سال تجربه تخصصی در حوزه حقوق آب، دعاوی حقوقی و اداری، دفاع از پرونده‌های مطروحه در محاکم قضایی و دیوان عدالت اداری، عضویت در کمیسیون‌های تخصصی وزارت نیرو و ارائه مشاوره حقوقی در طرح‌های ملی انتقال آب، استملاک اراضی و پروژه‌های عمرانی.
              </p>
              {/* Statistics cards */}
              <div className="grid grid-cols-3 mt-8 rounded-sm overflow-hidden" style={{ border: '1px solid rgba(14,116,144,0.2)', borderLeft: 'none', backgroundColor: 'rgba(10,30,40,0.4)' }}>
                <StatCard number="۲۰" label="سال تجربه" suffix="+" />
                <StatCard number="۱۳" label="سال در کمیسیون" />
                <div className="text-center py-6 px-4">
                  <div className="stat-number text-5xl mb-2" style={{ fontFamily: 'Playfair Display, serif' }}>M.A</div>
                  <div className="text-xs tracking-widest section-label">حقوق بین‌الملل</div>
                </div>
              </div>
            </div>
          </div>

          {/* Center Column: Lawyer's portrait and name plate */}
          <div className="md:col-span-4 order-1 md:order-2 flex justify-center md:block">
            <div className="relative editorial-frame mx-auto" style={{ maxWidth: '380px' }}>
              <img src="./images/lawyer-portrait.webp" alt="محمدحسن کیان‌ارثی وکیل دادگستری" className="w-full object-cover"
                style={{ height: '520px', objectPosition: 'center top', filter: 'saturate(0.85) contrast(1.05)' }} />
              
              {/* Gradient overlay for text readability */}
              <div className="absolute bottom-0 right-0 left-0 p-5 pt-20" 
                style={{ background: 'linear-gradient(to top, rgba(2,15,26,0.95) 0%, rgba(2,15,26,0.8) 40%, transparent 100%)' }}>
                <p className="masthead-title text-2xl font-bold drop-shadow-2xl" 
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
          <div className="md:col-span-3 order-3 md:pt-8 pb-10 md:pb-0">
            <div className="md:pr-4">
              {/* Key Executive Records Box - Updated with exact required text */}
              <div className="p-4 mb-6 rounded-sm" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', color: '#ffffff', border: '1px solid rgba(14,116,144,0.2)' }}>
                <p className="section-label mb-2">سوابق کلیدی</p>
                <p className="text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.85)' }}>
                  عضو حقوقی کمیسیون صدور پروانه چاه به مدت ۵ سال
                </p>
                <div className="my-2 h-px" style={{ backgroundColor: 'rgba(14,116,144,0.4)' }} />
                <p className="text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.85)' }}>
                  عضو حقوقی کمیسیون رسیدگی به اعتراضات بستر وحریم رودخانه ها (هیات سه نفره موضوع ماده ۳) به مدت ۱۳ سال
                </p>
                <div className="my-2 h-px" style={{ backgroundColor: 'rgba(14,116,144,0.4)' }} />
                <p className="text-sm leading-relaxed text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.85)' }}>
                  ۱۴ سال کارشناس حقوقی امور آب کرج و فعالیت در دفتر حقوقی شرکت آب منطقه‌ای تهران
                </p>
              </div>

              {/* Approach Quote Box */}
              <div className="p-4 mb-6" style={{ borderRight: '3px solid #0e7490', backgroundColor: 'rgba(14,116,144,0.05)' }}>
                <p className="text-sm leading-8 italic text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc', fontSize: '0.9rem' }}>
                  دقت در تحلیل پرونده، راهبردی متفاوت برای احقاق حق موکل در پیچیده‌ترین دعاوی دستگاه‌های اجرایی.
                </p>
              </div>

              {/* Simplified Expertise List */}
              <p className="section-label mb-3">حوزه‌های تخصصی</p>
              <div className="space-y-2">
                {['حقوق آب و منابع آبی', 'دیوان عدالت اداری', 'استملاک و تملک اراضی', 'قراردادهای اداری', 'دعاوی دستگاه‌های اجرایی'].map(area => (
                  <div key={area} className="flex items-center gap-2 text-xs" style={{ color: '#e2e8f0', fontFamily: 'Noto Sans Arabic' }}>
                    <span style={{ color: '#0e7490', fontSize: '0.5rem' }}>◆</span> {area}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Banner Title */}
        <div className="mt-20 mb-10 py-10 text-center border-t border-b" style={{ borderColor: 'rgba(14,116,144,0.3)' }}>
          <h1 className="article-title text-3xl md:text-5xl lg:text-6xl tracking-tight" style={{ fontFamily: 'Noto Naskh Arabic, serif', fontWeight: 700, color: '#ffffff' }}>
            رویکردی نوین و مقتدرانه در حقوق تخصصی آب و اراضی
          </h1>
        </div>
      </div>
    </section>
  );
}