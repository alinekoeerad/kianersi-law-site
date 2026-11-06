// Import required UI components
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function ExpertiseSection() {
  return (
    <section id="expertise" className="bg-section-alt" style={{ borderTop: '2px solid rgba(14,116,144,0.25)', borderBottom: '2px solid rgba(14,116,144,0.25)' }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>حوزه‌های تخصصی فعالیت</SectionLabel>
            <h2 className="article-title text-2xl sm:text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              حوزه‌های تخصصی وکالت: کمیسیون آب، چاه کشاورزی و دیوان عدالت اداری
            </h2>
            <p className="mt-4 text-sm max-w-2xl mx-auto leading-8" style={{ fontFamily: 'Noto Sans Arabic', color: '#cbd5e1' }}>
              تمایز عملکردی در تسلط همه‌جانبه بر سه رکن قانون، رویه اداری و مقتضیات فنی در دعاوی ملی و دستگاه‌های اجرایی است.
            </p>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Expertise Cards Grid */}
        <AnimSection delay={100}>
          <div className="grid md:grid-cols-3 gap-6">
            
            {/* Card 1: Water Rights */}
            <div className="space-y-4">
              <div 
                className="keep-together p-5 sm:p-7 rounded-sm h-full transition-all duration-300 hover:border-cyan-500/60" 
                style={{ 
                  backgroundColor: 'rgba(10, 30, 40, 0.8)', 
                  color: '#ffffff', 
                  border: '1px solid rgba(14, 116, 144, 0.35)',
                  boxShadow: '0 4px 20px rgba(0,0,0,0.2)'
                }}
              >
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0 p-2.5 rounded-sm bg-cyan-950/60 border border-cyan-800/40">💧</span>
                  <div className="flex-1">
                    <h3 className="font-bold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc', lineHeight: '1.6' }}>
                      حقوق آب و منابع آبی
                    </h3>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.88)' }}>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> حقوق آب و دعاوی مرتبط با منابع آبی سطحی و زیرزمینی</li>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> دعاوی بستر و حریم رودخانه‌ها، انهار و قنوات</li>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> حقوق قراردادها و معاهدات آب و طرح‌های انتقال</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 2: Administrative Court & State Organs */}
            <div className="space-y-4">
              <div 
                className="keep-together p-5 sm:p-7 rounded-sm h-full transition-all duration-300 hover:border-emerald-500/60" 
                style={{ 
                  backgroundColor: 'rgba(10, 30, 40, 0.8)', 
                  color: '#ffffff', 
                  border: '1px solid rgba(6, 95, 70, 0.45)',
                  boxShadow: '0 4px 20px rgba(0,0,0,0.2)'
                }}
              >
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0 p-2.5 rounded-sm bg-emerald-950/60 border border-emerald-800/40">⚖️</span>
                  <div className="flex-1">
                    <h3 className="font-bold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#6ee7b7', lineHeight: '1.6' }}>
                      دعاوی دستگاه‌های اجرایی و دیوان عدالت
                    </h3>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.88)' }}>
                      <li><span className="text-emerald-400 ml-1.5 font-bold">■</span> دعاوی ابطال بخشنامه‌ها و مصوبات در دیوان عدالت اداری</li>
                      <li><span className="text-emerald-400 ml-1.5 font-bold">■</span> دعاوی حقوقی و کیفری مرتبط با شرکت‌های آب منطقه‌ای</li>
                      <li><span className="text-emerald-400 ml-1.5 font-bold">■</span> استملاک و تملک اراضی و طرح‌های عمرانی ملی</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 3: Public Law & Contracts */}
            <div className="space-y-4">
              <div 
                className="keep-together p-5 sm:p-7 rounded-sm h-full transition-all duration-300 hover:border-cyan-500/60" 
                style={{ 
                  backgroundColor: 'rgba(10, 30, 40, 0.8)', 
                  color: '#ffffff', 
                  border: '1px solid rgba(14, 116, 144, 0.35)',
                  boxShadow: '0 4px 20px rgba(0,0,0,0.2)'
                }}
              >
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0 p-2.5 rounded-sm bg-cyan-950/60 border border-cyan-800/40">📄</span>
                  <div className="flex-1">
                    <h3 className="font-bold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc', lineHeight: '1.6' }}>
                      حقوق عمومی و قراردادها
                    </h3>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.88)' }}>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> دعاوی قراردادهای اداری، پیمانکاری و مهندسی</li>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> قراردادهای بازرگانی داخلی و بین‌المللی</li>
                      <li><span className="text-cyan-400 ml-1.5 font-bold">■</span> دعاوی حقوق مالی و قانون محاسبات عمومی</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </AnimSection>
      </div>
    </section>
  );
}
