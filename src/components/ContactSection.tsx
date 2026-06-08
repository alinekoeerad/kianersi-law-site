import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function ContactSection() {
  // Array of contact details using locally downloaded images for ALL icons
  const contactMethods = [
    { 
      icon: <img src="./phone.webp" alt="Phone" className="w-7 h-7 object-contain" />,
      label: 'تلفن مستقیم', 
      value: '۰۹۱۲۷۶۹۸۸۶۴', 
      sublabel: 'ارتباط مستقیم با وکیل', 
      href: 'tel:+989127698864', 
      target: '_self' 
    },
    { 
      icon: <img src="./eitaa.webp" alt="Eitaa" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان ایتا', 
      value: '@Mohamadhasankianersi', 
      sublabel: '', 
      href: 'https://eitaa.com/Mohamadhasankianersi', 
      target: '_blank' 
    },
    { 
      icon: <img src="./rubika.webp" alt="Rubika" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان روبیکا', 
      value: '@Mka12345666', 
      sublabel: '', 
      href: 'https://rubika.ir/Mka12345666', 
      target: '_blank' 
    },
    { 
      icon: <img src="./bale.webp" alt="Bale" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان بله', 
      value: '@Mohamadhasankianersi', 
      sublabel: '', 
      href: 'https://ble.ir/Mohamadhasankianersi', 
      target: '_blank' 
    },
    { 
      icon: <img src="./location.webp" alt="Location" className="w-7 h-7 object-contain" />,
      label: 'استان', 
      value: 'البرز', 
      sublabel: 'محل فعالیت اصلی', 
      href: '#', 
      target: '_self' 
    },
  ];

  return (
    <section id="contact" className="py-20 bg-deep">
      <div className="max-w-7xl mx-auto px-6">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>ارتباط با وکیل</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              مشاوره و ارزیابی پرونده
            </h2>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Content Grid */}
        <div className="grid md:grid-cols-2 gap-12 items-start justify-center">
          
          {/* Contact Methods List */}
          <AnimSection>
            <div className="max-w-md mx-auto">
              <p className="section-label mb-6 text-right">اطلاعات تماس</p>
              <div className="space-y-2">
                {contactMethods.map((item, index) => (
                  <a 
                    key={index} 
                    href={item.href} 
                    className="contact-item block hover:bg-cyan-900/10 px-4 py-3 rounded-lg transition-all duration-300 group"
                    target={item.target} 
                    rel={item.target === '_blank' ? 'noopener noreferrer' : undefined}
                  >
                    <div className="flex items-center gap-4">
                      {/* Icon Container */}
                      <span className="w-10 h-10 flex-shrink-0 flex justify-center items-center transition-transform duration-300 group-hover:scale-110">
                        {item.icon}
                      </span>
                      
                      {/* Text Container - Forced alignment to start (right in RTL) */}
                      <div className="flex-1 flex flex-col items-start text-right">
                        <p className="text-xs section-label mb-0.5">{item.label}</p>
                        
                        {/* Value wrapper using bdi to keep LTR characters ordered correctly while keeping the block Right-Aligned */}
                        <p className="text-sm font-medium" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                          <bdi dir="ltr">{item.value}</bdi>
                        </p>
                        
                        {/* Conditional rendering for sublabel to prevent empty spaces */}
                        {item.sublabel && (
                          <p className="text-xs mt-1" style={{ color: '#0e7490', fontFamily: 'Noto Sans Arabic' }}>
                            {item.sublabel}
                          </p>
                        )}
                      </div>
                    </div>
                  </a>
                ))}
              </div>
            </div>
          </AnimSection>
          
          {/* Action Box */}
          <AnimSection delay={200}>
            <div className="mt-8 p-8 rounded-sm max-w-md mx-auto" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              <p className="text-sm mb-4 font-semibold text-center" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc' }}>
                اولین قدم برای احقاق حق
              </p>
              <p className="text-xs leading-7 mb-6 text-center text-justify" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.75)' }}>
                جهت بررسی تخصصی اسناد، ارزیابی اولیه پرونده و تعیین وقت مشاوره با یکی از خبره‌ترین وکلای حوزه منابع آب در تهران و البرز، با ما در ارتباط باشید.
              </p>
              <a href="tel:+989127698864" className="block text-center px-6 py-4 text-sm transition-all duration-300 hover:opacity-90 rounded-sm"
                style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic' }}>
                تماس جهت مشاوره: ۰۹۱۲۷۶۹۸۸۶۴
              </a>
            </div>
          </AnimSection>

        </div>
      </div>
    </section>
  );
}