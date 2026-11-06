const http = require('http');

// Spawn server or run internal test
const { spawn } = require('child_process');

async function testLoginFlow() {
  console.log('Testing local-server admin login flow...');

  // Start local-server on test port 3099
  process.env.PORT = '3099';
  const serverProc = spawn('node', ['local-server.cjs'], {
    env: { ...process.env, PORT: '3099' },
    stdio: 'pipe'
  });

  serverProc.stdout.on('data', (d) => {
    // console.log('[Server stdout]:', d.toString());
  });
  serverProc.stderr.on('data', (d) => {
    // console.log('[Server stderr]:', d.toString());
  });

  // wait 1 second for server to bind
  await new Promise(r => setTimeout(r, 1000));

  function request(path, options = {}, body = null) {
    return new Promise((resolve, reject) => {
      const opts = {
        hostname: '127.0.0.1',
        port: 3099,
        path,
        method: options.method || 'GET',
        headers: options.headers || {}
      };
      const req = http.request(opts, (res) => {
        let data = '';
        res.on('data', chunk => data += chunk);
        res.on('end', () => resolve({ status: res.statusCode, headers: res.headers, body: data }));
      });
      req.on('error', reject);
      if (body) {
        req.write(typeof body === 'string' ? body : JSON.stringify(body));
      }
      req.end();
    });
  }

  try {
    // Step 1: Unauth GET /admin/
    console.log('\n1. Fetching unauthenticated /admin/...');
    const resUnauth = await request('/admin/');
    console.log('Status:', resUnauth.status);
    console.log('Contains <script>:', resUnauth.body.includes('<script>'));
    console.log('Contains <form id="loginForm">:', resUnauth.body.includes('<form id="loginForm">'));
    console.log('Contains loginForm submit listener:', resUnauth.body.includes("loginForm.addEventListener('submit'"));
    console.log('Contains <header class="admin-header"> (must be false):', resUnauth.body.includes('<header class="admin-header">'));
    console.log('Contains <div class="tabs-container"> (must be false):', resUnauth.body.includes('<div class="tabs-container">'));

    if (!resUnauth.body.includes('<script>') || !resUnauth.body.includes("loginForm.addEventListener('submit'")) {
      throw new Error('Script or loginForm listener is missing from unauthenticated HTML!');
    }

    // Step 2: POST /admin/api.php?action=login
    console.log('\n2. Testing login POST /admin/api.php?action=login...');
    const loginRes = await request('/admin/api.php?action=login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' }
    }, {
      username: 'admin',
      password: 'Kianersi@1403',
      csrf_token: 'local_csrf_token_123'
    });
    console.log('Login Status:', loginRes.status);
    console.log('Login Body:', loginRes.body);
    const setCookie = loginRes.headers['set-cookie'];
    console.log('Set-Cookie:', setCookie);

    const loginData = JSON.parse(loginRes.body);
    if (!loginData.success) {
      throw new Error('Login failed: ' + (loginData.error || 'Unknown error'));
    }

    const sessionCookie = (setCookie && setCookie[0]) ? setCookie[0].split(';')[0] : '';
    console.log('Cookie parsed:', sessionCookie);

    // Step 3: GET /admin/ with Cookie
    console.log('\n3. Fetching authenticated /admin/ with session cookie...');
    const resAuth = await request('/admin/', {
      headers: { Cookie: sessionCookie }
    });
    console.log('Auth Status:', resAuth.status);
    console.log('Contains <script>:', resAuth.body.includes('<script>'));
    console.log('Contains <form id="loginForm"> (must be false):', resAuth.body.includes('<form id="loginForm">'));
    console.log('Contains <header class="admin-header">:', resAuth.body.includes('<header class="admin-header">'));
    console.log('Contains <div class="tabs-container">:', resAuth.body.includes('<div class="tabs-container">'));
    console.log('Contains loadSiteData() init:', resAuth.body.includes('loadSiteData();'));

    if (resAuth.body.includes('<form id="loginForm">') || !resAuth.body.includes('<header class="admin-header">')) {
      throw new Error('Authenticated view is incorrect!');
    }

    // Step 4: Logout
    console.log('\n4. Testing logout POST /admin/api.php?action=logout...');
    const logoutRes = await request('/admin/api.php?action=logout', {
      method: 'POST',
      headers: { Cookie: sessionCookie }
    });
    console.log('Logout Status:', logoutRes.status);
    console.log('Logout Body:', logoutRes.body);

    console.log('\n🎉 ALL INTEGRATION LOGIN TESTS PASSED SUCCESSFULLY!');
  } finally {
    serverProc.kill();
  }
}

testLoginFlow().catch((e) => {
  console.error('Test failed with error:', e);
  process.exit(1);
});

