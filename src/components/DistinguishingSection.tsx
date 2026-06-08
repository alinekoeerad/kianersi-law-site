import { AnimSection, SectionLabel, OrnamentDivider } from './SharedUI';

export default function DistinguishingSection() {
  return (
    <section className="py-20 bg-deep">
      <div className="max-w-7xl mx-auto px-6">
        <AnimSection>
          <div className="text-center mb-14">
            <SectionLabel>ویژگی‌های حرفه‌ای</SectionLabel>
            <h2 className="article-title text-3xl md:text-4xl mt-2" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: '#ffffff' }}>
              چرا مسئولیت پرونده خود را به ایشان بسپاریم؟
            </h2>
            <OrnamentDivider className="max-w-md mx-auto mt-6" />
          </div>
        </AnimSection>

        <div className="grid md:grid-cols-12 gap-8 items-start">
          <AnimSection className="md:col-span-4">
            <div className="space-y-6">
              <div className="p-8 rounded-sm" style={{ backgroundColor: 'rgba(10, 30, 40, 0.75)', border: '1px solid rgba(14,116,144,0.3)' }}>
                <p className="section-label mb-4" style={{ color: '#0e7490' }}>وجوه تمایز</p>
                <p className="leading-9 text-base font-light text-justify" style={{ fontFamily: 'Noto Naskh Arabic, serif', color: 'rgba(255,255,255,0.9)', fontSize: '0.95rem' }}>
                  پیشینه ارزشمند و سابقه طولانی خدمت مستمر در دفاتر حقوقی شرکت‌های آب منطقه‌ای تهران و البرز و عضویت در کمیسیون بستر و حریم و صدور پروانه‌ها، ایشان را به جزئیات بخشنامه‌ها و فرآیندهای داخلی وزارت نیرو مسلط ساخته است؛ مزیتی که وکلای عمومی از آن بی‌بهره‌اند.
                </p>
              </div>
              
              <div className="relative overflow-hidden rounded-sm border border-cyan-900/30 shadow-lg">
                <img 
                  src="./images/divan-edalat.webp" 
                  alt="دیوان عدالت اداری" 
                  loading="lazy"
                  className="w-full h-48 object-cover opacity-80 hover:opacity-100 transition-opacity duration-500 image-glow" 
                />
                <div className="absolute bottom-3 right-3 bg-cyan-950/90 backdrop-blur-sm px-3 py-1.5 text-xs text-cyan-100 rounded-sm border border-cyan-800/50">
                  دفاع مؤثر در دیوان عدالت اداری
                </div>
              </div>
            </div>
          </AnimSection>

          <AnimSection className="md:col-span-8" delay={150}>
            <div>
              <div className="newspaper-columns">
                <p className="body-text text-sm leading-9 mb-4 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                  <strong className="text-cyan-400">نگاه راهبردی و چندبعدی:</strong> تلفیق نگرش کلانِ حقوقی و رویه‌های حقوقی داخلی وزارت نیرو، سبب می‌شود تا هر پرونده فراتر از یک بن‌بست موقت، به عنوان یک مسئله راهبردیِ قابل حل نگریسته شود.
                </p>
                <p className="body-text text-sm leading-9 mb-4 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                  <strong className="text-cyan-400">دقت علمی و نگارش فاخر:</strong> تنظیم لوایح، دادخواست‌ها و مدافعات کتبی با استفاده از ادبیات فاخر حقوقی و استناد به آرای وحدت رویه و دکترین حقوقی، که تأثیری شگرف بر اقناع وجدان قضات محترم دارد.
                </p>
                <p className="body-text text-sm leading-9 text-justify" style={{ fontFamily: 'Noto Sans Arabic' }}>
                  <strong className="text-cyan-400">اخلاق حرفه‌ای و شفافیت:</strong> تبیین واقع‌بینانه شانس موفقیت پرونده، پرهیز از امیدهای واهی و تعهد همه‌جانبه به امانت‌داری و حفظ مصلحت موکل.
                </p>
              </div>
            </div>
          </AnimSection>
        </div>
      </div>
    </section>
  );
}