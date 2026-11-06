import { useState, useMemo } from 'react';
import { Scale, Maximize2, Minimize2, ChevronDown, X } from 'lucide-react';
import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';
import { useSiteData } from '../context/SiteDataContext';

// Helper function to convert English digits to Persian digits
const toPersianDigits = (n: number | string) => {
  return n.toString().replace(/\d/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[parseInt(d, 10)]);
};

// Count keyword occurrences in text
const countOccurrences = (text: string, term: string) => {
  if (!term.trim()) return 0;
  const normalizedText = text.toLowerCase();
  const normalizedTerm = term.trim().toLowerCase();
  let count = 0;
  let pos = 0;
  while ((pos = normalizedText.indexOf(normalizedTerm, pos)) !== -1) {
    count++;
    pos += normalizedTerm.length;
  }
  return count;
};

// Map law to category intelligently (defined outside to avoid TDZ / initialization order issues)
const getCategoryForLaw = (law: { id: number; title: string; content: string; category?: string }) => {
  if (law.category) return law.category;
  if ([1, 2, 3, 5].includes(law.id)) return 'wells';
  if ([4, 8].includes(law.id)) return 'rivers';
  const text = (law.title + ' ' + law.content).toLowerCase();
  if (text.includes('چاه') || text.includes('قنات') || text.includes('آبخوان') || text.includes('زیرزمینی')) return 'wells';
  if (text.includes('بستر') || text.includes('حریم') || text.includes('رودخانه') || text.includes('مسیل')) return 'rivers';
  return 'lands';
};

export default function LawsSection() {
  const { laws, categories: customCategories } = useSiteData();
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string>('all');
  const [openAll, setOpenAll] = useState<boolean | null>(null);

  const categories = useMemo(() => {
    const list = [
      { id: 'all', label: 'همه قوانین' },
      ...(customCategories && customCategories.length > 0
        ? customCategories
        : [
            { id: 'wells', label: 'چاه‌ها و آب‌های زیرزمینی' },
            { id: 'rivers', label: 'بستر، حریم و تأسیسات آبی' },
            { id: 'lands', label: 'اراضی موقوفه، منابع طبیعی و سایر' }
          ])
    ];

    // Ensure any category ID found in laws is represented in tabs even if not listed
    const knownIds = new Set(list.map((c) => c.id));
    laws.forEach((l) => {
      const catId = getCategoryForLaw(l);
      if (catId && !knownIds.has(catId)) {
        list.push({
          id: catId,
          label: catId
        });
        knownIds.add(catId);
      }
    });

    return list;
  }, [customCategories, laws]);

  // Quick suggestion tags for faster user discovery
  const quickTags = [
    'چاه فاقد پروانه',
    'بستر و حریم',
    'کمیسیون',
    'کنتور هوشمند',
    'توزیع عادلانه آب',
    'آلودگی آب'
  ];

  const getCategoryLabel = (catId?: string) => {
    if (!catId || catId === 'all') return null;
    const found = categories.find((c) => c.id === catId);
    return found ? found.label : null;
  };

  // Category counts
  const categoryCounts = useMemo(() => {
    const counts: Record<string, number> = { all: laws.length };
    categories.forEach(cat => {
      if (cat.id !== 'all') {
        counts[cat.id] = laws.filter((l) => getCategoryForLaw(l) === cat.id).length;
      }
    });
    return counts;
  }, [laws, categories]);

  // Filtered laws with match counts
  const filteredLaws = useMemo(() => {
    const normalizedSearch = searchTerm.trim().toLowerCase();

    return laws
      .map((law) => {
        const matchesCategory = selectedCategory === 'all' || getCategoryForLaw(law) === selectedCategory;
        const titleMatches = countOccurrences(law.title, normalizedSearch);
        const contentMatches = countOccurrences(law.content, normalizedSearch);
        const totalMatches = titleMatches + contentMatches;
        const matchesSearch = !normalizedSearch || totalMatches > 0;

        return {
          ...law,
          totalMatches,
          isMatch: matchesCategory && matchesSearch
        };
      })
      .filter((law) => law.isMatch);
  }, [searchTerm, selectedCategory, laws]);

  // Helper function to highlight the searched keyword
  const highlightSearchTerm = (text: string, term: string) => {
    if (!term.trim()) return toPersianDigits(text);
    const escaped = term.trim().replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escaped})`, 'gi');
    const parts = text.split(regex);
    if (parts.length === 1) return toPersianDigits(text);

    return parts.map((part, i) => {
      if (i % 2 === 1) {
        return (
          <mark
            key={i}
            className="bg-cyan-500/30 text-cyan-100 font-bold px-1 py-0.5 rounded-sm border-b-2 border-cyan-400 mx-0.5"
          >
            {toPersianDigits(part)}
          </mark>
        );
      }
      return toPersianDigits(part);
    });
  };

  // Helper function to format legal text line by line with advanced regex + search highlighting
  const formatLegalText = (text: string, term: string) => {
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
                  {highlightSearchTerm(part, term)}
                </span>
              );
            }
            return <span key={index}>{highlightSearchTerm(part, term)}</span>;
          })}
          {lineIndex < array.length - 1 ? '\n' : ''}
        </span>
      );
    });
  };

  return (
    <section id="laws" className="bg-section-alt" style={{ borderTop: '2px solid rgba(14,116,144,0.25)', borderBottom: '2px solid rgba(14,116,144,0.25)' }}>
      <div className="max-w-5xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
        
        {/* Section Header */}
        <AnimSection>
          <div className="text-center mb-10">
            <SectionLabel>منابع و مستندات قانونی</SectionLabel>
            <h2 className="article-title text-2xl sm:text-3xl md:text-4xl mt-2" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
              کتابخانه قوانین و مقررات کاربردی آب و اراضی
            </h2>
            <p className="mt-3 text-xs sm:text-sm max-w-2xl mx-auto leading-7 sm:leading-8" style={{ color: '#cbd5e1', fontFamily: 'Noto Sans Arabic' }}>
              متن کامل قوانین، آیین‌نامه‌ها و دستورالعمل‌های موضوعه جهت بهره‌برداری و استناد در پرونده‌های حقوقی.
            </p>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Enhanced High-End Search & Filter Card */}
        <AnimSection delay={100}>
          <div 
            className="p-4 sm:p-6 mb-8 rounded-sm space-y-5 transition-all"
            style={{ 
              backgroundColor: 'rgba(10, 30, 40, 0.85)', 
              border: '1px solid rgba(14, 116, 144, 0.35)',
              boxShadow: '0 8px 30px rgba(0,0,0,0.3)'
            }}
          >
            {/* Search Input Box */}
            <div>
              <label className="block text-xs font-semibold mb-2" style={{ color: '#7dd3fc', fontFamily: 'Noto Sans Arabic' }}>
                جستجو در متن مواد، تبصره‌ها و عناوین قوانین:
              </label>
              
              <div className="relative flex items-center">
                {/* Clean SVG Search Icon */}
                <div className="absolute right-3.5 flex items-center pointer-events-none text-cyan-400">
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>

                <input
                  type="text"
                  placeholder="عبارت مورد نظر خود را تایپ کنید (مثلاً: چاه فاقد پروانه، حریم رودخانه، کنتور هوشمند، کمیسیون)..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pr-11 pl-11 py-3 text-xs md:text-sm rounded-sm transition-all focus:outline-none placeholder-gray-400"
                  style={{
                    backgroundColor: 'rgba(2, 15, 26, 0.75)',
                    border: '1px solid rgba(14, 116, 144, 0.45)',
                    color: '#ffffff',
                    fontFamily: 'Noto Sans Arabic'
                  }}
                />

                {/* Clean SVG Clear Button */}
                {searchTerm && (
                  <button
                    type="button"
                    onClick={() => setSearchTerm('')}
                    className="absolute left-3 p-1.5 rounded-full text-gray-400 hover:text-white hover:bg-cyan-900/40 transition-colors"
                    title="پاک کردن جستجو"
                    aria-label="پاک کردن جستجو"
                  >
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                )}
              </div>
            </div>

            {/* Quick Keyword Suggestion Tags */}
            <div className="flex flex-wrap items-center gap-2 pt-1">
              <span className="text-[11px] text-gray-400" style={{ fontFamily: 'Noto Sans Arabic' }}>
                جستجوهای متداول:
              </span>
              {quickTags.map((tag) => {
                const isActive = searchTerm === tag;
                return (
                  <button
                    key={tag}
                    type="button"
                    onClick={() => setSearchTerm(isActive ? '' : tag)}
                    className="text-[11px] px-2.5 py-1 rounded-sm transition-all flex items-center gap-1"
                    style={{
                      backgroundColor: isActive ? 'rgba(14, 116, 144, 0.35)' : 'rgba(2, 15, 26, 0.6)',
                      color: isActive ? '#7dd3fc' : '#cbd5e1',
                      border: isActive ? '1px solid #0e7490' : '1px solid rgba(14, 116, 144, 0.25)',
                      fontFamily: 'Noto Sans Arabic'
                    }}
                  >
                    <span>{tag}</span>
                    {isActive && <X className="w-3 h-3 stroke-[2.5]" />}
                  </button>
                );
              })}
            </div>

            {/* Editorial Category Tabs & Expand/Collapse Controls */}
            <div className="pt-3 border-t flex flex-wrap items-center justify-between gap-3 sm:gap-4" style={{ borderColor: 'rgba(14, 116, 144, 0.2)' }}>
              
              {/* Category Tabs */}
              <div className="flex flex-wrap items-center gap-1.5 sm:gap-2">
                {categories.map((cat) => {
                  const isSelected = selectedCategory === cat.id;
                  const count = categoryCounts[cat.id as keyof typeof categoryCounts];
                  return (
                    <button
                      key={cat.id}
                      type="button"
                      onClick={() => setSelectedCategory(cat.id as any)}
                      className="text-xs py-1.5 px-2.5 sm:px-3 rounded-sm transition-all duration-200 flex items-center gap-1.5"
                      style={{
                        backgroundColor: isSelected ? 'rgba(14, 116, 144, 0.25)' : 'transparent',
                        color: isSelected ? '#ffffff' : '#94a3b8',
                        borderBottom: isSelected ? '2px solid #0e7490' : '2px solid transparent',
                        fontWeight: isSelected ? 600 : 400,
                        fontFamily: 'Noto Sans Arabic'
                      }}
                    >
                      <span>{cat.label}</span>
                      <span 
                        className="text-[10px] px-1.5 py-0.2 rounded-full"
                        style={{
                          backgroundColor: isSelected ? '#0e7490' : 'rgba(255, 255, 255, 0.08)',
                          color: isSelected ? '#ffffff' : '#94a3b8'
                        }}
                      >
                        {toPersianDigits(count ?? 0)}
                      </span>
                    </button>
                  );
                })}
              </div>

              {/* Expand / Collapse Controls */}
              <div className="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button
                  type="button"
                  onClick={() => setOpenAll(true)}
                  className="text-xs px-2.5 py-1.5 rounded-sm text-gray-300 hover:text-cyan-300 transition-colors flex items-center gap-1.5 flex-1 sm:flex-none justify-center"
                  style={{ border: '1px solid rgba(14, 116, 144, 0.3)', backgroundColor: 'rgba(2, 15, 26, 0.5)' }}
                >
                  <Maximize2 className="w-3.5 h-3.5 stroke-[2]" />
                  <span>باز کردن همه</span>
                </button>
                <button
                  type="button"
                  onClick={() => setOpenAll(false)}
                  className="text-xs px-2.5 py-1.5 rounded-sm text-gray-300 hover:text-cyan-300 transition-colors flex items-center gap-1.5 flex-1 sm:flex-none justify-center"
                  style={{ border: '1px solid rgba(14, 116, 144, 0.3)', backgroundColor: 'rgba(2, 15, 26, 0.5)' }}
                >
                  <Minimize2 className="w-3.5 h-3.5 stroke-[2]" />
                  <span>بستن همه</span>
                </button>
              </div>

            </div>

            {/* Results Counter Bar */}
            <div className="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs text-gray-400">
              <p>
                نمایش <strong className="text-cyan-300 font-bold">{toPersianDigits(filteredLaws.length)}</strong> قانون از مجموع <strong className="text-cyan-300 font-bold">{toPersianDigits(laws.length)}</strong> قانون
              </p>
              {searchTerm && (
                <p className="text-cyan-300 font-medium">
                  فیلتر بر اساس عبارت «{searchTerm}»
                </p>
              )}
            </div>

          </div>
        </AnimSection>

        {/* Laws Accordion List */}
        <AnimSection delay={200}>
          {filteredLaws.length === 0 ? (
            <div className="p-6 sm:p-10 text-center rounded-sm bg-slate-900/60 border border-cyan-900/40 space-y-3">
              <Scale className="w-10 h-10 mx-auto text-cyan-400 stroke-[1.8]" />
              <p className="text-sm font-semibold text-gray-200">
                موردی متناسب با عبارت جستجوی «{searchTerm}» یافت نشد.
              </p>
              <p className="text-xs text-gray-400 max-w-md mx-auto leading-6">
                پیشنهاد می‌شود املای واژه را بررسی کرده یا از عبارات کلی‌تر نظیر «چاه»، «حریم»، «پروانه» یا «تأسیسات» استفاده کنید.
              </p>
              <button 
                type="button"
                onClick={() => { setSearchTerm(''); setSelectedCategory('all'); }}
                className="mt-2 text-xs px-4 py-2 rounded-sm font-semibold transition-all hover:brightness-110"
                style={{ backgroundColor: '#0e7490', color: '#ffffff' }}
              >
                پاک کردن فیلترها و مشاهده همه قوانین
              </button>
            </div>
          ) : (
            <div className="space-y-4">
              {filteredLaws.map((law) => {
                const isAutoOpen = searchTerm.trim().length > 0;
                const isOpen = openAll === true ? true : openAll === false ? false : isAutoOpen ? true : undefined;

                return (
                  <details 
                    key={`${law.id}-${openAll}-${searchTerm}`} 
                    open={isOpen}
                    className="group p-4 sm:p-5 rounded-sm transition-colors duration-300 hover:bg-cyan-950/40 overflow-hidden break-words min-w-0 max-w-full" 
                    style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}
                  >
                    
                    <summary className="flex items-center justify-between cursor-pointer list-none font-semibold text-sm outline-none gap-2 sm:gap-3 min-w-0" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc' }}>
                      <div className="flex items-center gap-2 flex-wrap flex-1 min-w-0">
                        <span className="text-[11px] sm:text-xs px-2 py-0.5 rounded-sm bg-cyan-950 text-cyan-300 border border-cyan-800/50 flex-shrink-0">
                          قانون {toPersianDigits(law.id)}
                        </span>
                        {getCategoryLabel(getCategoryForLaw(law)) && (
                          <span className="text-[10px] sm:text-[11px] px-2 py-0.5 rounded-sm bg-cyan-900/30 text-cyan-200 border border-cyan-700/40 flex-shrink-0">
                            {getCategoryLabel(getCategoryForLaw(law))}
                          </span>
                        )}
                        <span className="group-hover:text-white transition-colors duration-300 text-xs sm:text-sm md:text-base break-words">
                          {highlightSearchTerm(law.title, searchTerm)}
                        </span>
                      </div>

                      <div className="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                        {searchTerm.trim() && law.totalMatches > 0 && (
                          <span className="text-[11px] sm:text-xs px-2 sm:px-2.5 py-0.5 rounded-sm bg-cyan-500/20 text-cyan-200 border border-cyan-500/40 font-sans">
                            {toPersianDigits(law.totalMatches)} مورد
                          </span>
                        )}
                        <ChevronDown className="w-4 h-4 text-cyan-400 group-open:rotate-180 transition-transform duration-300 stroke-[2.2]" />
                      </div>
                    </summary>
                    
                    <div className="mt-4 pt-4 legal-article overflow-hidden break-words min-w-0 max-w-full" style={{ borderTop: '1px solid rgba(14,116,144,0.2)', whiteSpace: 'pre-wrap' }}>
                      {formatLegalText(law.content, searchTerm)}
                    </div>
                    
                  </details>
                );
              })}
            </div>
          )}
        </AnimSection>
        
      </div>
    </section>
  );
}
