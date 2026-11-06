import { useState } from 'react';
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function ContactSection() {
  const [copied, setCopied] = useState(false);
  const [mapActive, setMapActive] = useState(false);

  const fullAddress = 'کرج، بلوار ملاصدرا، بالاتر از دبیرستان سلام البرز، ساختمان وکلای صدرا، طبقه دوم، واحد ۸';
  const latitude = 35.8427497;
  const longitude = 50.991522;

  const handleCopyAddress = () => {
    navigator.clipboard.writeText(fullAddress);
    setCopied(true);
    setTimeout(() => setCopied(false), 2500);
  };

  // Contact channels with local assets and official links (clean title & value without sublabels)
  const contactMethods = [
    { 
      icon: <img src="./phone.webp" alt="شماره تماس مستقیم دفتر وکالت محمدحسن کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'تلفن مستقیم', 
      value: '۰۹۱۲۷۶۹۸۸۶۴', 
      href: 'tel:+989127698864', 
      target: '_self' 
    },
    { 
      icon: <img src="./instagram.svg" alt="صفحه رسمی اینستاگرام وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'صفحه رسمی اینستاگرام', 
      value: '@kianersi.mohamad', 
      href: 'https://www.instagram.com/kianersi.mohamad?mdxt=eGZjdzN2MWMyaXEx', 
      target: '_blank' 
    },
    { 
      icon: <img src="./eitaa.webp" alt="ارسال اسناد در پیام‌رسان ایتا به وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان ایتا', 
      value: '@Mohamadhasankianersi', 
      href: 'https://eitaa.com/Mohamadhasankianersi', 
      target: '_blank' 
    },
    { 
      icon: <img src="./bale.webp" alt="ارتباط در پیام‌رسان بله با وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان بله', 
      value: '@Mohamadhasankianersi', 
      href: 'https://ble.ir/Mohamadhasankianersi', 
      target: '_blank' 
    },
    { 
      icon: <img src="./rubika.webp" alt="ارتباط در پیام‌رسان روبیکا با وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان روبیکا', 
      value: '@Mka12345666', 
      href: 'https://rubika.ir/Mka12345666', 
      target: '_blank' 
    },
  ];

  // Routing navigation apps
  const navigationApps = [
    {
      name: 'نشان',
      href: `https://neshan.org/maps/@${latitude},${longitude},17z`,
      badge: 'محبوب'
    },
    {
      name: 'بلد',
      href: `https://balad.ir/location?latitude=${latitude}&longitude=${longitude}`,
      badge: ''
    },
    {
      name: 'Google Maps',
      href: `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}`,
      badge: ''
    },
    {
      name: 'Waze',
      href: `https://waze.com/ul?ll=${latitude},${longitude}&navigate=yes`,
      badge: ''
    }
  ];

  return (
    <section id="contact" className="py-12 sm:py-20 bg-deep">
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>ارتباط و مشاوره حقوقی</SectionLabel>
            <h2 className="article-title text-2xl sm:text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              مشاوره حقوقی، ارزیابی پرونده و نشانی دفتر وکالت در کرج
            </h2>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Main Content 12-Column Grid */}
        <div className="grid md:grid-cols-12 gap-8 items-start">
          
          {/* Right Column (5 Cols): Direct Contacts & Action Box */}
          <AnimSection className="md:col-span-5 space-y-6">
            
            {/* Contact Methods List Card */}
            <div className="p-4 sm:p-6 rounded-sm" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              <div className="flex items-center justify-between mb-4 pb-2" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)' }}>
                <p className="section-label mb-0" style={{ color: '#7dd3fc' }}>راه‌های ارتباط و پیام‌رسان‌ها</p>
                <span className="text-xs" style={{ color: '#e2e8f0' }}>ارتباط مستقیم با وکیل</span>
              </div>

              <div className="space-y-1">
                {contactMethods.map((item, index) => (
                  <a 
                    key={index} 
                    href={item.href} 
                    className="contact-item block hover:bg-cyan-900/15 px-3 py-3 rounded-sm transition-all duration-300 group"
                    target={item.target} 
                    rel={item.target === '_blank' ? 'noopener noreferrer' : undefined}
                  >
                    <div className="flex items-center gap-3.5">
                      <span className="w-9 h-9 flex-shrink-0 flex justify-center items-center transition-transform duration-300 group-hover:scale-110">
                        {item.icon}
                      </span>
                      
                      <div className="flex-1 flex flex-col items-start text-right min-w-0">
                        <p className="text-xs section-label mb-0.5 truncate" style={{ color: '#7dd3fc' }}>{item.label}</p>
                        <p className="text-sm font-medium tracking-wide" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                          <bdi dir="ltr">{item.value}</bdi>
                        </p>
                      </div>

                      <span className="text-xs text-cyan-400/60 group-hover:text-cyan-300 group-hover:-translate-x-1 transition-all">
                        ←
                      </span>
                    </div>
                  </a>
                ))}
              </div>
            </div>

            {/* Consultation Action Card */}
            <div className="p-4 sm:p-6 rounded-sm text-center" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              <div className="mb-4 pb-2" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)' }}>
                <p className="section-label mb-1" style={{ color: '#7dd3fc' }}>پذیرش پرونده و تعیین وقت مشاوره</p>
                <p className="text-sm font-semibold text-white mt-1" style={{ fontFamily: 'Noto Naskh Arabic, serif' }}>
                  اولین قدم برای احقاق حق و صیانت از دارایی‌ها
                </p>
              </div>

              <p className="text-xs leading-7 mb-6 text-justify" style={{ color: '#cbd5e1', fontFamily: 'Noto Sans Arabic' }}>
                جهت بررسی اسناد مالکیت، آرای کمیسیون‌های آب یا اخطاریه‌های اداری و تعیین وقت جلسه حضوری در دفتر کرج یا مشاوره تلفنی، مستقیماً از طریق تماس تلفنی یا ارسال مدارک در پیام‌رسان‌ها در ارتباط باشید.
              </p>

              <div>
                <a 
                  href="tel:+989127698864" 
                  className="flex items-center justify-center gap-2 w-full py-3.5 px-4 text-xs font-semibold rounded-sm transition-all duration-300 hover:brightness-110 shadow-md text-center"
                  style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic' }}
                >
                  <span>📞</span>
                  <span>تماس مستقیم با وکیل: ۰۹۱۲۷۶۹۸۸۶۴</span>
                </a>
              </div>
            </div>

          </AnimSection>
          
          {/* Left Column (7 Cols): Office Location & Google Maps */}
          <AnimSection className="md:col-span-7 space-y-6" delay={150}>
            
            {/* Address Info Card */}
            <div className="p-4 sm:p-6 rounded-sm" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              
              <div className="flex items-center justify-between mb-4 pb-2" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)' }}>
                <div className="flex items-center gap-2">
                  <img src="./location.webp" alt="نشانی و موقعیت دفتر وکالت در کرج" className="w-5 h-5 object-contain" />
                  <p className="section-label mb-0" style={{ color: '#7dd3fc' }}>نشانی و موقعیت دفتر وکالت</p>
                </div>
                <button
                  onClick={handleCopyAddress}
                  className="text-xs px-3 py-1 rounded-sm transition-all duration-200 flex items-center gap-1.5"
                  style={{
                    backgroundColor: copied ? '#065f46' : 'rgba(14,116,144,0.2)',
                    color: copied ? '#ffffff' : '#7dd3fc',
                    border: '1px solid rgba(14,116,144,0.4)'
                  }}
                  title="کپی نشانی کامل"
                >
                  {copied ? (
                    <>
                      <span>✓</span>
                      <span>آدرس کپی شد</span>
                    </>
                  ) : (
                    <>
                      <span>📋</span>
                      <span>کپی آدرس</span>
                    </>
                  )}
                </button>
              </div>

              {/* Exact Address Text */}
              <p className="text-sm md:text-base leading-8 font-medium text-justify mb-3" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
                {fullAddress}
              </p>

              <div className="flex flex-wrap items-center justify-between gap-2 pt-2 text-xs" style={{ color: '#cbd5e1', fontFamily: 'Noto Sans Arabic' }}>
                <div className="flex items-center gap-2">
                  <span className="w-2 h-2 rounded-full" style={{ backgroundColor: '#38bdf8' }} />
                  <span>پذیرش مراجعین گرامی: با هماهنگی و تعیین وقت قبلی</span>
                </div>
                <div className="text-[11px]" style={{ color: '#7dd3fc' }}>
                  مختصات: <bdi dir="ltr">{latitude}, {longitude}</bdi>
                </div>
              </div>

            </div>

            {/* Embedded Live Google Maps Container */}
            <div className="rounded-sm overflow-hidden" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              
              {/* Map Header */}
              <div className="px-5 py-3 flex items-center justify-between flex-wrap gap-2" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)', backgroundColor: 'rgba(3,24,37,0.7)' }}>
                <div className="flex items-center gap-2">
                  <span className="text-xs font-semibold" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
                    نقشه موقعیت ساختمان وکلای صدرا در Google Maps
                  </span>
                </div>
                <span className="text-[11px] text-cyan-300">
                  کرج، بلوار ملاصدرا
                </span>
              </div>

              {/* Map Iframe with Touch Guard for Mobile */}
              <div 
                className="relative w-full h-[340px] md:h-[380px] bg-slate-900"
                onClick={() => setMapActive(true)}
                onMouseLeave={() => setMapActive(false)}
              >
                {!mapActive && (
                  <div className="md:hidden absolute inset-0 z-10 bg-black/20 flex items-center justify-center pointer-events-auto">
                    <span className="bg-slate-900/90 text-cyan-300 text-xs px-3 py-1.5 rounded-sm border border-cyan-800">
                      برای جابجایی نقشه ضربه بزنید
                    </span>
                  </div>
                )}
                <iframe
                  title="نقشه موقعیت دفتر وکالت محمدحسن کیان‌ارثی در گوگل مپ"
                  src={`https://maps.google.com/maps?q=${latitude},${longitude}&hl=fa&z=16&output=embed`}
                  className={`w-full h-full border-0 ${mapActive ? 'pointer-events-auto' : 'pointer-events-auto md:pointer-events-auto'}`}
                  loading="lazy"
                  allowFullScreen
                />
              </div>

              {/* Quick Navigation Direct Links Bar */}
              <div className="p-3 sm:p-4" style={{ borderTop: '1px solid rgba(14,116,144,0.2)', backgroundColor: 'rgba(3,24,37,0.7)' }}>
                <p className="text-xs section-label mb-3" style={{ color: '#7dd3fc' }}>
                  مسیریابی مستقیم با برنامه‌های نقشه و بلد:
                </p>
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                  {navigationApps.map((app) => (
                    <a
                      key={app.name}
                      href={app.href}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="flex items-center justify-center gap-1 py-2 px-2 text-[11px] sm:text-xs rounded-sm transition-all duration-300 hover:brightness-125 hover:-translate-y-0.5 text-center font-medium"
                      style={{
                        backgroundColor: 'rgba(10,30,40,0.85)',
                        border: '1px solid rgba(14,116,144,0.4)',
                        color: '#ffffff',
                        fontFamily: 'Noto Sans Arabic'
                      }}
                    >
                      <span>🚗</span>
                      <span>{app.name}</span>
                    </a>
                  ))}
                </div>
              </div>

            </div>

          </AnimSection>

        </div>
      </div>
    </section>
  );
}
