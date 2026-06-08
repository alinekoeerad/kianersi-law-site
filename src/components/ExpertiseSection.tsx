// Import required UI components
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function ExpertiseSection() {
  return (
    <section id="expertise" className="bg-section-alt" style={{ borderTop: '2px solid rgba(14,116,144,0.25)', borderBottom: '2px solid rgba(14,116,144,0.25)' }}>
      <div className="max-w-7xl mx-auto px-6 py-20">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>حوزه‌های تخصصی فعالیت</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              ارکان تخصص و حوزه‌های بنیادین وکالت
            </h2>
            <p className="mt-4 text-sm max-w-2xl mx-auto leading-8" style={{ fontFamily: 'Noto Sans Arabic', color: '#9ca3af' }}>
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
              <div className="keep-together p-6 rounded-sm h-full" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', color: '#ffffff', border: '1px solid rgba(14, 116, 144, 0.2)' }}>
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0">💧</span>
                  <div>
                    <h4 className="font-semibold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc', lineHeight: '1.6' }}>
                      حقوق آب و منابع آبی
                    </h4>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.75)' }}>
                      <li><span className="text-cyan-600 ml-1">■</span> حقوق آب و دعاوی مرتبط با منابع آبی</li>
                      <li><span className="text-cyan-600 ml-1">■</span> دعاوی بستر و حریم رودخانه‌ها</li>
                      <li><span className="text-cyan-600 ml-1">■</span> حقوق قراردادها و معاهدات آب</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 2: Administrative Court & State Organs */}
            <div className="space-y-4">
              <div className="keep-together p-6 rounded-sm h-full" style={{ backgroundColor: '#065f46' }}>
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0">⚖️</span>
                  <div>
                    <h4 className="font-semibold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc', lineHeight: '1.6' }}>
                      دعاوی دستگاه‌های اجرایی
                    </h4>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.85)' }}>
                      <li><span className="text-emerald-400 ml-1">■</span> دعاوی دیوان عدالت اداری</li>
                      <li><span className="text-emerald-400 ml-1">■</span> دعاوی حقوقی و کیفری مرتبط با دستگاه‌های اجرایی</li>
                      <li><span className="text-emerald-400 ml-1">■</span> دعاوی استملاک و تملک اراضی</li>
                      <li><span className="text-emerald-400 ml-1">■</span> طرح‌های عمرانی و زیرساختی</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {/* Card 3: Public Law & Contracts */}
            <div className="space-y-4">
              <div className="keep-together p-6 rounded-sm h-full" style={{ border: '1px solid #0e7490', backgroundColor: 'rgba(14,116,144,0.05)' }}>
                <div className="flex items-start gap-4">
                  <span className="text-3xl flex-shrink-0">📄</span>
                  <div>
                    <h4 className="font-semibold text-base mb-4" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#0e7490', lineHeight: '1.6' }}>
                      حقوق عمومی و قراردادها
                    </h4>
                    <ul className="space-y-3 text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: '#9ca3af' }}>
                      <li><span className="text-cyan-700 ml-1">■</span> دعاوی قراردادهای اداری</li>
                      <li><span className="text-cyan-700 ml-1">■</span> قراردادهای بازرگانی داخلی و بین‌المللی</li>
                      <li><span className="text-cyan-700 ml-1">■</span> حقوق مالی و عمومی</li>
                      <li><span className="text-cyan-700 ml-1">■</span> قانون کار و تأمین اجتماعی</li>
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