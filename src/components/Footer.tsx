export default function Footer() {
  return (
    <footer style={{ backgroundColor: 'rgba(10, 30, 40, 0.95)', borderTop: '2px solid #0e7490' }}>
      <div className="max-w-7xl mx-auto px-6 py-12">
        <div className="grid md:grid-cols-3 gap-8 pb-8" style={{ borderBottom: '1px solid rgba(14,116,144,0.3)' }}>
          <div>
            <h3 className="text-xl font-bold mb-3" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              محمدحسن کیان‌ارثی
            </h3>
            <p className="text-xs leading-7" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.65)' }}>
              وکیل پایه یک دادگستری متمرکز بر دعاوی آب<br />عضو کانون وکلای دادگستری البرز<br />کارشناس ارشد حقوق بین‌الملل
            </p>
          </div>

          <div>
            <p className="section-label mb-4" style={{ color: 'rgba(125,211,252,0.8)' }}>دسترسی سریع</p>
            <div className="space-y-2">
              {/* تغییرات در این بخش اعمال شده است */}
              {[
                { name: 'درباره من', href: '#about' },
                { name: 'تخصص‌ها', href: '#expertise' },
                { name: 'قوانین کاربردی', href: '#laws' },
                { name: 'تماس با وکیل', href: '#contact' }
              ].map(link => (
                <div key={link.name}>
                  <a 
                    href={link.href} 
                    className="text-xs cursor-pointer transition-colors duration-200 hover:text-white block"
                    style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.55)' }}
                  >
                    {link.name}
                  </a>
                </div>
              ))}
            </div>
          </div>

          <div>
            <p className="section-label mb-4" style={{ color: 'rgba(125,211,252,0.8)' }}>تخصص‌های اصلی</p>
            <div className="space-y-2">
              {['دعاوی چاه‌ها و قنوات', 'بستر و حریم رودخانه‌ها', 'اراضی ملی و منابع طبیعی', 'حقوق عمومی و ملکی'].map(spec => (
                <div key={spec} className="flex items-center gap-2">
                  <span style={{ color: '#0e7490', fontSize: '0.4rem' }}>◆</span>
                  <span className="text-xs" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.65)' }}>
                    {spec}
                  </span>
                </div>
              ))}
            </div>
          </div>
        </div>

        <div className="pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-xs" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.45)' }}>
            تمامی حقوق محفوظ است.
          </p>
          <div className="flex items-center gap-3">
            <div className="w-px h-4" style={{ backgroundColor: 'rgba(14,116,144,0.4)' }} />
            <p className="text-xs" style={{ fontFamily: 'Noto Sans Arabic', color: 'rgba(255,255,255,0.45)' }}>
              وکالت، تعهد، تخصص
            </p>
          </div>
        </div>
      </div>
    </footer>
  );
}
