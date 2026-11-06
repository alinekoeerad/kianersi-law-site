import React, { createContext, useContext, useState, useEffect } from 'react';
import { lawsDatabase, LawItem } from '../data/laws';

export interface GeneralData {
  lawyerName: string;
  title: string;
  subtitle: string;
  experienceYears: string;
  commissionYears: string;
  educationDegree: string;
  educationField: string;
  phone: string;
  rawPhone: string;
  address: string;
  instagram: string;
  instagramUrl: string;
  eitaa: string;
  eitaaUrl: string;
  bale: string;
  baleUrl: string;
  rubika: string;
  rubikaUrl: string;
  lawyerImage?: string;
  logoImage?: string;
  seoImage?: string;
  seoTitle?: string;
  seoDescription?: string;
  seoKeywords?: string;
  latitude?: string | number;
  longitude?: string | number;
  neshanUrl?: string;
  baladUrl?: string;
  googleMapsUrl?: string;
}

export interface LawCategory {
  id: string;
  label: string;
}

export interface SiteData {
  general: GeneralData;
  categories: LawCategory[];
  laws: LawItem[];
}

export const defaultSiteData: SiteData = {
  general: {
    lawyerName: 'محمدحسن کیان‌ارثی',
    title: 'وکیل پایه یک دادگستری کرج',
    subtitle: 'متخصص دعاوی حقوقی منابع آب، کمیسیون‌های آب‌های زیرزمینی و دیوان عدالت اداری',
    experienceYears: '۲۰',
    commissionYears: '۱۳',
    educationDegree: 'M.A',
    educationField: 'حقوق بین‌الملل',
    phone: '۰۹۱۲۷۶۹۸۸۶۴',
    rawPhone: '+989127698864',
    address: 'کرج، بلوار ملاصدرا، بالاتر از دبیرستان سلام البرز، ساختمان وکلای صدرا، طبقه دوم، واحد ۸',
    instagram: '@kianersi.mohamad',
    instagramUrl: 'https://www.instagram.com/kianersi.mohamad?mdxt=eGZjdzN2MWMyaXEx',
    eitaa: '@Mohamadhasankianersi',
    eitaaUrl: 'https://eitaa.com/Mohamadhasankianersi',
    bale: '@Mohamadhasankianersi',
    baleUrl: 'https://ble.ir/Mohamadhasankianersi',
    rubika: '@Mka12345666',
    rubikaUrl: 'https://rubika.ir/Mka12345666',
    lawyerImage: './images/lawyer-portrait.webp',
    logoImage: './logo.webp',
    seoImage: './images/lawyer-portrait.webp',
    seoTitle: 'محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج - دعاوی تخصصی آب و اراضی',
    seoDescription: 'دفتر وکالت محمدحسن کیان‌ارثی؛ وکیل پایه یک دادگستری در کرج و تهران با ۲۰+ سال سابقه تخصصی در دعاوی حقوق آب، چاه‌های کشاورزی، حریم رودخانه، کمیسیون‌ها و دیوان عدالت اداری. مشاوره: ۰۹۱۲۷۶۹۸۸۶۴',
    seoKeywords: 'محمدحسن کیان‌ارثی, محمد حسن کیان ارثی, وکیل کیان ارثی, وکیل پایه یک دادگستری کرج, وکیل دعاوی آب کرج, وکیل چاه کشاورزی البرز, وکیل کمیسیون آب‌های زیرزمینی, وکیل حریم رودخانه, وکیل دیوان عدالت اداری کرج',
    latitude: '35.8427497',
    longitude: '50.991522',
  },
  categories: [
    { id: 'wells', label: 'چاه‌ها و آب‌های زیرزمینی' },
    { id: 'rivers', label: 'بستر، حریم و تأسیسات آبی' },
    { id: 'lands', label: 'اراضی موقوفه، منابع طبیعی و سایر' }
  ],
  laws: lawsDatabase
};

const SiteDataContext = createContext<SiteData>(defaultSiteData);

export const SiteDataProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [data, setData] = useState<SiteData>(defaultSiteData);

  useEffect(() => {
    // Fetch dynamic data from site-data.json if present (cache-busted)
    fetch('./site-data.json?v=' + Date.now())
      .then(res => {
        if (!res.ok) throw new Error('Not found');
        return res.json();
      })
      .then(json => {
        if (json && json.laws && Array.isArray(json.laws) && json.general) {
          const gen = { ...defaultSiteData.general, ...json.general };
          setData({
            general: gen,
            categories: Array.isArray(json.categories) && json.categories.length > 0 
              ? json.categories 
              : defaultSiteData.categories,
            laws: json.laws
          });

          // Dynamically update document title and meta tags if provided
          if (gen.seoTitle) {
            document.title = gen.seoTitle;
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) ogTitle.setAttribute('content', gen.seoTitle);
            const twTitle = document.querySelector('meta[name="twitter:title"]');
            if (twTitle) twTitle.setAttribute('content', gen.seoTitle);
          }
          if (gen.seoDescription) {
            const metaDesc = document.querySelector('meta[name="description"]');
            if (metaDesc) metaDesc.setAttribute('content', gen.seoDescription);
            const ogDesc = document.querySelector('meta[property="og:description"]');
            if (ogDesc) ogDesc.setAttribute('content', gen.seoDescription);
            const twDesc = document.querySelector('meta[name="twitter:description"]');
            if (twDesc) twDesc.setAttribute('content', gen.seoDescription);
          }
          if (gen.seoKeywords) {
            const metaKeys = document.querySelector('meta[name="keywords"]');
            if (metaKeys) metaKeys.setAttribute('content', gen.seoKeywords);
          }
          if (gen.seoImage) {
            const ogImg = document.querySelector('meta[property="og:image"]');
            if (ogImg) ogImg.setAttribute('content', gen.seoImage);
            const twImg = document.querySelector('meta[name="twitter:image"]');
            if (twImg) twImg.setAttribute('content', gen.seoImage);
          }
        }
      })
      .catch(() => {
        // Fallback to default bundled data gracefully
      });
  }, []);

  return (
    <SiteDataContext.Provider value={data}>
      {children}
    </SiteDataContext.Provider>
  );
};

export const useSiteData = () => useContext(SiteDataContext);

