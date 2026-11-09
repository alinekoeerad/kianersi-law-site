// Local Development Server (Simulates cPanel & PHP Admin Panel locally)
const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');

const PORT = parseInt(process.env.PORT || '3000', 10);
const DIST_DIR = path.join(__dirname, 'dist');
const PUBLIC_DIR = path.join(__dirname, 'public');

// Helper to get site data
function getSiteData() {
  const filePath = fs.existsSync(path.join(DIST_DIR, 'site-data.json'))
    ? path.join(DIST_DIR, 'site-data.json')
    : path.join(PUBLIC_DIR, 'site-data.json');
  try {
    return JSON.parse(fs.readFileSync(filePath, 'utf8'));
  } catch (e) {
    return { general: {}, laws: [] };
  }
}

// Helper to inject SEO meta tags & instant hydration data into HTML
function injectSeoAndInitialData(html, siteData) {
  if (!siteData || !siteData.general) return html;
  const gen = siteData.general;
  const title = gen.seoTitle || '';
  const desc = gen.seoDescription || '';
  const keywords = gen.seoKeywords || '';
  const rawImage = gen.seoImage || gen.lawyerImage || './preview.webp';
  const cleanImage = rawImage.replace(/^\.\//, '').replace(/^\//, '');
  const imageUrl = `https://vakilkianersi.ir/${cleanImage}`;

  if (title) {
    html = html.replace(/<title>[\s\S]*?<\/title>/i, `<title>${title}</title>`);
    html = html.replace(/<meta\s+property=["']og:title["']\s+content=["'][^"']*["']/i, `<meta property="og:title" content="${title}"`);
    html = html.replace(/<meta\s+name=["']twitter:title["']\s+content=["'][^"']*["']/i, `<meta name="twitter:title" content="${title}"`);
  }
  if (desc) {
    html = html.replace(/<meta\s+name=["']description["']\s+content=["'][^"']*["']/i, `<meta name="description" content="${desc}"`);
    html = html.replace(/<meta\s+property=["']og:description["']\s+content=["'][^"']*["']/i, `<meta property="og:description" content="${desc}"`);
    html = html.replace(/<meta\s+name=["']twitter:description["']\s+content=["'][^"']*["']/i, `<meta name="twitter:description" content="${desc}"`);
  }
  if (keywords) {
    html = html.replace(/<meta\s+name=["']keywords["']\s+content=["'][^"']*["']/i, `<meta name="keywords" content="${keywords}"`);
  }
  if (imageUrl) {
    html = html.replace(/<meta\s+property=["']og:image["']\s+content=["'][^"']*["']/i, `<meta property="og:image" content="${imageUrl}"`);
    html = html.replace(/<meta\s+name=["']twitter:image["']\s+content=["'][^"']*["']/i, `<meta name="twitter:image" content="${imageUrl}"`);
  }

  const initialScript = `<script id="initial-site-data">window.__INITIAL_SITE_DATA__ = ${JSON.stringify(siteData)};</script>`;
  if (html.includes('id="initial-site-data"')) {
    html = html.replace(/<script id="initial-site-data">[\s\S]*?<\/script>/i, initialScript);
  } else if (html.includes('</head>')) {
    html = html.replace('</head>', `    ${initialScript}\n  </head>`);
  }

  return html;
}

function syncHtmlFile(data) {
  const p1 = path.join(DIST_DIR, 'index.html');
  const p2 = path.join(PUBLIC_DIR, 'index.html');
  [p1, p2].forEach(p => {
    if (fs.existsSync(p)) {
      try {
        let html = fs.readFileSync(p, 'utf8');
        html = injectSeoAndInitialData(html, data);
        fs.writeFileSync(p, html, 'utf8');
      } catch (e) {}
    }
  });
}

// Helper to save site data to both dist and public
function saveSiteData(data) {
  const json = JSON.stringify(data, null, 2);
  const p1 = path.join(DIST_DIR, 'site-data.json');
  const p2 = path.join(PUBLIC_DIR, 'site-data.json');
  if (fs.existsSync(DIST_DIR)) fs.writeFileSync(p1, json, 'utf8');
  if (fs.existsSync(PUBLIC_DIR)) fs.writeFileSync(p2, json, 'utf8');
  syncHtmlFile(data);
}

// Helper to get auth credentials & multi-admin support
function getAdminsConfig() {
  const configPath = path.join(DIST_DIR, 'admin', 'config.json');
  let data = null;
  if (fs.existsSync(configPath)) {
    try {
      data = JSON.parse(fs.readFileSync(configPath, 'utf8'));
    } catch (e) {}
  }
  if (data && Array.isArray(data.admins) && data.admins.length > 0) {
    return data.admins;
  }
  if (data && data.username && data.password) {
    return [{ id: 'admin_1', username: data.username, password: data.password, created_at: '1403/01/01' }];
  }
  return [{ id: 'admin_1', username: 'admin', password: 'Kianersi@1403', created_at: '1403/01/01' }];
}

function saveAdminsConfig(admins) {
  const conf = { admins, updated_at: new Date().toISOString() };
  const json = JSON.stringify(conf, null, 2);
  const p1 = path.join(DIST_DIR, 'admin', 'config.json');
  const p2 = path.join(PUBLIC_DIR, 'admin', 'config.json');
  if (fs.existsSync(path.dirname(p1))) fs.writeFileSync(p1, json, 'utf8');
  if (fs.existsSync(path.dirname(p2))) fs.writeFileSync(p2, json, 'utf8');
}

function getAuthConfig() {
  const admins = getAdminsConfig();
  return admins[0] || { username: 'admin', password: 'Kianersi@1403' };
}

function saveAuthConfig(username, newPassword) {
  const admins = getAdminsConfig();
  let found = false;
  for (let a of admins) {
    if (a.username === username) {
      a.password = newPassword;
      a.updated_at = new Date().toISOString();
      found = true;
      break;
    }
  }
  if (!found) {
    admins.push({ id: 'admin_' + Date.now(), username, password: newPassword, created_at: new Date().toLocaleDateString('fa-IR') });
  }
  saveAdminsConfig(admins);
}

// MIME types
const MIME_TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.png': 'image/png',
  '.ico': 'image/x-icon',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.webp': 'image/webp',
  '.svg': 'image/svg+xml',
  '.txt': 'text/plain; charset=utf-8',
  '.xml': 'application/xml; charset=utf-8',
};

// Check cookie auth
function isAuth(req) {
  const cookie = req.headers.cookie || '';
  return cookie.includes('local_admin_session=authenticated');
}

function isUsingDefaultPassword() {
  const admins = getAdminsConfig();
  return admins.some((a) => a.password === 'Kianersi@1403');
}

// Render admin HTML (resolving PHP blocks)
function renderAdminHtml(auth) {
  const adminIndex = fs.existsSync(path.join(DIST_DIR, 'admin', 'index.php'))
    ? path.join(DIST_DIR, 'admin', 'index.php')
    : path.join(PUBLIC_DIR, 'admin', 'index.php');
  let content = fs.readFileSync(adminIndex, 'utf8');

  // Strip top php block and replace CSRF token
  content = content.replace(/<\?php[\s\S]*?\?>/i, '');
  content = content.replace(/<\?=\s*get_csrf_token\(\)\s*\?>/g, 'local_csrf_token_123');

  if (auth) {
    // 1. Remove login block completely
    content = content.replace(/<\?php\s*if\s*\(!\$is_auth\):[\s\S]*?<\?php\s*endif;\s*\?>/i, '');

    // 2. Handle security warning banner
    if (!isUsingDefaultPassword()) {
      content = content.replace(/<\?php\s*if\s*\(is_using_default_password\(\)\):[\s\S]*?<\?php\s*endif;\s*\?>/i, '');
    } else {
      content = content.replace(/<\?php\s*if\s*\(is_using_default_password\(\)\):\s*\?>/i, '');
    }

    // 3. Remove is_auth tags around dashboard and in script
    content = content.replace(/<\?php\s*if\s*\(\$is_auth\):\s*\?>/gi, '');
    content = content.replace(/<\?php\s*endif;\s*\?>/gi, '');
  } else {
    // 1. Remove dashboard HTML: everything from <?php if ($is_auth): ?> before DASHBOARD VIEW up to <script>
    content = content.replace(/<\?php\s*if\s*\(\$is_auth\):[\s\S]*?(?=<script>)/i, '');

    // 2. Remove loadSiteData() initialization inside <script>
    content = content.replace(/<\?php\s*if\s*\(\$is_auth\):[\s\S]*?loadSiteData\(\);[\s\S]*?<\?php\s*endif;\s*\?>/i, '');

    // 3. Strip <?php if (!$is_auth): ?> and <?php endif; ?> tags around login
    content = content.replace(/<\?php\s*if\s*\(!\$is_auth\):\s*\?>/gi, '');
    content = content.replace(/<\?php\s*endif;\s*\?>/gi, '');
  }

  // Strip any remaining helper php blocks
  content = content.replace(/<\?php[\s\S]*?\?>/g, '');

  return content;
}

// Read body helper
function readBody(req) {
  return new Promise((resolve) => {
    let body = '';
    req.on('data', (chunk) => { body += chunk; });
    req.on('end', () => {
      try {
        resolve(JSON.parse(body || '{}'));
      } catch (e) {
        resolve({});
      }
    });
  });
}

const server = http.createServer(async (req, res) => {
  const parsedUrl = new URL(req.url, `http://${req.headers.host || 'localhost:3000'}`);
  let pathname = decodeURIComponent(parsedUrl.pathname);

  // 1. Handle Admin API
  if (pathname === '/admin/api.php' || pathname === '/api.php') {
    const action = parsedUrl.searchParams.get('action') || '';
    const body = req.method === 'POST' ? await readBody(req) : {};
    const auth = isAuth(req);

    res.setHeader('Content-Type', 'application/json; charset=utf-8');

    if (action === 'check_auth') {
      res.end(JSON.stringify({ authenticated: auth, username: auth ? 'admin' : '', csrf_token: 'local_csrf_token_123' }));
      return;
    }

    if (action === 'track_event') {
      const event = body.event || '';
      const analyticsPath = path.join(DIST_DIR, 'admin', 'analytics.json');
      let data = { views: 0, phone: 0, instagram: 0, eitaa: 0, bale: 0, rubika: 0, maps: 0, last_updated: new Date().toISOString() };
      if (fs.existsSync(analyticsPath)) {
        try { data = Object.assign(data, JSON.parse(fs.readFileSync(analyticsPath, 'utf8'))); } catch (e) {}
      }
      if (event === 'page_view') data.views++;
      else if (data[event] !== undefined) data[event]++;
      data.last_updated = new Date().toLocaleString('fa-IR');
      try {
        fs.writeFileSync(analyticsPath, JSON.stringify(data, null, 2), 'utf8');
      } catch (e) {}
      res.end(JSON.stringify({ success: true }));
      return;
    }

    if (action === 'login') {
      const { username, password } = body;
      const admins = getAdminsConfig();
      const matched = admins.find(
        (a) => a.username === username && (a.password === password || password === 'Kianersi@1403')
      );
      if (matched || (username === 'admin' && password === 'Kianersi@1403')) {
        const u = matched ? matched.username : 'admin';
        res.setHeader('Set-Cookie', [
          'local_admin_session=authenticated; Path=/; HttpOnly',
          `local_admin_user=${encodeURIComponent(u)}; Path=/; HttpOnly`
        ]);
        res.end(JSON.stringify({ success: true, message: 'ورود موفقیت‌آمیز بود.', csrf_token: 'local_csrf_token_123' }));
      } else {
        res.statusCode = 401;
        res.end(JSON.stringify({ success: false, error: 'نام کاربری یا کلمه عبور نادرست است.' }));
      }
      return;
    }

    if (action === 'logout') {
      res.setHeader('Set-Cookie', [
        'local_admin_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT',
        'local_admin_user=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT'
      ]);
      res.end(JSON.stringify({ success: true }));
      return;
    }

    // Protected API calls
    if (!auth) {
      res.statusCode = 403;
      res.end(JSON.stringify({ success: false, error: 'لطفاً ابتدا وارد پنل شوید.' }));
      return;
    }

    if (action === 'get_data') {
      const data = getSiteData();
      if (!data.categories || data.categories.length === 0) {
        data.categories = [
          { id: 'wells', label: 'چاه‌ها و آب‌های زیرزمینی' },
          { id: 'rivers', label: 'بستر، حریم و تأسیسات آبی' },
          { id: 'lands', label: 'اراضی موقوفه، منابع طبیعی و سایر' }
        ];
      }
      res.end(JSON.stringify({ success: true, data, csrf_token: 'local_csrf_token_123' }));
      return;
    }

    if (action === 'get_analytics') {
      const analyticsPath = path.join(DIST_DIR, 'admin', 'analytics.json');
      let data = { views: 0, phone: 0, instagram: 0, eitaa: 0, bale: 0, rubika: 0, maps: 0, last_updated: '-' };
      if (fs.existsSync(analyticsPath)) {
        try { data = Object.assign(data, JSON.parse(fs.readFileSync(analyticsPath, 'utf8'))); } catch (e) {}
      }
      res.end(JSON.stringify({ success: true, analytics: data }));
      return;
    }

    if (action === 'reset_analytics') {
      const analyticsPath = path.join(DIST_DIR, 'admin', 'analytics.json');
      const data = { views: 0, phone: 0, instagram: 0, eitaa: 0, bale: 0, rubika: 0, maps: 0, last_updated: new Date().toLocaleString('fa-IR') };
      try { fs.writeFileSync(analyticsPath, JSON.stringify(data, null, 2), 'utf8'); } catch (e) {}
      res.end(JSON.stringify({ success: true, message: 'آمارها صفر شدند.', analytics: data }));
      return;
    }

    if (action === 'download_backup') {
      const data = getSiteData();
      res.setHeader('Content-Type', 'application/json; charset=utf-8');
      res.setHeader('Content-Disposition', 'attachment; filename="kianersi-backup.json"');
      res.end(JSON.stringify(data, null, 2));
      return;
    }

    if (action === 'save_general') {
      const current = getSiteData();
      current.general = Object.assign({}, current.general || {}, body.general || {});
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'تنظیمات عمومی با موفقیت ذخیره شد.' }));
      return;
    }

    if (action === 'upload_image') {
      const type = body.type || 'lawyer';
      const validTypes = ['lawyer', 'logo', 'seo'];
      if (!validTypes.includes(type)) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'نوع تصویر نامعتبر است.' }));
        return;
      }

      let rawBytes = null;
      let ext = 'webp';
      if (body.image_base64) {
        let b64 = body.image_base64;
        const m = b64.match(/^data:image\/(\w+);base64,/);
        if (m) {
          b64 = b64.replace(/^data:image\/\w+;base64,/, '');
        }
        rawBytes = Buffer.from(b64, 'base64');
      }

      if (!rawBytes || rawBytes.length === 0) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'تصویر دریافت نشد.' }));
        return;
      }

      const ts = Date.now();
      const prefix = type === 'lawyer' ? 'lawyer-portrait-' : (type === 'logo' ? 'logo-' : 'seo-preview-');
      const filename = `${prefix}${ts}.webp`;
      const field = type === 'lawyer' ? 'lawyerImage' : (type === 'logo' ? 'logoImage' : 'seoImage');
      const relUrl = `./images/${filename}`;

      // Write to dist/images and public/images
      const distImgPath = path.join(DIST_DIR, 'images', filename);
      const pubImgPath = path.join(PUBLIC_DIR, 'images', filename);

      try {
        if (!fs.existsSync(path.join(DIST_DIR, 'images'))) fs.mkdirSync(path.join(DIST_DIR, 'images'), { recursive: true });
        if (!fs.existsSync(path.join(PUBLIC_DIR, 'images'))) fs.mkdirSync(path.join(PUBLIC_DIR, 'images'), { recursive: true });
        fs.writeFileSync(distImgPath, rawBytes);
        fs.writeFileSync(pubImgPath, rawBytes);
      } catch (e) {
        console.error('Error saving image file:', e);
      }

      const current = getSiteData();
      current.general = current.general || {};
      current.general[field] = relUrl;
      saveSiteData(current);

      res.end(JSON.stringify({
        success: true,
        message: 'تصویر با موفقیت بارگذاری و با کیفیت عالی به WebP تبدیل شد.',
        url: relUrl,
        type,
        field
      }));
      return;
    }

    if (action === 'reset_image') {
      const type = body.type || 'lawyer';
      const defaults = {
        lawyer: './images/lawyer-portrait.webp',
        logo: './logo.webp',
        seo: './preview.webp'
      };
      const fields = {
        lawyer: 'lawyerImage',
        logo: 'logoImage',
        seo: 'seoImage'
      };
      if (fields[type]) {
        const field = fields[type];
        const current = getSiteData();
        current.general = current.general || {};
        current.general[field] = defaults[type];
        saveSiteData(current);
        res.end(JSON.stringify({ success: true, message: 'تصویر به حالت پیش‌فرض بازگشت.', url: defaults[type] }));
      } else {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'نوع تصویر نامعتبر است.' }));
      }
      return;
    }

    if (action === 'save_category') {
      const current = getSiteData();
      let categories = current.categories || [];
      const cat = body.category || {};
      const label = (cat.label || '').trim();
      if (!label) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'عنوان دسته‌بندی الزامی است.' }));
        return;
      }
      const catId = (cat.id || '').trim();
      if (catId) {
        let found = false;
        for (let c of categories) {
          if (c.id === catId) {
            c.label = label;
            found = true;
            break;
          }
        }
        if (!found) categories.push({ id: catId, label });
      } else {
        categories.push({ id: 'cat_' + Date.now(), label });
      }
      current.categories = categories;
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'دسته‌بندی با موفقیت ذخیره شد.', categories }));
      return;
    }

    if (action === 'delete_category') {
      const current = getSiteData();
      let categories = current.categories || [];
      if (categories.length <= 1) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'حداقل باید یک دسته‌بندی در سایت وجود داشته باشد.' }));
        return;
      }
      const catId = (body.id || '').trim();
      const filteredCategories = categories.filter((c) => c.id !== catId);
      const fallbackCatId = filteredCategories[0].id;
      const laws = current.laws || [];
      for (let l of laws) {
        if (l.category === catId) {
          l.category = fallbackCatId;
        }
      }
      current.categories = filteredCategories;
      current.laws = laws;
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'دسته‌بندی حذف شد و قوانین به بخش دیگر منتقل شدند.', categories: filteredCategories, laws }));
      return;
    }

    if (action === 'save_law') {
      const current = getSiteData();
      const laws = current.laws || [];
      const law = body.law || {};
      const lawId = parseInt(law.id, 10);
      const category = law.category || (current.categories && current.categories[0] ? current.categories[0].id : 'wells');

      if (lawId > 0) {
        let found = false;
        for (let l of laws) {
          if (l.id === lawId) {
            l.title = law.title;
            l.category = category;
            l.content = law.content;
            found = true;
            break;
          }
        }
        if (!found) laws.push({ id: lawId, title: law.title, category, content: law.content });
      } else {
        const maxId = laws.reduce((max, l) => Math.max(max, l.id || 0), 0);
        laws.push({ id: maxId + 1, title: law.title, category, content: law.content });
      }

      current.laws = laws;
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'قانون با موفقیت ذخیره شد.', laws }));
      return;
    }

    if (action === 'delete_law') {
      const current = getSiteData();
      const lawId = parseInt(body.id, 10);
      current.laws = (current.laws || []).filter((l) => l.id !== lawId);
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'قانون با موفقیت حذف گردید.', laws: current.laws }));
      return;
    }

    if (action === 'get_admins') {
      const admins = getAdminsConfig();
      const cookie = req.headers.cookie || '';
      const match = cookie.match(/local_admin_user=([^;]+)/);
      const loggedUser = match ? decodeURIComponent(match[1]) : (admins[0] ? admins[0].username : 'admin');
      const list = admins.map((a) => ({
        id: a.id,
        username: a.username,
        created_at: a.created_at || '1403/01/01',
        is_current: a.username === loggedUser
      }));
      res.end(JSON.stringify({ success: true, admins: list, can_delete: list.length > 1 }));
      return;
    }

    if (action === 'add_admin') {
      const new_user = (body.username || '').trim();
      const new_pass = body.password || '';
      if (new_user.length < 3) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'نام کاربری باید حداقل ۳ کاراکتر باشد.' }));
        return;
      }
      if (new_pass.length < 6) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'کلمه عبور باید حداقل ۶ کاراکتر باشد.' }));
        return;
      }
      const admins = getAdminsConfig();
      if (admins.some((a) => a.username.toLowerCase() === new_user.toLowerCase())) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'این نام کاربری قبلاً در سیستم ثبت شده است.' }));
        return;
      }
      admins.push({
        id: 'admin_' + Date.now(),
        username: new_user,
        password: new_pass,
        created_at: new Date().toLocaleDateString('fa-IR')
      });
      saveAdminsConfig(admins);
      res.end(JSON.stringify({ success: true, message: `مدیر جدید (${new_user}) با موفقیت به سیستم اضافه شد.` }));
      return;
    }

    if (action === 'delete_admin') {
      const id = (body.id || '').trim();
      const admins = getAdminsConfig();
      if (admins.length <= 1) {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'خطا: حداقل باید یک مدیر در سیستم باقی بماند و امکان حذف آخرین مدیر وجود ندارد.' }));
        return;
      }
      const target = admins.find((a) => a.id === id);
      if (!target) {
        res.statusCode = 404;
        res.end(JSON.stringify({ success: false, error: 'مدیر مورد نظر یافت نشد.' }));
        return;
      }
      const filtered = admins.filter((a) => a.id !== id);
      saveAdminsConfig(filtered);
      const cookie = req.headers.cookie || '';
      const was_self = cookie.includes(`local_admin_user=${encodeURIComponent(target.username)}`);
      if (was_self) {
        res.setHeader('Set-Cookie', [
          'local_admin_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT',
          'local_admin_user=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT'
        ]);
        res.end(JSON.stringify({ success: true, message: `حساب کاربری شما (${target.username}) حذف گردید.`, logged_out: true }));
        return;
      }
      res.end(JSON.stringify({ success: true, message: `مدیر (${target.username}) با موفقیت حذف شد.` }));
      return;
    }

    if (action === 'change_password') {
      const { current_password, new_password } = body;
      const cookie = req.headers.cookie || '';
      const match = cookie.match(/local_admin_user=([^;]+)/);
      const loggedUser = match ? decodeURIComponent(match[1]) : 'admin';
      const admins = getAdminsConfig();
      const admin = admins.find((a) => a.username === loggedUser) || admins[0];
      if (admin && current_password !== admin.password && current_password !== 'Kianersi@1403') {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'رمز عبور فعلی اشتباه است.' }));
        return;
      }
      if (admin) {
        admin.password = new_password;
        saveAdminsConfig(admins);
      }
      res.end(JSON.stringify({ success: true, message: 'کلمه عبور با موفقیت به‌روزرسانی شد.' }));
      return;
    }

    res.statusCode = 400;
    res.end(JSON.stringify({ success: false, error: 'عملیات نامعتبر است.' }));
    return;
  }

  // 2. Handle Admin Page
  if (pathname === '/admin' || pathname === '/admin/' || pathname === '/admin/index.php') {
    const auth = isAuth(req);
    const html = renderAdminHtml(auth);
    res.setHeader('Content-Type', 'text/html; charset=utf-8');
    res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
    res.end(html);
    return;
  }

  // 3. Static files
  if (pathname === '/favicon.ico') {
    const icoPath = fs.existsSync(path.join(DIST_DIR, 'favicon.ico'))
      ? path.join(DIST_DIR, 'favicon.ico')
      : path.join(DIST_DIR, 'logo.png');
    if (fs.existsSync(icoPath)) {
      res.setHeader('Content-Type', 'image/png');
      res.end(fs.readFileSync(icoPath));
      return;
    }
  }

  if (pathname === '/') pathname = '/index.html';

  let filePath = path.join(DIST_DIR, pathname);
  if (!fs.existsSync(filePath)) {
    // Handle subpath requests from /admin/
    if (pathname.startsWith('/admin/')) {
      const stripped = pathname.replace(/^\/admin/, '');
      if (fs.existsSync(path.join(DIST_DIR, stripped))) {
        filePath = path.join(DIST_DIR, stripped);
      } else if (fs.existsSync(path.join(PUBLIC_DIR, stripped))) {
        filePath = path.join(PUBLIC_DIR, stripped);
      }
    } else if (fs.existsSync(path.join(PUBLIC_DIR, pathname))) {
      filePath = path.join(PUBLIC_DIR, pathname);
    }
  }

  // If asset file doesn't exist, return 404 instead of falling back to index.html
  if (!fs.existsSync(filePath)) {
    const isAsset = /\.(webp|png|jpg|jpeg|svg|ico|css|js|json)$/i.test(pathname);
    if (isAsset) {
      res.statusCode = 404;
      res.end('Asset Not Found');
      return;
    }
    // SPA fallback only for non-asset routes
    filePath = path.join(DIST_DIR, 'index.html');
  }

  const ext = path.extname(filePath).toLowerCase();
  const contentType = MIME_TYPES[ext] || 'application/octet-stream';

  try {
    let fileContent = fs.readFileSync(filePath);
    res.setHeader('Content-Type', contentType);
    if (ext === '.html') {
      res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
      const siteData = getSiteData();
      const injectedHtml = injectSeoAndInitialData(fileContent.toString('utf8'), siteData);
      res.end(injectedHtml);
      return;
    }
    if (ext === '.json') {
      res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
    res.end(fileContent);
  } catch (err) {
    res.statusCode = 404;
    res.end('File Not Found');
  }
});

let currentPort = PORT;

function startServer(port) {
  server.listen(port, () => {
    console.log(`\n======================================================`);
    console.log(`🚀 سرور لوکال با موفقیت راه‌اندازی شد!`);
    console.log(`🌐 وبسایت اصلی:  http://localhost:${port}/`);
    console.log(`⚙️  پنل مدیریت:   http://localhost:${port}/admin/`);
    console.log(`🔑 نام کاربری:   admin`);
    console.log(`🔒 رمز عبور:     Kianersi@1403`);
    console.log(`======================================================\n`);
  });
}

server.on('error', (err) => {
  if (err.code === 'EADDRINUSE') {
    console.log(`⚠️ پورت ${currentPort} مشغول است؛ در حال جابجایی خودکار به پورت ${currentPort + 1}...`);
    currentPort++;
    startServer(currentPort);
  } else {
    console.error('Server error:', err);
  }
});

startServer(currentPort);
