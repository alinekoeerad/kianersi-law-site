# مرحله اول: بیلد کردن پروژه
FROM node:22-alpine AS build

# تنظیم پوشه کاری در کانتینر
WORKDIR /app

# کپی کردن فایل‌های مربوط به پکیج‌ها برای نصب نیازمندی‌ها
COPY package*.json ./

# نصب وابستگی‌ها
RUN npm install

# کپی کردن کل فایل‌های پروژه به داخل کانتینر
COPY . .

# بیلد کردن پروژه (تولید پوشه dist)
RUN npm run build

# مرحله دوم: سرو کردن فایل‌ها با Nginx
FROM nginx:alpine

# کپی کردن فایل‌های بیلد شده از مرحله قبل به مسیر پیش‌فرض Nginx
COPY --from=build /app/dist /usr/share/nginx/html

# پورت پیش‌فرض Nginx
EXPOSE 80

# اجرای Nginx
CMD ["nginx", "-g", "daemon off;"]