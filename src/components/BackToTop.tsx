import { useState, useEffect } from 'react';

export default function BackToTop() {
  const [isVisible, setIsVisible] = useState(false);

  // بررسی میزان اسکرول برای نمایش یا مخفی کردن دکمه
  const toggleVisibility = () => {
    if (window.scrollY > 400) {
      setIsVisible(true);
    } else {
      setIsVisible(false);
    }
  };

  // تابعی برای بازگشت نرم به بالای صفحه
  const scrollToTop = () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth',
    });
  };

  useEffect(() => {
    window.addEventListener('scroll', toggleVisibility);
    return () => window.removeEventListener('scroll', toggleVisibility);
  }, []);

  return (
    <button
      onClick={scrollToTop}
      // کلاس‌های تیلویند برای انیمیشن محو شدن و جابجایی
      className={`fixed bottom-8 left-8 z-50 p-3 transition-all duration-500 group ${
        isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10 pointer-events-none'
      }`}
      style={{
        backgroundColor: 'rgba(10, 30, 40, 0.85)',
        border: '1px solid #0e7490',
        color: '#7dd3fc',
        backdropFilter: 'blur(8px)',
        borderRadius: '0', // گوشه‌های کاملاً تیز و مستطیلی برای حفظ یکپارچگی طراحی
        boxShadow: isVisible ? '0 4px 20px rgba(14, 116, 144, 0.2)' : 'none'
      }}
      aria-label="بازگشت به بالا"
    >
      {/* آیکون فلش رو به بالا (مینیمال و تیز) */}
      <svg 
        width="24" 
        height="24" 
        viewBox="0 0 24 24" 
        fill="none" 
        stroke="currentColor" 
        strokeWidth="1.5" 
        strokeLinecap="square" 
        strokeLinejoin="miter"
        className="transition-transform duration-300 group-hover:-translate-y-1"
      >
        <polyline points="18 15 12 9 6 15"></polyline>
      </svg>
    </button>
  );
}