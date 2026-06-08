import { useState } from 'react';
import { SmallOrnament } from './SharedUI';

export default function Navbar() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <>
      {/* Top Banner */}
      <div style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', borderBottom: '2px solid #0e7490' }}>
        <div className="max-w-7xl mx-auto px-6 py-2 flex justify-between items-center">
          <p className="text-xs tracking-widest" style={{ color: '#0e7490', fontFamily: 'Noto Sans Arabic' }}>
            عضو کانون وکلای دادگستری البرز
          </p>
          <p className="text-xs tracking-widest hidden md:block" style={{ color: 'rgba(14,116,144,0.8)', fontFamily: 'Noto Sans Arabic' }}>
            وکیل پایه یک دادگستری
            <SmallOrnament />
            کارشناس ارشد حقوق بین‌الملل
          </p>
          <p className="text-xs" style={{ color: 'rgba(255,255,255,0.5)', fontFamily: 'Noto Sans Arabic' }}>
            ۲۰+ سال سابقه
          </p>
        </div>
      </div>

      {/* Main Navigation */}
      <nav className="nav-sticky">
        <div className="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
          
          {/* Logo and Masthead Title Container */}
          <a href="#hero" className="flex items-center gap-3 masthead-title text-xl font-bold transition-opacity hover:opacity-80" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
            <img 
              src="./logo.webp" 
              alt="Logo" 
              className="w-14 h-14 object-contain" 
            />
            کیان‌ارثی
          </a>

          {/* Desktop Menu Links */}
          <div className="hidden md:flex items-center gap-8">
            {[
              { href: '#about', label: 'درباره من' },
              { href: '#expertise', label: 'تخصص‌ها' },
              { href: '#laws', label: 'قوانین کاربردی' },
              { href: '#contact', label: 'تماس' },
            ].map(item => (
              <a key={item.href} href={item.href} className="text-sm transition-colors duration-200 hover:opacity-70"
                style={{ color: 'rgba(255,255,255,0.8)', fontFamily: 'Noto Sans Arabic', letterSpacing: '0.05em' }}>
                {item.label}
              </a>
            ))}
          </div>

          {/* Action Button */}
          <a href="tel:+989127698864" className="hidden md:block text-xs px-5 py-2 transition-all duration-300 rounded-sm hover:opacity-90"
            style={{ backgroundColor: '#0e7490', color: '#ffffff', fontFamily: 'Noto Sans Arabic', letterSpacing: '0.05em' }}>
            مشاوره (۰۹۱۲۷۶۹۸۸۶۴)
          </a>

          {/* Mobile Menu Toggle Button */}
          <button className="md:hidden text-sm px-3 py-1 transition-colors hover:text-white" style={{ color: '#0e7490', fontFamily: 'Noto Sans Arabic' }}
            onClick={() => setMenuOpen(!menuOpen)}>
            {menuOpen ? '✕' : '☰'}
          </button>
        </div>

        {/* Mobile Dropdown Menu */}
        {menuOpen && (
          <div className="md:hidden border-t" style={{ borderColor: 'rgba(14,116,144,0.3)' }}>
            {[
              { href: '#about', label: 'درباره من' },
              { href: '#expertise', label: 'تخصص‌ها' },
              { href: '#laws', label: 'قوانین کاربردی' },
              { href: '#contact', label: 'تماس' },
            ].map(item => (
              <a key={item.href} href={item.href} className="block px-6 py-3 text-sm border-b transition-colors hover:bg-cyan-900/10"
                style={{ color: 'rgba(255,255,255,0.8)', borderColor: 'rgba(14,116,144,0.2)', fontFamily: 'Noto Sans Arabic' }}
                onClick={() => setMenuOpen(false)}>
                {item.label}
              </a>
            ))}
          </div>
        )}
      </nav>
    </>
  );
}