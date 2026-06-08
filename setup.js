import fs from 'fs';
import path from 'path';

// مسیر پوشه‌هایی که باید ساخته شوند
const dirs = ['src/components', 'src/data'];

// لیست فایل‌هایی که باید ساخته شوند
const files = [
  'src/data/laws.ts',
  'src/components/SharedUI.tsx',
  'src/components/Navbar.tsx',
  'src/components/HeroSection.tsx',
  'src/components/AboutSection.tsx',
  'src/components/ExpertiseSection.tsx',
  'src/components/DistinguishingSection.tsx',
  'src/components/LawsSection.tsx',
  'src/components/ContactSection.tsx',
  'src/components/Footer.tsx'
];

// ساخت پوشه‌ها
dirs.forEach(dir => {
  const dirPath = path.resolve(dir);
  if (!fs.existsSync(dirPath)) {
    fs.mkdirSync(dirPath, { recursive: true });
    console.log(`✅ پوشه ساخته شد: ${dir}`);
  }
});

// ساخت فایل‌ها
files.forEach(file => {
  const filePath = path.resolve(file);
  if (!fs.existsSync(filePath)) {
    fs.writeFileSync(filePath, '', 'utf8');
    console.log(`✅ فایل ساخته شد: ${file}`);
  }
});

console.log('🎉 تمامی فایل‌ها و پوشه‌ها با موفقیت ایجاد شدند! حالا می‌توانید کدها را کپی کنید.');