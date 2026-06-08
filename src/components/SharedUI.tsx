import React, { useEffect, useRef, useState } from 'react';

// ─── Ornamental SVG Divider ───────────────────────────────────────────────────
export const OrnamentDivider = ({ className = '' }: { className?: string }) => (
  <div className={`flex items-center gap-3 ${className}`}>
    <div className="flex-1 h-px" style={{ background: 'linear-gradient(to left, transparent, #0e7490)' }} />
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 2L14.5 9.5H22L16 14L18.5 21.5L12 17L5.5 21.5L8 14L2 9.5H9.5L12 2Z" fill="#0e7490" fillOpacity="0.8"/>
    </svg>
    <div className="flex-1 h-px" style={{ background: 'linear-gradient(to right, transparent, #0e7490)' }} />
  </div>
);

// ─── Small Ornament ───────────────────────────────────────────────────────────
export const SmallOrnament = () => (
  <span className="inline-block mx-2" style={{ color: '#0e7490' }}>✦</span>
);

// ─── Section Label ────────────────────────────────────────────────────────────
export const SectionLabel = ({ children, className = '' }: { children: React.ReactNode; className?: string }) => (
  <p className={`section-label mb-3 tracking-widest ${className}`}>{children}</p>
);

// ─── Stat Card ────────────────────────────────────────────────────────────────
export const StatCard = ({ number, label, suffix = '' }: { number: string; label: string; suffix?: string }) => (
  <div className="text-center py-6 px-4" style={{ borderRight: '1px solid rgba(14,116,144,0.3)' }}>
    <div className="stat-number text-5xl mb-2">{number}<span className="text-2xl">{suffix}</span></div>
    <div className="text-xs tracking-widest section-label">{label}</div>
  </div>
);

// ─── Use Intersection Observer Hook ──────────────────────────────────────────
export const useVisible = (threshold = 0.15) => {
  const ref = useRef<HTMLDivElement>(null);
  const [visible, setVisible] = useState(false);
  
  useEffect(() => {
    const obs = new IntersectionObserver(
      ([entry]) => { if (entry.isIntersecting) setVisible(true) },
      { threshold }
    );
    if (ref.current) obs.observe(ref.current);
    return () => obs.disconnect();
  }, [threshold]);
  
  return { ref, visible };
};

// ─── Animated Section ─────────────────────────────────────────────────────────
export interface AnimSectionProps {
  children: React.ReactNode;
  className?: string;
  delay?: number;
}

export const AnimSection = ({ children, className = '', delay = 0 }: AnimSectionProps) => {
  const { ref, visible } = useVisible();
  return (
    <div
      ref={ref}
      className={className}
      style={{
        opacity: visible ? 1 : 0,
        transform: visible ? 'translateY(0)' : 'translateY(24px)',
        transition: `opacity 0.7s ease ${delay}ms, transform 0.7s ease ${delay}ms`,
      }}
    >
      {children}
    </div>
  );
};