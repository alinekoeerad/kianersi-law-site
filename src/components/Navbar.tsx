import { useState, useEffect } from 'react';
import { Phone, Menu, X } from 'lucide-react';
import { SmallOrnament } from './SharedUI';
import { useSiteData } from '../context/SiteDataContext';
import { trackEvent } from '../utils/analytics';

export default function Navbar() {
  const { general } = useSiteData();
  const [menuOpen, setMenuOpen] = useState(false);
  const [activeSection, setActiveSection] = useState<string>('');

  const menuItems = [
    { href: '#about', id: 'about', label: 'درباره من' },
    { href: '#expertise', id: 'expertise', label: 'تخصص‌ها' },
    { href: '#laws', id: 'laws', label: 'قوانین کاربردی' },
    { href: '#contact', id: 'contact', label: 'تماس و موقعیت دفتر' },
  ];

  // Scrollspy to detect active section in real-time
  useEffect(() => {
    const handleScroll = () => {
      const sectionIds = ['about', 'expertise', 'laws', 'contact'];
      const scrollPosition = window.scrollY + 220; // Offset considering sticky header

      // Check if user reached bottom of page
      if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 80) {
        setActiveSection('contact');
        return;
      }

      for (let i = sectionIds.length - 1; i >= 0; i--) {
        const el = document.getElementById(sectionIds[i]);
        if (el && el.offsetTop <= scrollPosition) {
          setActiveSection(sectionIds[i]);
          return;
        }
      }

      // If at top / hero
      if (window.scrollY < 300) {
        setActiveSection('');
      }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Initial check on mount
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <>
      {/* Top Banner */}
      <div style={{ backgroundColor: 'rgba(10, 30, 40, 0.85)', borderBottom: '2px solid #0e7490' }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-2 flex justify-between items-center">
          <p className="text-xs tracking-widest font-medium" style={{ color: '#7dd3fc', fontFamily: 'Noto Sans Arabic' }}>
            عضو کانون وکلای دادگستری البرز
          </p>
          <p className="text-xs tracking-widest hidden md:block" style={{ color: 'rgba(226,232,240,0.9)', fontFamily: 'Noto Sans Arabic' }}>
            وکیل پایه یک دادگستری
            <SmallOrnament />
            کارشناس ارشد حقوق بین‌الملل
          </p>
          <p className="text-xs font-medium" style={{ color: '#94a3b8', fontFamily: 'Noto Sans Arabic' }}>
            {general.experienceYears}+ سال سابقه حقوقی
          </p>
        </div>
      </div>

      {/* Main Navigation Header */}
      <header className="nav-sticky">
        <nav>
          <div className="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            
            {/* Logo and Masthead Title Container */}
            <a href="#hero" className="flex items-center gap-3 masthead-title text-xl font-bold transition-opacity hover:opacity-80" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
              <img 
                src="./logo.webp" 
                alt="نشان رسمی دفتر وکالت محمدحسن کیان‌ارثی" 
                title="محمدحسن کیان‌ارثی وکیل کرج"
                className="w-12 h-12 md:w-14 md:h-14 object-contain" 
              />
              <span>کیان‌ارثی</span>
            </a>

            {/* Desktop Menu Links with Clean Editorial Active Underline */}
            <div className="hidden md:flex items-center gap-7">
              {menuItems.map(item => {
                const isActive = activeSection === item.id;
                return (
                  <a 
                    key={item.href} 
                    href={item.href} 
                    className="text-sm py-2 relative transition-colors duration-200"
                    style={{ 
                      color: isActive ? '#ffffff' : 'rgba(255, 255, 255, 0.65)',
                      fontFamily: 'Noto Sans Arabic', 
                      letterSpacing: '0.03em',
                      fontWeight: isActive ? 600 : 400
                    }}
                  >
                    <span className="hover:text-white transition-colors">{item.label}</span>
                    {/* Clean 2px Editorial Line without glows */}
                    <span 
                      className={`absolute bottom-0 right-0 left-0 h-[2px] transition-all duration-300 ${
                        isActive ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0'
                      }`}
                      style={{ backgroundColor: '#0e7490' }}
                    />
                  </a>
                );
              })}
            </div>

            {/* Desktop Action Button */}
            <a 
              href={`tel:${general.rawPhone}`} 
              onClick={() => trackEvent('phone')}
              className="hidden md:flex items-center gap-2 text-xs px-5 py-2.5 transition-all duration-300 rounded-sm hover:brightness-110 font-semibold"
              style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic' }}>
              <Phone className="w-3.5 h-3.5 stroke-[2.2]" />
              <span>مشاوره تلفنی ({general.phone})</span>
            </a>

            {/* Mobile Right Controls: Call CTA & Hamburger Toggle */}
            <div className="flex md:hidden items-center gap-2">
              <a 
                href={`tel:${general.rawPhone}`} 
                onClick={() => trackEvent('phone')}
                className="text-xs px-3 py-1.5 rounded-sm flex items-center gap-1.5 font-semibold transition-all"
                style={{ backgroundColor: '#0e7490', color: '#ffffff' }}
                aria-label="تماس تلفنی"
              >
                <Phone className="w-3 h-3 stroke-[2.2]" />
                <span>تماس</span>
              </a>

              <button 
                className="p-1.5 text-cyan-400 hover:text-white border border-cyan-800/80 rounded-sm bg-slate-900/60 flex items-center justify-center" 
                onClick={() => setMenuOpen(!menuOpen)}
                aria-label="منوی سایت"
              >
                {menuOpen ? <X className="w-4 h-4 stroke-[2.5]" /> : <Menu className="w-4 h-4 stroke-[2.5]" />}
              </button>
            </div>
          </div>
        </nav>

        {/* Mobile Dropdown Menu with Clean Editorial Active Indicator */}
        {menuOpen && (
          <div className="md:hidden border-t bg-slate-950/95 backdrop-blur-md" style={{ borderColor: 'rgba(14,116,144,0.3)' }}>
            {menuItems.map(item => {
              const isActive = activeSection === item.id;
              return (
                <a 
                  key={item.href} 
                  href={item.href} 
                  className="block px-6 py-3.5 text-sm border-b transition-colors"
                  style={{ 
                    borderColor: 'rgba(14,116,144,0.2)', 
                    fontFamily: 'Noto Sans Arabic',
                    color: isActive ? '#ffffff' : 'rgba(255, 255, 255, 0.7)',
                    borderRight: isActive ? '3px solid #0e7490' : '3px solid transparent',
                    backgroundColor: isActive ? 'rgba(14, 116, 144, 0.1)' : 'transparent',
                    fontWeight: isActive ? 600 : 400
                  }}
                  onClick={() => setMenuOpen(false)}
                >
                  <span>{item.label}</span>
                </a>
              );
            })}

            <div className="p-4">
              <a 
                href={`tel:${general.rawPhone}`} 
                onClick={() => { trackEvent('phone'); setMenuOpen(false); }}
                className="flex items-center justify-center gap-2 w-full py-3 text-center text-xs font-semibold rounded-sm"
                style={{ backgroundColor: '#0e7490', color: '#ffffff' }}
              >
                <Phone className="w-4 h-4 stroke-[2.2]" />
                <span>تماس مستقیم با وکیل: {general.phone}</span>
              </a>
            </div>
          </div>
        )}
      </header>
    </>
  );
}
