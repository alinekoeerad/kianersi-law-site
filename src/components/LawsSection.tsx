import { useState, useMemo } from 'react';
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';
import { lawsDatabase } from '../data/laws';

// Helper function to convert English digits to Persian digits
const toPersianDigits = (n: number | string) => {
  return n.toString().replace(/\d/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[parseInt(d, 10)]);
};

export default function LawsSection() {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<'all' | 'wells' | 'rivers' | 'lands'>('all');
  const [openAll, setOpenAll] = useState<boolean | null>(null);

  const categories = [
    { id: 'all', label: 'همه قوانین' },
    { id: 'wells', label: 'چاه‌ها و آب‌های زیرزمینی' },
    { id: 'rivers', label: 'بستر، حریم و تأسیسات آبی' },
    { id: 'lands', label: 'اراضی موقوفه و آلودگی آب' }
  ];

  // Map law id to category
  const getCategoryForLaw = (id: number) => {
    if ([1, 2, 3, 5].includes(id)) return 'wells';
    if ([4, 8].includes(id)) return 'rivers';
    return 'lands';
  };

  // Filtered laws
  const filteredLaws = useMemo(() => {
    return lawsDatabase.filter((law) => {
      const matchesCategory = selectedCategory === 'all' || getCategoryForLaw(law.id) === selectedCategory;
      const normalizedSearch = searchTerm.trim().toLowerCase();
      const matchesSearch = !normalizedSearch || 
        law.title.toLowerCase().includes(normalizedSearch) || 
        law.content.toLowerCase().includes(normalizedSearch);

      return matchesCategory && matchesSearch;
    });
  }, [searchTerm, selectedCategory]);
  
  // Helper function to format legal text line by line with advanced regex
  const formatLegalText = (text: string) => {
    if (!text) return null;
    
    return text.split('\n').map((line, lineIndex, array) => {
      const regex = /((?:ماده\s+واحده|(?:ماده|تبصره)\s*[0-9۰-۹]+|(?:فصل|بخش)\s+(?:اول|دوم|سوم|چهارم|پنجم|ششم|هفتم|هشتم|نهم|دهم|یازدهم|دوازدهم|[0-9۰-۹]+))\s*[-–ـ_]?|^\s*(?:الف|ب|پ|ت|ث|ج|چ|ح|خ|د|ذ|ر|ز|ژ|س|ش|ص|ض|ط|ظ|ع|غ|ف|ق|ک|گ|ل|م|ن|و|ه|ی|[0-9۰-۹]+)\s*[-–ـ_)]|^\s*[-–ـ_]\s*)/g;
      const parts = line.split(regex);
      
      return (
        <span key={lineIndex}>
          {parts.map((part, index) => {
            if (index % 2 === 1) {
              return (
                <span key={index} className="legal-highlight">
                  {toPersianDigits(part)}
                </span>
              );
            }
            return <span key={index}>{toPersianDigits(part)}</span>;
          })}
          {lineIndex < array.length - 1 ? '\n' : ''}
        </span>
      );
    });
  };

  return (
    <section id="laws" className="bg-section-alt" style={{ borderTop: '2px solid rgba(14,116,144,0.25)', borderBottom: '2px solid rgba(14,116,144,0.25)' }}>
      <div className="max-w-5xl mx-auto px-6 py-20">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-10">
            <SectionLabel>منابع و مستندات قانونی</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
              کتابخانه قوانین و مقررات کاربردی آب و اراضی
            </h2>
            <p className="mt-3 text-sm max-w-2xl mx-auto leading-8" style={{ color: '#cbd5e1', fontFamily: 'Noto Sans Arabic' }}>
              متن کامل قوانین، آیین‌نامه‌ها و دستورالعمل‌های موضوعه جهت بهره‌برداری و استناد در پرونده‌های حقوقی.
            </p>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Search & Filter Bar */}
        <AnimSection delay={100}>
          <div className="p-4 mb-6 rounded-sm space-y-4" style={{ backgroundColor: 'rgba(10, 30, 40, 0.8)', border: '1px solid rgba(14,116,144,0.3)' }}>
            
            {/* Search Input */}
            <div className="relative">
              <span className="absolute right-3.5 top-2.5 text-gray-400">🔍</span>
              <input
                type="text"
                placeholder="جستجو در متن یا عنوان قوانین (مثلاً: چاه کشاورزی، حریم رودخانه، کمیسیون، فرم ۵، تبصره ۱)..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pr-10 pl-4 py-2.5 text-xs md:text-sm rounded-sm bg-slate-900 border border-cyan-900/60 text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500"
              />
              {searchTerm && (
                <button
                  onClick={() => setSearchTerm('')}
                  className="absolute left-3 top-2.5 text-xs text-gray-400 hover:text-white"
                >
                  ✕ پاک کردن
                </button>
              )}
            </div>

            {/* Category Filter Pills & Toggle Buttons */}
            <div className="flex flex-wrap items-center justify-between gap-3 pt-1">
              <div className="flex flex-wrap items-center gap-1.5">
                {categories.map((cat) => (
                  <button
                    key={cat.id}
                    onClick={() => setSelectedCategory(cat.id as any)}
                    className="text-xs px-3 py-1.5 rounded-sm transition-all duration-200"
                    style={{
                      backgroundColor: selectedCategory === cat.id ? '#0e7490' : 'rgba(2, 15, 26, 0.6)',
                      color: selectedCategory === cat.id ? '#ffffff' : '#cbd5e1',
                      border: '1px solid rgba(14, 116, 144, 0.3)'
                    }}
                  >
                    {cat.label}
                  </button>
                ))}
              </div>

              {/* Expand / Collapse All */}
              <div className="flex items-center gap-2 text-xs">
                <button
                  onClick={() => setOpenAll(true)}
                  className="text-cyan-400 hover:text-cyan-300 underline"
                >
                  باز کردن همه
                </button>
                <span className="text-gray-600">|</span>
                <button
                  onClick={() => setOpenAll(false)}
                  className="text-cyan-400 hover:text-cyan-300 underline"
                >
                  بستن همه
                </button>
              </div>
            </div>

            {/* Result count with Persian Digits */}
            <div className="text-xs text-gray-400 pt-1 border-t border-cyan-950">
              نمایش <strong className="text-cyan-300 font-bold">{toPersianDigits(filteredLaws.length)}</strong> عنوان قانون از مجموع <strong className="text-cyan-300 font-bold">{toPersianDigits(lawsDatabase.length)}</strong> عنوان
            </div>

          </div>
        </AnimSection>

        {/* Laws Accordion List */}
        <AnimSection delay={200}>
          {filteredLaws.length === 0 ? (
            <div className="p-8 text-center rounded-sm bg-slate-900/50 border border-cyan-900/30">
              <p className="text-sm text-gray-300 mb-2">موردی متناسب با عبارت جستجوی «{searchTerm}» یافت نشد.</p>
              <button 
                onClick={() => { setSearchTerm(''); setSelectedCategory('all'); }}
                className="text-xs text-cyan-400 hover:underline"
              >
                نمایش همه قوانین
              </button>
            </div>
          ) : (
            <div className="space-y-4">
              {filteredLaws.map((law) => (
                <details 
                  key={`${law.id}-${openAll}`} 
                  open={openAll === true ? true : openAll === false ? false : undefined}
                  className="group p-5 rounded-sm transition-colors duration-300 hover:bg-cyan-950/40" 
                  style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}
                >
                  
                  <summary className="flex items-center justify-between cursor-pointer list-none font-semibold text-sm outline-none" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc' }}>
                    <span className="group-hover:text-white transition-colors duration-300 flex items-center gap-2">
                      <span className="text-xs px-2 py-0.5 rounded-sm bg-cyan-900/50 text-cyan-300">
                        قانون شماره {toPersianDigits(law.id)}
                      </span>
                      <span>{law.title}</span>
                    </span>
                    <span className="text-cyan-400 group-open:rotate-180 transition-transform duration-300">▼</span>
                  </summary>
                  
                  <div className="mt-4 pt-4 legal-article" style={{ borderTop: '1px solid rgba(14,116,144,0.2)', whiteSpace: 'pre-wrap' }}>
                    {formatLegalText(law.content)}
                  </div>
                  
                </details>
              ))}
            </div>
          )}
        </AnimSection>
        
      </div>
    </section>
  );
}
