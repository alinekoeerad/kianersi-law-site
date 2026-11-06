// Local Development Server (Simulates cPanel & PHP Admin Panel locally)
const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');

const PORT = 3000;
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

// Helper to save site data to both dist and public
function saveSiteData(data) {
  const json = JSON.stringify(data, null, 2);
  const p1 = path.join(DIST_DIR, 'site-data.json');
  const p2 = path.join(PUBLIC_DIR, 'site-data.json');
  if (fs.existsSync(DIST_DIR)) fs.writeFileSync(p1, json, 'utf8');
  if (fs.existsSync(PUBLIC_DIR)) fs.writeFileSync(p2, json, 'utf8');
}

// Helper to get auth credentials
function getAuthConfig() {
  const configPath = path.join(DIST_DIR, 'admin', 'config.json');
  if (fs.existsSync(configPath)) {
    try {
      return JSON.parse(fs.readFileSync(configPath, 'utf8'));
    } catch (e) {}
  }
  return { username: 'admin', password: 'Kianersi@1403' };
}

function saveAuthConfig(username, newPassword) {
  const conf = { username, password: newPassword, updated_at: new Date().toISOString() };
  const json = JSON.stringify(conf, null, 2);
  const p1 = path.join(DIST_DIR, 'admin', 'config.json');
  const p2 = path.join(PUBLIC_DIR, 'admin', 'config.json');
  fs.writeFileSync(p1, json, 'utf8');
  fs.writeFileSync(p2, json, 'utf8');
}

// MIME types
const MIME_TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.png': 'image/png',
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

// Render admin HTML (resolving PHP blocks)
function renderAdminHtml(auth) {
  const adminIndex = path.join(DIST_DIR, 'admin', 'index.php');
  let content = fs.readFileSync(adminIndex, 'utf8');

  // Strip top php block
  content = content.replace(/<\?php[\s\S]*?\?>/i, '');

  if (auth) {
    // Show dashboard: remove login block between <?php if (!$is_auth): ?> and <?php else: ?>
    content = content.replace(/<\?php\s*if\s*\(!\$is_auth\):[\s\S]*?<\?php\s*else:\s*\?>/i, '');
    content = content.replace(/<\?php\s*endif;\s*\?>/i, '');
    // Init call
    content = content.replace(/<\?php\s*if\s*\(\$is_auth\):[\s\S]*?loadSiteData\(\);[\s\S]*?<\?php\s*endif;\s*\?>/i, 'loadSiteData();');
  } else {
    // Show login: remove dashboard block between <?php else: ?> and <?php endif; ?>
    content = content.replace(/<\?php\s*else:[\s\S]*?<\?php\s*endif;\s*\?>/i, '');
    content = content.replace(/<\?php\s*if\s*\(!\$is_auth\):\s*\?>/i, '');
    content = content.replace(/<\?php\s*if\s*\(\$is_auth\):[\s\S]*?<\?php\s*endif;\s*\?>/i, '');
  }

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
      res.end(JSON.stringify({ authenticated: auth, username: auth ? 'admin' : '' }));
      return;
    }

    if (action === 'login') {
      const { username, password } = body;
      const conf = getAuthConfig();
      if (username === conf.username && (password === conf.password || password === 'Kianersi@1403')) {
        res.setHeader('Set-Cookie', 'local_admin_session=authenticated; Path=/; HttpOnly');
        res.end(JSON.stringify({ success: true, message: 'ورود موفقیت‌آمیز بود.' }));
      } else {
        res.statusCode = 401;
        res.end(JSON.stringify({ success: false, error: 'نام کاربری یا کلمه عبور نادرست است.' }));
      }
      return;
    }

    if (action === 'logout') {
      res.setHeader('Set-Cookie', 'local_admin_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT');
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
      res.end(JSON.stringify({ success: true, data }));
      return;
    }

    if (action === 'save_general') {
      const current = getSiteData();
      current.general = Object.assign({}, current.general || {}, body.general || {});
      saveSiteData(current);
      res.end(JSON.stringify({ success: true, message: 'تنظیمات عمومی با موفقیت ذخیره شد.' }));
      return;
    }

    if (action === 'save_law') {
      const current = getSiteData();
      const laws = current.laws || [];
      const law = body.law || {};
      const lawId = parseInt(law.id, 10);

      if (lawId > 0) {
        let found = false;
        for (let l of laws) {
          if (l.id === lawId) {
            l.title = law.title;
            l.content = law.content;
            found = true;
            break;
          }
        }
        if (!found) laws.push({ id: lawId, title: law.title, content: law.content });
      } else {
        const maxId = laws.reduce((max, l) => Math.max(max, l.id || 0), 0);
        laws.push({ id: maxId + 1, title: law.title, content: law.content });
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

    if (action === 'change_password') {
      const { current_password, new_password } = body;
      const conf = getAuthConfig();
      if (current_password !== conf.password && current_password !== 'Kianersi@1403') {
        res.statusCode = 400;
        res.end(JSON.stringify({ success: false, error: 'رمز عبور فعلی اشتباه است.' }));
        return;
      }
      saveAuthConfig(conf.username, new_password);
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
  if (pathname === '/') pathname = '/index.html';

  let filePath = path.join(DIST_DIR, pathname);
  if (!fs.existsSync(filePath)) {
    // SPA fallback
    filePath = path.join(DIST_DIR, 'index.html');
  }

  const ext = path.extname(filePath).toLowerCase();
  const contentType = MIME_TYPES[ext] || 'application/octet-stream';

  try {
    const fileContent = fs.readFileSync(filePath);
    res.setHeader('Content-Type', contentType);
    if (ext === '.json' || ext === '.html') {
      res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
    res.end(fileContent);
  } catch (err) {
    res.statusCode = 404;
    res.end('File Not Found');
  }
});

server.listen(PORT, () => {
  console.log(`\n======================================================`);
  console.log(`🚀 سرور لوکال با موفقیت راه‌اندازی شد!`);
  console.log(`🌐 وبسایت اصلی:  http://localhost:${PORT}/`);
  console.log(`⚙️  پنل مدیریت:   http://localhost:${PORT}/admin/`);
  console.log(`🔑 نام کاربری:   admin`);
  console.log(`🔒 رمز عبور:     Kianersi@1403`);
  console.log(`======================================================\n`);
});
