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
    rubikaUrl: 'https://rubika.ir/Mka12345666'
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
          setData({
            general: { ...defaultSiteData.general, ...json.general },
            laws: json.laws
          });
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

