import { useState } from 'react';
import { Phone, Check, Copy, Navigation } from 'lucide-react';
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';
import { useSiteData } from '../context/SiteDataContext';
import { trackEvent, AnalyticsEventType } from '../utils/analytics';

export default function ContactSection() {
  const { general } = useSiteData();
  const [copied, setCopied] = useState(false);
  const [mapActive, setMapActive] = useState(false);
  const [mapProvider, setMapProvider] = useState<'google' | 'osm'>('google');

  const fullAddress = general.address;
  const latitude = general.latitude ? parseFloat(String(general.latitude)) || 35.8427497 : 35.8427497;
  const longitude = general.longitude ? parseFloat(String(general.longitude)) || 50.991522 : 50.991522;
  const osmBbox = `${(longitude - 0.0065).toFixed(4)},${(latitude - 0.0047).toFixed(4)},${(longitude + 0.0065).toFixed(4)},${(latitude + 0.0047).toFixed(4)}`;

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
      value: general.phone, 
      href: `tel:${general.rawPhone}`, 
      target: '_self',
      track: 'phone' as AnalyticsEventType
    },
    { 
      icon: <img src="./instagram.svg" alt="صفحه رسمی اینستاگرام وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'صفحه رسمی اینستاگرام', 
      value: general.instagram, 
      href: general.instagramUrl, 
      target: '_blank',
      track: 'instagram' as AnalyticsEventType
    },
    { 
      icon: <img src="./eitaa.webp" alt="ارسال اسناد در پیام‌رسان ایتا به وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان ایتا', 
      value: general.eitaa, 
      href: general.eitaaUrl, 
      target: '_blank',
      track: 'eitaa' as AnalyticsEventType
    },
    { 
      icon: <img src="./bale.webp" alt="ارتباط در پیام‌رسان بله با وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان بله', 
      value: general.bale, 
      href: general.baleUrl, 
      target: '_blank',
      track: 'bale' as AnalyticsEventType
    },
    { 
      icon: <img src="./rubika.webp" alt="ارتباط در پیام‌رسان روبیکا با وکیل کیان‌ارثی" className="w-7 h-7 object-contain" />,
      label: 'پیام‌رسان روبیکا', 
      value: general.rubika, 
      href: general.rubikaUrl, 
      target: '_blank',
      track: 'rubika' as AnalyticsEventType
    },
  ];

  // Routing navigation apps (Waze removed, 3 primary maps)
  const navigationApps = [
    {
      name: 'نشان',
      href: general.neshanUrl || `https://neshan.org/maps/@${latitude},${longitude},17z`,
      badge: 'محبوب'
    },
    {
      name: 'بلد',
      href: general.baladUrl || `https://balad.ir/location?latitude=${latitude}&longitude=${longitude}`,
      badge: ''
    },
    {
      name: 'Google Maps',
      href: general.googleMapsUrl || `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}`,
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
                    onClick={() => trackEvent(item.track)}
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
                  href={`tel:${general.rawPhone}`} 
                  onClick={() => trackEvent('phone')}
                  className="flex items-center justify-center gap-2 w-full py-3.5 px-4 text-xs font-semibold rounded-sm transition-all duration-300 hover:brightness-110 shadow-md text-center"
                  style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic' }}
                >
                  <Phone className="w-4 h-4 stroke-[2.2]" />
                  <span>تماس مستقیم با وکیل: {general.phone}</span>
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
                      <Check className="w-3.5 h-3.5" />
                      <span>آدرس کپی شد</span>
                    </>
                  ) : (
                    <>
                      <Copy className="w-3.5 h-3.5" />
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

            {/* Embedded Live Map Container */}
            <div className="rounded-sm overflow-hidden" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
              
              {/* Map Header with Provider Switch */}
              <div className="px-4 sm:px-5 py-3 flex items-center justify-between flex-wrap gap-2" style={{ borderBottom: '1px solid rgba(14,116,144,0.2)', backgroundColor: 'rgba(3,24,37,0.7)' }}>
                <div className="flex items-center gap-2">
                  <span className="text-xs font-semibold" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
                    نقشه موقعیت ساختمان وکلای صدرا
                  </span>
                  <span className="text-[11px] text-cyan-300 hidden sm:inline">
                    (کرج، بلوار ملاصدرا)
                  </span>
                </div>

                <div className="flex items-center gap-1.5 text-xs">
                  <button
                    type="button"
                    onClick={() => setMapProvider('google')}
                    className="px-2.5 py-1 rounded-sm text-[11px] transition-all font-medium"
                    style={{
                      backgroundColor: mapProvider === 'google' ? '#0e7490' : 'rgba(2,15,26,0.6)',
                      color: mapProvider === 'google' ? '#ffffff' : '#94a3b8',
                      border: mapProvider === 'google' ? '1px solid #7dd3fc' : '1px solid rgba(14,116,144,0.25)'
                    }}
                  >
                    Google Maps
                  </button>
                  <button
                    type="button"
                    onClick={() => setMapProvider('osm')}
                    className="px-2.5 py-1 rounded-sm text-[11px] transition-all font-medium"
                    style={{
                      backgroundColor: mapProvider === 'osm' ? '#0e7490' : 'rgba(2,15,26,0.6)',
                      color: mapProvider === 'osm' ? '#ffffff' : '#94a3b8',
                      border: mapProvider === 'osm' ? '1px solid #7dd3fc' : '1px solid rgba(14,116,144,0.25)'
                    }}
                  >
                    OpenStreetMap
                  </button>
                </div>
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
                  title="نقشه موقعیت دفتر وکالت محمدحسن کیان‌ارثی در کرج"
                  src={
                    mapProvider === 'google'
                      ? `https://maps.google.com/maps?q=${latitude},${longitude}&hl=fa&z=16&output=embed`
                      : `https://www.openstreetmap.org/export/embed.html?bbox=${osmBbox}&layer=mapnik&marker=${latitude},${longitude}`
                  }
                  className="w-full h-full border-0 pointer-events-auto"
                  loading="lazy"
                  allowFullScreen
                />
              </div>

              {/* Quick Navigation Direct Links Bar */}
              <div className="p-3 sm:p-4" style={{ borderTop: '1px solid rgba(14,116,144,0.2)', backgroundColor: 'rgba(3,24,37,0.7)' }}>
                <p className="text-xs section-label mb-3" style={{ color: '#7dd3fc' }}>
                  مسیریابی مستقیم با برنامه‌های نقشه و بلد:
                </p>
                <div className="grid grid-cols-3 gap-2">
                  {navigationApps.map((app) => (
                    <a
                      key={app.name}
                      href={app.href}
                      onClick={() => trackEvent('maps')}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="flex items-center justify-center gap-1.5 py-2 px-2 text-[11px] sm:text-xs rounded-sm transition-all duration-300 hover:brightness-125 hover:-translate-y-0.5 text-center font-medium"
                      style={{
                        backgroundColor: 'rgba(10,30,40,0.85)',
                        border: '1px solid rgba(14,116,144,0.4)',
                        color: '#ffffff',
                        fontFamily: 'Noto Sans Arabic'
                      }}
                    >
                      <Navigation className="w-3 h-3 text-cyan-400 stroke-[2]" />
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
