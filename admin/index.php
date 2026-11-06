<?php
require_once __DIR__ . '/config.php';
$is_auth = is_authenticated();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت اختصاصی | دفتر وکالت محمدحسن کیان‌ارثی</title>
    
    <!-- Vazirmatn Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #020f1a;
            --bg-card: rgba(10, 30, 40, 0.85);
            --bg-input: rgba(3, 24, 37, 0.9);
            --border-color: rgba(14, 116, 144, 0.35);
            --border-hover: rgba(125, 211, 252, 0.6);
            --cyan-primary: #0e7490;
            --cyan-light: #7dd3fc;
            --emerald-accent: #059669;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Vazirmatn', system-ui, sans-serif;
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            min-height: 100vh;
            direction: rtl;
            background-image: 
                radial-gradient(ellipse at 20% 50%, rgba(14, 116, 144, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(6, 95, 70, 0.06) 0%, transparent 50%);
        }

        /* ─── Login Screen ─── */
        .login-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            border-radius: 4px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            text-align: center;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .login-desc {
            font-size: 0.825rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* ─── Dashboard Screen ─── */
        .admin-header {
            background: rgba(10, 30, 40, 0.95);
            border-bottom: 2px solid var(--cyan-primary);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
            text-decoration: none;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 3px;
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--cyan-primary);
            color: #ffffff;
        }
        .btn-primary:hover {
            filter: brightness(1.15);
        }

        .btn-success {
            background: var(--emerald-accent);
            color: #ffffff;
        }
        .btn-success:hover {
            filter: brightness(1.15);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--cyan-light);
        }
        .btn-outline:hover {
            border-color: var(--cyan-light);
            background: rgba(14, 116, 144, 0.15);
        }

        .btn-danger {
            background: #991b1b;
            color: #ffffff;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }

        /* ─── Navigation Tabs ─── */
        .tabs-container {
            max-w: 1200px;
            margin: 1.5rem auto 0;
            padding: 0 1.5rem;
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.75rem 1.25rem;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-btn.active {
            color: var(--cyan-light);
            border-bottom-color: var(--cyan-light);
            font-weight: 700;
        }

        /* ─── Main Content Container ─── */
        .main-container {
            max-width: 1200px;
            margin: 1.5rem auto 3rem;
            padding: 0 1.5rem;
        }

        .panel-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 1.75rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
        }

        .card-header {
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(14, 116, 144, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--cyan-light);
        }

        /* ─── Forms ─── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cyan-light);
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.85rem;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 3px;
            color: #ffffff;
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--cyan-light);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
            line-height: 1.8;
        }

        /* ─── Laws Table / List ─── */
        .law-item {
            background: rgba(3, 24, 37, 0.7);
            border: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-radius: 3px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: background 0.2s;
        }
        .law-item:hover {
            background: rgba(14, 116, 144, 0.15);
        }

        .law-info {
            flex: 1;
            min-width: 0;
        }

        .law-badge {
            font-size: 0.75rem;
            background: rgba(14, 116, 144, 0.3);
            color: var(--cyan-light);
            padding: 0.2rem 0.5rem;
            border-radius: 2px;
            margin-left: 0.5rem;
        }

        .law-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
        }

        .law-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        /* ─── Modal ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 1.5rem;
        }

        .modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            width: 100%;
            max-width: 750px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
        }

        /* ─── Notification Toast ─── */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 0.85rem 1.5rem;
            background: var(--emerald-accent);
            color: #ffffff;
            border-radius: 3px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 200;
        }
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast.error {
            background: #dc2626;
        }
    </style>
</head>
<body>

    <div id="toast" class="toast">پیام سیستم</div>

    <?php if (!$is_auth): ?>
    <!-- ─── LOGIN VIEW ─── -->
    <div class="login-wrap">
        <div class="login-card">
            <h1 class="login-title">ورود به پنل مدیریت</h1>
            <p class="login-desc">پایگاه رسمی دفتر وکالت محمدحسن کیان‌ارثی<br>جهت ورود اطلاعات کاربری خود را وارد کنید.</p>
            
            <form id="loginForm">
                <div class="form-group" style="text-align: right;">
                    <label class="form-label">نام کاربری:</label>
                    <input type="text" id="loginUsername" class="form-control" required placeholder="admin" autofocus>
                </div>
                
                <div class="form-group" style="text-align: right; margin-bottom: 1.75rem;">
                    <label class="form-label">کلمه عبور:</label>
                    <input type="password" id="loginPassword" class="form-control" required placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                    ورود به پنل مدیریت
                </button>
            </form>
            
            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(14,116,144,0.2); font-size: 0.75rem; color: var(--text-muted);">
                رمز عبور پیش‌فرض: <code style="color: var(--cyan-light);">Kianersi@1403</code>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- ─── DASHBOARD VIEW ─── -->
    <header class="admin-header">
        <a href="#" class="brand-logo">
            <span style="color: var(--cyan-light);">⚖️</span>
            <span>مدیریت وب‌سایت کیان‌ارثی</span>
        </a>
        <div class="header-actions">
            <a href="../" target="_blank" class="btn btn-outline">
                <span>👁️</span>
                <span>مشاهده سایت</span>
            </a>
            <button onclick="handleLogout()" class="btn btn-danger">
                <span>خروج</span>
            </button>
        </div>
    </header>

    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('general')">⚙️ اطلاعات عمومی و تماس</button>
        <button class="tab-btn" onclick="switchTab('laws')">📜 کتابخانه قوانین و مقررات</button>
        <button class="tab-btn" onclick="switchTab('security')">🔐 تغییر رمز عبور</button>
    </div>

    <main class="main-container">
        
        <!-- TAB 1: GENERAL & CONTACT SETTINGS -->
        <div id="tab-general" class="tab-content">
            <div class="panel-card">
                <div class="card-header">
                    <h2 class="card-title">تنظیمات اصلی و اطلاعات تماس</h2>
                    <button onclick="saveGeneralData()" class="btn btn-success">
                        <span>💾</span>
                        <span>ذخیره تغییرات</span>
                    </button>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نام وکیل:</label>
                        <input type="text" id="lawyerName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">عنوان اصلی هدر:</label>
                        <input type="text" id="lawyerTitle" class="form-control">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">زیرعنوان تخصصی:</label>
                        <input type="text" id="lawyerSubtitle" class="form-control">
                    </div>
                </div>

                <div style="margin: 1.5rem 0 1rem; border-top: 1px solid rgba(14,116,144,0.2); padding-top: 1rem;">
                    <h3 style="font-size: 0.95rem; color: var(--cyan-light); margin-bottom: 1rem;">آمار سوابق و تجربه (کارت‌های هدر)</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">سال‌های سابقه وکالت (عدد):</label>
                            <input type="text" id="expYears" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">سابقه در کمیسیون‌ها (عدد):</label>
                            <input type="text" id="commYears" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">رشته تحصیلی کارشناسی ارشد:</label>
                            <input type="text" id="eduField" class="form-control">
                        </div>
                    </div>
                </div>

                <div style="margin: 1.5rem 0 1rem; border-top: 1px solid rgba(14,116,144,0.2); padding-top: 1rem;">
                    <h3 style="font-size: 0.95rem; color: var(--cyan-light); margin-bottom: 1rem;">راه‌های ارتباط و شبکه‌های اجتماعی</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">شماره تلفن مستقیم:</label>
                            <input type="text" id="phone" class="form-control" placeholder="۰۹۱۲۷۶۹۸۸۶۴">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">نشانی کامل دفتر وکالت کرج:</label>
                            <textarea id="address" class="form-control" style="min-height: 70px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">آیدی اینستاگرام:</label>
                            <input type="text" id="instagram" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">لینک صفحه اینستاگرام:</label>
                            <input type="text" id="instagramUrl" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">آیدی پیام‌رسان ایتا:</label>
                            <input type="text" id="eitaa" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">لینک ارتباط در ایتا:</label>
                            <input type="text" id="eitaaUrl" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">آیدی پیام‌رسان بله:</label>
                            <input type="text" id="bale" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">لینک ارتباط در بله:</label>
                            <input type="text" id="baleUrl" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">آیدی پیام‌رسان روبیکا:</label>
                            <input type="text" id="rubika" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">لینک ارتباط در روبیکا:</label>
                            <input type="text" id="rubikaUrl" class="form-control">
                        </div>
                    </div>
                </div>

                <div style="text-align: left; margin-top: 1.5rem;">
                    <button onclick="saveGeneralData()" class="btn btn-success" style="padding: 0.65rem 1.5rem;">
                        <span>💾</span>
                        <span>ذخیره کلیه تنظیمات</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB 2: LAWS MANAGEMENT -->
        <div id="tab-laws" class="tab-content" style="display: none;">
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">مدیریت کتابخانه قوانین و مقررات</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                            می‌توانید قوانین فعلی را ویرایش کرده یا قانون و آیین‌نامه جدیدی به کتابخانه اضافه فرمایید.
                        </p>
                    </div>
                    <button onclick="openLawModal()" class="btn btn-primary">
                        <span>➕</span>
                        <span>افزودن قانون جدید</span>
                    </button>
                </div>

                <div id="lawsListContainer">
                    <p style="color: var(--text-muted); text-align: center; padding: 2rem;">در حال بارگذاری قوانین...</p>
                </div>
            </div>
        </div>

        <!-- TAB 3: SECURITY & PASSWORD -->
        <div id="tab-security" class="tab-content" style="display: none;">
            <div class="panel-card" style="max-width: 500px;">
                <div class="card-header">
                    <h2 class="card-title">تغییر کلمه عبور مدیر</h2>
                </div>
                
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label class="form-label">کلمه عبور فعلی:</label>
                        <input type="password" id="currentPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">کلمه عبور جدید (حداقل ۶ کاراکتر):</label>
                        <input type="password" id="newPassword" class="form-control" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label class="form-label">تکرار کلمه عبور جدید:</label>
                        <input type="password" id="confirmPassword" class="form-control" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center; margin-top: 1rem;">
                        به‌روزرسانی کلمه عبور
                    </button>
                </form>
            </div>
        </div>

    </main>

    <!-- ─── LAW EDIT / ADD MODAL ─── -->
    <div id="lawModal" class="modal-overlay">
        <div class="modal-box">
            <div class="card-header">
                <h3 id="modalLawHeading" class="card-title">ویرایش قانون</h3>
                <button onclick="closeLawModal()" style="background: none; border: none; color: var(--text-muted); font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            
            <input type="hidden" id="modalLawId">
            
            <div class="form-group">
                <label class="form-label">عنوان کامل قانون یا آیین‌نامه:</label>
                <input type="text" id="modalLawTitle" class="form-control" required placeholder="مثال: قانون توزیع عادلانه آب">
            </div>

            <div class="form-group">
                <label class="form-label">متن کامل مواد و تبصره‌ها (پشتیبانی از چندخطی):</label>
                <textarea id="modalLawContent" class="form-control" style="min-height: 320px; font-size: 0.875rem;" required placeholder="ماده ۱ - ...&#10;تبصره ۱ - ..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeLawModal()" class="btn btn-outline">انصراف</button>
                <button type="button" onclick="saveLawItem()" class="btn btn-success">ذخیره قانون</button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        let currentSiteData = { general: {}, laws: [] };
        let currentCsrfToken = '<?= get_csrf_token() ?>';

        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast show' + (isError ? ' error' : '');
            setTimeout(() => {
                toast.className = 'toast';
            }, 3000);
        }

        // Login Handler
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const username = document.getElementById('loginUsername').value;
                const password = document.getElementById('loginPassword').value;

                try {
                    const res = await fetch('api.php?action=login', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ username, password })
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showToast(data.error || 'خطا در ورود', true);
                    }
                } catch (err) {
                    showToast('خطا در برقراری ارتباط با سرور', true);
                }
            });
        }

        // Logout
        async function handleLogout() {
            if (!confirm('آیا قصد خروج از پنل مدیریت را دارید؟')) return;
            await fetch('api.php?action=logout');
            window.location.reload();
        }

        // Switch Tabs
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            const target = document.getElementById('tab-' + tabId);
            if (target) target.style.display = 'block';

            const activeBtn = Array.from(document.querySelectorAll('.tab-btn')).find(b => b.getAttribute('onclick').includes(tabId));
            if (activeBtn) activeBtn.classList.add('active');
        }

        // Load Data on Startup
        async function loadSiteData() {
            try {
                const res = await fetch('api.php?action=get_data');
                const result = await res.json();
                if (result.csrf_token) currentCsrfToken = result.csrf_token;
                if (result.success && result.data) {
                    currentSiteData = result.data;
                    populateGeneralForm(currentSiteData.general || {});
                    renderLawsList(currentSiteData.laws || []);
                }
            } catch (err) {
                console.error(err);
            }
        }

        function populateGeneralForm(gen) {
            document.getElementById('lawyerName').value = gen.lawyerName || '';
            document.getElementById('lawyerTitle').value = gen.title || '';
            document.getElementById('lawyerSubtitle').value = gen.subtitle || '';
            document.getElementById('expYears').value = gen.experienceYears || '';
            document.getElementById('commYears').value = gen.commissionYears || '';
            document.getElementById('eduField').value = gen.educationField || '';
            document.getElementById('phone').value = gen.phone || '';
            document.getElementById('address').value = gen.address || '';
            document.getElementById('instagram').value = gen.instagram || '';
            document.getElementById('instagramUrl').value = gen.instagramUrl || '';
            document.getElementById('eitaa').value = gen.eitaa || '';
            document.getElementById('eitaaUrl').value = gen.eitaaUrl || '';
            document.getElementById('bale').value = gen.bale || '';
            document.getElementById('baleUrl').value = gen.baleUrl || '';
            document.getElementById('rubika').value = gen.rubika || '';
            document.getElementById('rubikaUrl').value = gen.rubikaUrl || '';
        }

        // Save General Form
        async function saveGeneralData() {
            const general = {
                lawyerName: document.getElementById('lawyerName').value,
                title: document.getElementById('lawyerTitle').value,
                subtitle: document.getElementById('lawyerSubtitle').value,
                experienceYears: document.getElementById('expYears').value,
                commissionYears: document.getElementById('commYears').value,
                educationField: document.getElementById('eduField').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                instagram: document.getElementById('instagram').value,
                instagramUrl: document.getElementById('instagramUrl').value,
                eitaa: document.getElementById('eitaa').value,
                eitaaUrl: document.getElementById('eitaaUrl').value,
                bale: document.getElementById('bale').value,
                baleUrl: document.getElementById('baleUrl').value,
                rubika: document.getElementById('rubika').value,
                rubikaUrl: document.getElementById('rubikaUrl').value,
            };

            try {
                const res = await fetch('api.php?action=save_general', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ general })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('تنظیمات با موفقیت ذخیره شد.');
                } else {
                    showToast(result.error || 'خطا در ذخیره', true);
                }
            } catch (err) {
                showToast('خطا در برقراری ارتباط با سرور', true);
            }
        }

        // Render Laws List
        function renderLawsList(laws) {
            const container = document.getElementById('lawsListContainer');
            if (!container) return;

            if (!laws || laws.length === 0) {
                container.innerHTML = '<p style="color: var(--text-muted); text-align: center; padding: 2rem;">هیچ قانونی ثبت نشده است.</p>';
                return;
            }

            container.innerHTML = laws.map(law => `
                <div class="law-item">
                    <div class="law-info">
                        <span class="law-badge">قانون ${law.id}</span>
                        <span class="law-title">${escapeHtml(law.title)}</span>
                    </div>
                    <div class="law-actions">
                        <button onclick="editLaw(${law.id})" class="btn btn-outline" style="padding: 0.35rem 0.75rem;">
                            ✏️ ویرایش
                        </button>
                        <button onclick="deleteLaw(${law.id})" class="btn btn-danger" style="padding: 0.35rem 0.75rem;">
                            🗑️ حذف
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function escapeHtml(str) {
            return (str || '').replace(/[&<>"']/g, m => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            })[m]);
        }

        // Open Modal (Add)
        function openLawModal() {
            document.getElementById('modalLawId').value = '';
            document.getElementById('modalLawHeading').textContent = 'افزودن قانون جدید به کتابخانه';
            document.getElementById('modalLawTitle').value = '';
            document.getElementById('modalLawContent').value = '';
            document.getElementById('lawModal').style.display = 'flex';
        }

        // Open Modal (Edit)
        function editLaw(id) {
            const law = (currentSiteData.laws || []).find(l => (l.id == id));
            if (!law) return;

            document.getElementById('modalLawId').value = law.id;
            document.getElementById('modalLawHeading').textContent = 'ویرایش قانون شماره ' + law.id;
            document.getElementById('modalLawTitle').value = law.title;
            document.getElementById('modalLawContent').value = law.content;
            document.getElementById('lawModal').style.display = 'flex';
        }

        function closeLawModal() {
            document.getElementById('lawModal').style.display = 'none';
        }

        // Save Law (Add or Edit)
        async function saveLawItem() {
            const id = document.getElementById('modalLawId').value;
            const title = document.getElementById('modalLawTitle').value.trim();
            const content = document.getElementById('modalLawContent').value.trim();

            if (!title || !content) {
                showToast('لطفاً عنوان و متن قانون را وارد کنید.', true);
                return;
            }

            try {
                const res = await fetch('api.php?action=save_law', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({
                        law: {
                            id: id ? parseInt(id, 10) : undefined,
                            title,
                            content
                        }
                    })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('قانون با موفقیت ذخیره شد.');
                    closeLawModal();
                    currentSiteData.laws = result.laws;
                    renderLawsList(result.laws);
                } else {
                    showToast(result.error || 'خطا در ذخیره قانون', true);
                }
            } catch (err) {
                showToast('خطا در ذخیره اطلاعات', true);
            }
        }

        // Delete Law
        async function deleteLaw(id) {
            if (!confirm(`آیا از حذف قانون شماره ${id} مطمئن هستید؟ این عملیات قابل بازگشت نیست.`)) return;

            try {
                const res = await fetch('api.php?action=delete_law', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ id })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('قانون با موفقیت حذف گردید.');
                    currentSiteData.laws = result.laws;
                    renderLawsList(result.laws);
                } else {
                    showToast(result.error || 'خطا در حذف', true);
                }
            } catch (err) {
                showToast('خطا در حذف اطلاعات', true);
            }
        }

        // Change Password Handler
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const current_password = document.getElementById('currentPassword').value;
                const new_password = document.getElementById('newPassword').value;
                const confirm_password = document.getElementById('confirmPassword').value;

                if (new_password !== confirm_password) {
                    showToast('کلمه عبور جدید با تکرار آن یکسان نیست.', true);
                    return;
                }

                try {
                    const res = await fetch('api.php?action=change_password', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': currentCsrfToken
                        },
                        body: JSON.stringify({ current_password, new_password })
                    });
                    const result = await res.json();
                    if (result.success) {
                        showToast('کلمه عبور با موفقیت تغییر کرد.');
                        changePasswordForm.reset();
                    } else {
                        showToast(result.error || 'خطا در تغییر کلمه عبور', true);
                    }
                } catch (err) {
                    showToast('خطا در برقراری ارتباط با سرور', true);
                }
            });
        }

        <?php if ($is_auth): ?>
        // Init on load
        loadSiteData();
        <?php endif; ?>
    </script>
</body>
</html>

