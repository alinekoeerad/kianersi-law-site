import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';
import { lawsDatabase } from '../data/laws';

export default function LawsSection() {
  
  // Helper function to format legal text line by line with advanced regex
  const formatLegalText = (text: string) => {
    if (!text) return null;
    
    return text.split('\n').map((line, lineIndex, array) => {
      
      // Added condition to capture standalone dashes at the beginning of a line: ^\s*[-–ـ_]\s*
      const regex = /((?:ماده\s+واحده|(?:ماده|تبصره)\s*[0-9۰-۹]+|(?:فصل|بخش)\s+(?:اول|دوم|سوم|چهارم|پنجم|ششم|هفتم|هشتم|نهم|دهم|یازدهم|دوازدهم|[0-9۰-۹]+))\s*[-–ـ_]?|^\s*(?:الف|ب|پ|ت|ث|ج|چ|ح|خ|د|ذ|ر|ز|ژ|س|ش|ص|ض|ط|ظ|ع|غ|ف|ق|ک|گ|ل|م|ن|و|ه|ی|[0-9۰-۹]+)\s*[-–ـ_)]|^\s*[-–ـ_]\s*)/g;
      
      const parts = line.split(regex);
      
      return (
        <span key={lineIndex}>
          {parts.map((part, index) => {
            if (index % 2 === 1) {
              return (
                <span key={index} className="legal-highlight">
                  {part}
                </span>
              );
            }
            return <span key={index}>{part}</span>;
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
          <div className="text-center mb-14">
            <SectionLabel>منابع حقوقی</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ color: '#ffffff', fontFamily: 'Noto Naskh Arabic, serif' }}>
              کتابخانه قوانین و مقررات کاربردی
            </h2>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        {/* Laws Accordion List */}
        <AnimSection delay={100}>
          <div className="space-y-4">
            {lawsDatabase.map((law) => (
              <details 
                key={law.id} 
                className="group p-5 rounded-sm transition-colors duration-300 hover:bg-cyan-950/40" 
                style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}
              >
                
                <summary className="flex items-center justify-between cursor-pointer list-none font-semibold text-sm outline-none" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#7dd3fc' }}>
                  <span className="group-hover:text-white transition-colors duration-300">{law.title}</span>
                  <span className="text-cyan-600 group-open:rotate-180 transition-transform duration-300">▼</span>
                </summary>
                
                <div className="mt-4 pt-4 legal-article" style={{ borderTop: '1px solid rgba(14,116,144,0.2)', whiteSpace: 'pre-wrap' }}>
                  {formatLegalText(law.content)}
                </div>
                
              </details>
            ))}
          </div>
        </AnimSection>
        
      </div>
    </section>
  );
}