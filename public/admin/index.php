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
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" href="/logo.png">
    <link rel="shortcut icon" type="image/png" href="/logo.png">
    <link rel="apple-touch-icon" href="/logo.png">

    <!-- Vazirmatn Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #020f1a;
            --bg-card: rgba(10, 30, 40, 0.85);
            --bg-card-subtle: rgba(4, 21, 33, 0.7);
            --bg-input: rgba(3, 24, 37, 0.9);
            --border-color: rgba(14, 116, 144, 0.35);
            --border-hover: rgba(125, 211, 252, 0.6);
            --cyan-primary: #0e7490;
            --cyan-light: #7dd3fc;
            --emerald-accent: #059669;
            --emerald-light: #34d399;
            --amber-accent: #f59e0b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Vazirmatn', system-ui, sans-serif;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
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
            padding: 1.5rem 1rem;
            width: 100%;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            border-radius: 6px;
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
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }

        /* ─── Dashboard Screen ─── */
        .admin-header {
            background: rgba(10, 30, 40, 0.95);
            border-bottom: 2px solid var(--cyan-primary);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
            width: 100%;
            gap: 0.75rem;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            font-size: 1.05rem;
            color: #ffffff;
            text-decoration: none;
            flex-shrink: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 4px;
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
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

        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.775rem;
        }

        .btn[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ─── Navigation Tabs ─── */
        .tabs-container {
            max-width: 1200px;
            margin: 1.25rem auto 0;
            padding: 0 1.5rem;
            display: flex;
            gap: 0.35rem;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-btn.active {
            color: var(--cyan-light);
            border-bottom-color: var(--cyan-light);
            font-weight: 700;
        }

        /* ─── Main Content Container ─── */
        .main-container {
            max-width: 1200px;
            margin: 1.25rem auto 3rem;
            padding: 0 1.5rem;
            width: 100%;
        }

        .panel-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 1.5rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            margin-bottom: 1.25rem;
            width: 100%;
        }

        .card-header {
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(14, 116, 144, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--cyan-light);
        }

        /* ─── Forms ─── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
            gap: 1.25rem;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1rem;
            width: 100%;
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
            max-width: 100%;
            padding: 0.65rem 0.85rem;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: #ffffff;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--cyan-light);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
            line-height: 1.8;
        }

        /* ─── Categorized Laws Section Cards ─── */
        .category-section-card {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 1.25rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            width: 100%;
        }

        .category-header {
            background: rgba(14, 116, 144, 0.15);
            border-bottom: 1px solid var(--border-color);
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .category-title-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .category-badge-count {
            background: rgba(14, 116, 144, 0.4);
            color: var(--cyan-light);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            border: 1px solid rgba(125, 211, 252, 0.3);
        }

        .category-actions {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .category-laws-list {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .category-empty-state {
            padding: 2rem 1rem;
            text-align: center;
            color: var(--text-muted);
            border: 1px dashed rgba(14, 116, 144, 0.3);
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .law-item {
            background: rgba(3, 24, 37, 0.85);
            border: 1px solid rgba(14, 116, 144, 0.25);
            padding: 0.85rem 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            transition: all 0.2s;
            width: 100%;
        }
        .law-item:hover {
            border-color: var(--cyan-light);
            background: rgba(14, 116, 144, 0.12);
        }

        .law-info {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            overflow: hidden;
        }

        .law-badge {
            font-size: 0.75rem;
            background: rgba(14, 116, 144, 0.3);
            color: var(--cyan-light);
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .law-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .law-actions {
            display: flex;
            gap: 0.4rem;
            flex-shrink: 0;
        }

        /* ─── Visual Charts for Micro Analytics ─── */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 150px), 1fr));
            gap: 0.85rem;
            margin-top: 1rem;
            width: 100%;
        }

        .stat-box {
            background: rgba(3, 24, 37, 0.7);
            border: 1px solid var(--border-color);
            padding: 1.15rem 0.75rem;
            border-radius: 6px;
            text-align: center;
            transition: transform 0.2s;
        }

        .chart-card {
            background: rgba(3, 24, 37, 0.75);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 1.5rem;
            margin-top: 1.25rem;
            width: 100%;
        }

        .chart-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--cyan-light);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-layout-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 1.75rem;
            align-items: center;
            width: 100%;
        }

        /* Horizontal Bar Chart */
        .bars-list {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            width: 100%;
        }

        .bar-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            width: 100%;
        }

        .bar-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-main);
            gap: 0.5rem;
        }

        .bar-label-group {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .bar-track {
            width: 100%;
            height: 9px;
            background: rgba(14, 116, 144, 0.15);
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .bar-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Donut SVG Chart */
        .donut-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
            border-right: 1px solid rgba(14, 116, 144, 0.2);
            padding-right: 1.5rem;
        }

        .donut-legend {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.6rem;
            margin-top: 1.25rem;
            width: 100%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.775rem;
            color: var(--text-muted);
            overflow: hidden;
        }

        .legend-color-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ─── Multi-Admin & Security Tab ─── */
        .security-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr));
            gap: 1.25rem;
            width: 100%;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 4px;
            border: 1px solid rgba(14, 116, 144, 0.2);
        }

        .admin-table {
            width: 100%;
            min-width: 440px;
            border-collapse: collapse;
        }

        .admin-table th, .admin-table td {
            padding: 0.75rem 0.85rem;
            text-align: right;
            border-bottom: 1px solid rgba(14, 116, 144, 0.2);
            font-size: 0.85rem;
        }

        .admin-table th {
            color: var(--cyan-light);
            font-weight: 600;
            background: rgba(14, 116, 144, 0.1);
        }

        /* ─── Modal ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 1.25rem;
        }

        .modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            width: 100%;
            max-width: 720px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 1.75rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
        }

        /* ─── Notification Toast ─── */
        .toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            max-width: calc(100vw - 3rem);
            padding: 0.75rem 1.25rem;
            background: var(--emerald-accent);
            color: #ffffff;
            border-radius: 4px;
            font-size: 0.85rem;
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

        /* ══════════════════════════════════════════════════════════════
           RESPONSIVE MEDIA QUERIES (Mobile & Tablet Hardening)
        ══════════════════════════════════════════════════════════════ */

        @media (max-width: 768px) {
            .admin-header {
                padding: 0.65rem 0.85rem;
            }
            .brand-logo {
                font-size: 0.925rem;
                gap: 0.4rem;
            }
            .brand-logo img {
                width: 24px !important;
                height: 24px !important;
            }
            .header-actions {
                gap: 0.35rem;
            }
            .header-actions .btn {
                padding: 0.4rem 0.6rem;
                font-size: 0.75rem;
            }
            .btn-text-long {
                display: none;
            }
            .tabs-container {
                padding: 0 0.75rem;
                margin-top: 0.75rem;
            }
            .tab-btn {
                padding: 0.65rem 0.75rem;
                font-size: 0.775rem;
            }
            .main-container {
                padding: 0 0.75rem;
                margin: 0.75rem auto 2rem;
            }
            .panel-card {
                padding: 1.15rem 0.85rem;
                margin-bottom: 1rem;
                border-radius: 6px;
            }
            .card-header {
                margin-bottom: 1rem;
                gap: 0.5rem;
            }
            .card-title {
                font-size: 0.95rem;
            }
            .form-grid {
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }
            .security-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            .analytics-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.6rem;
            }
            .stat-box {
                padding: 0.85rem 0.5rem;
            }
            .chart-card {
                padding: 1rem 0.85rem;
            }
            .chart-layout-grid {
                grid-template-columns: 1fr;
                gap: 1.75rem;
            }
            .donut-wrapper {
                border-right: none !important;
                border-top: 1px solid rgba(14, 116, 144, 0.2);
                padding-right: 0 !important;
                padding-top: 1.5rem;
            }
            .category-header {
                flex-direction: column;
                align-items: stretch;
                gap: 0.65rem;
                padding: 0.85rem 0.75rem;
            }
            .category-title-group {
                justify-content: space-between;
                width: 100%;
            }
            .category-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.35rem;
                width: 100%;
            }
            .category-actions .btn {
                flex: 1 1 auto;
                justify-content: center;
                font-size: 0.75rem;
                padding: 0.4rem 0.6rem;
            }
            .category-laws-list {
                padding: 0.75rem;
                gap: 0.6rem;
            }
            .law-item {
                flex-direction: column;
                align-items: stretch;
                gap: 0.6rem;
                padding: 0.75rem;
            }
            .law-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.35rem;
                width: 100%;
            }
            .law-title {
                white-space: normal;
                line-height: 1.55;
                font-size: 0.85rem;
                word-break: break-word;
            }
            .law-actions {
                display: flex;
                gap: 0.4rem;
                width: 100%;
                border-top: 1px solid rgba(14, 116, 144, 0.2);
                padding-top: 0.5rem;
                justify-content: flex-end;
            }
            .law-actions .btn {
                flex: 1;
                justify-content: center;
            }
            .modal-overlay {
                padding: 0.75rem;
            }
            .modal-box {
                padding: 1.25rem 1rem;
                max-height: 94vh;
            }
            .form-save-footer {
                text-align: stretch !important;
            }
            .form-save-footer .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .brand-logo span {
                display: none;
            }
            .header-actions .btn-text {
                display: none;
            }
            .header-actions .btn {
                padding: 0.45rem 0.65rem;
            }
            .donut-legend {
                grid-template-columns: 1fr;
                gap: 0.45rem;
            }
            .card-header {
                flex-direction: column;
                align-items: stretch;
            }
            .card-header > div:last-child {
                display: flex;
                flex-wrap: wrap;
                gap: 0.4rem;
                width: 100%;
            }
            .card-header > div:last-child .btn {
                flex: 1 1 auto;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div id="toast" class="toast">پیام سیستم</div>

    <?php if (!$is_auth): ?>
    <!-- ─── LOGIN VIEW ─── -->
    <div class="login-wrap">
        <div class="login-card">
            <img src="/logo.png" alt="لوگو دفتر وکالت کیان‌ارثی" style="width: 64px; height: 64px; object-fit: contain; margin: 0 auto 1rem; display: block; border-radius: 6px; box-shadow: 0 4px 15px rgba(14, 116, 144, 0.3);">
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
                سامانه مدیریت محتوای اختصاصی دفتر وکالت محمدحسن کیان‌ارثی
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- ─── DASHBOARD VIEW ─── -->
    <header class="admin-header">
        <a href="#" class="brand-logo">
            <img src="/logo.png" alt="لوگو دفتر وکالت" style="width: 30px; height: 30px; object-fit: contain; border-radius: 4px; border: 1px solid rgba(14, 116, 144, 0.4);">
            <span>مدیریت وب‌سایت کیان‌ارثی</span>
        </a>
        <div class="header-actions">
            <a href="api.php?action=download_backup" class="btn btn-outline" style="border-color: #059669; color: #34d399;" title="دانلود کل اطلاعات سایت در یک فایل">
                <span>📥</span>
                <span class="btn-text">بک‌آپ</span>
                <span class="btn-text-long"> اطلاعات</span>
            </a>
            <a href="../" target="_blank" class="btn btn-outline" title="مشاهده وب‌سایت در صفحه جدید">
                <span>👁️</span>
                <span class="btn-text">مشاهده سایت</span>
            </a>
            <button onclick="handleLogout()" class="btn btn-danger" title="خروج از پنل مدیریت">
                <span>🚪</span>
                <span class="btn-text">خروج</span>
            </button>
        </div>
    </header>

    <?php if (is_using_default_password()): ?>
    <div class="security-banner-wrap" style="max-width: 1200px; margin: 0.85rem auto 0; padding: 0 1.5rem;">
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 6px; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.6rem; color: #fca5a5; font-size: 0.825rem; line-height: 1.5;">
                <span style="font-size: 1.2rem; flex-shrink: 0;">⚠️</span>
                <span><strong>هشدار امنیتی:</strong> کلمه عبور فعلی، رمز پیش‌فرض اولیه است. لطفاً برای ارتقای امنیت وب‌سایت، هم‌اکنون از تب امنیت رمز خود را تغییر دهید.</span>
            </div>
            <button onclick="switchTab('security')" class="btn btn-danger btn-sm" style="flex-shrink: 0;">
                تغییر فوری رمز
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('general')">⚙️ اطلاعات عمومی و تماس</button>
        <button class="tab-btn" onclick="switchTab('laws')">📜 کتابخانه قوانین و دسته‌بندی‌ها</button>
        <button class="tab-btn" onclick="switchTab('analytics')">📊 آمار و نمودارهای تحلیلی</button>
        <button class="tab-btn" onclick="switchTab('security')">🔐 امنیت و مدیریت مدیران</button>
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

                <div class="form-save-footer" style="text-align: left; margin-top: 1.5rem;">
                    <button onclick="saveGeneralData()" class="btn btn-success" style="padding: 0.65rem 1.5rem;">
                        <span>💾</span>
                        <span>ذخیره کلیه تنظیمات</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB 2: LAWS & DYNAMIC CATEGORIES MANAGEMENT -->
        <div id="tab-laws" class="tab-content" style="display: none;">
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">کتابخانه قوانین و مقررات تخصصی آب</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                            هر دسته‌بندی دارای بخش اختصاصی است. می‌توانید دسته‌بندی جدید بسازید یا قوانین مربوط به هر بخش را مدیریت فرمایید.
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button onclick="openCategoryModal()" class="btn btn-outline" style="border-color: #38bdf8; color: #38bdf8;">
                            <span>📁</span>
                            <span>دسته‌بندی جدید</span>
                        </button>
                        <button onclick="openLawModal()" class="btn btn-primary">
                            <span>➕</span>
                            <span>افزودن قانون جدید</span>
                        </button>
                    </div>
                </div>

                <!-- Container where Category Blocks will be dynamically rendered -->
                <div id="lawsCategorizedContainer">
                    <p style="color: var(--text-muted); text-align: center; padding: 2rem;">در حال بارگذاری دسته‌بندی‌ها و قوانین...</p>
                </div>
            </div>
        </div>

        <!-- TAB 3: VISUAL MICRO ANALYTICS -->
        <div id="tab-analytics" class="tab-content" style="display: none;">
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">داشبورد آماری و نمودارهای مراجعین</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                            گزارش گرافیکی و عددی تعامل مراجعین با دکمه‌های تماس، پیام‌رسان‌ها و مسیریابی
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="loadAnalytics()" class="btn btn-outline">
                            <span>🔄</span>
                            <span>به‌روزرسانی</span>
                        </button>
                        <button onclick="resetAnalytics()" class="btn btn-danger">
                            <span>🗑️</span>
                            <span>صفر کردن آمار</span>
                        </button>
                    </div>
                </div>

                <!-- Numerical KPI Cards -->
                <div class="analytics-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">👁️</div>
                        <div id="statViews" style="font-size: 1.65rem; font-weight: 700; color: var(--cyan-light);">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">بازدید کل سایت</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">📞</div>
                        <div id="statPhone" style="font-size: 1.65rem; font-weight: 700; color: #34d399;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">تماس مستقیم تلفنی</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">💬</div>
                        <div id="statEitaa" style="font-size: 1.65rem; font-weight: 700; color: #f59e0b;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به ایتا</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">📱</div>
                        <div id="statInstagram" style="font-size: 1.65rem; font-weight: 700; color: #ec4899;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">صفحه اینستاگرام</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">💬</div>
                        <div id="statBale" style="font-size: 1.65rem; font-weight: 700; color: #10b981;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به بله</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">💬</div>
                        <div id="statRubika" style="font-size: 1.65rem; font-weight: 700; color: #6366f1;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به روبیکا</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="font-size: 1.4rem; margin-bottom: 0.4rem;">🗺️</div>
                        <div id="statMaps" style="font-size: 1.65rem; font-weight: 700; color: #38bdf8;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مسیریابی نقشه و بلد</div>
                    </div>
                </div>

                <!-- VISUAL CHARTS SECTION -->
                <div class="chart-card">
                    <h3 class="chart-title">
                        <span>📈</span>
                        <span>تحلیل نموداری تعاملات مراجعین و کانال‌های ارتباطی</span>
                    </h3>

                    <div class="chart-layout-grid">
                        <!-- Left/Primary: Horizontal Bar Chart -->
                        <div>
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                                مقایسه فراوانی کلیک‌ها روی کانال‌های ارتباطی و درصد سهم هر کانال:
                            </div>
                            <div id="barsChartContainer" class="bars-list">
                                <!-- Rendered dynamically -->
                            </div>
                        </div>

                        <!-- Right/Secondary: Donut SVG Distribution Chart -->
                        <div class="donut-wrapper" style="border-right: 1px solid rgba(14, 116, 144, 0.2); padding-right: 1.5rem;">
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; text-align: center;">
                                سهم توزیع ارتباطات مراجعین (درصد کل)
                            </div>
                            <div style="position: relative; width: 180px; height: 180px;">
                                <svg id="donutSvg" width="180" height="180" viewBox="0 0 100 100" style="transform: rotate(-90deg); border-radius: 50%;">
                                    <!-- Donut arcs dynamically inserted -->
                                </svg>
                                <div id="donutCenterText" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted);">کل تعاملات</span>
                                    <strong id="donutTotalCount" style="font-size: 1.2rem; color: var(--cyan-light);">۰</strong>
                                </div>
                            </div>
                            <div id="donutLegend" class="donut-legend">
                                <!-- Legend items dynamically inserted -->
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                    <span>آخرین ثبت رویداد: <strong id="statLastUpdated" style="color: var(--text-main);">-</strong></span>
                    <span>سیستم آمارگیر درون‌سازمانی با حجم و رم نزدیک به صفر</span>
                </div>
            </div>
        </div>

        <!-- TAB 4: SECURITY & MULTI-ADMIN MANAGEMENT -->
        <div id="tab-security" class="tab-content" style="display: none;">
            
            <div class="security-grid">
                
                <!-- Box 1: Change Current Password -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <div class="card-header">
                        <h2 class="card-title">🔐 تغییر کلمه عبور حساب جاری</h2>
                    </div>
                    
                    <form id="changePasswordForm">
                        <div class="form-group">
                            <label class="form-label">کلمه عبور فعلی:</label>
                            <input type="password" id="currentPassword" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">کلمه عبور جدید (حداقل ۶ کاراکتر):</label>
                            <input type="password" id="newPassword" class="form-control" required minlength="6" placeholder="کلمه عبور قوی">
                        </div>
                        <div class="form-group">
                            <label class="form-label">تکرار کلمه عبور جدید:</label>
                            <input type="password" id="confirmPassword" class="form-control" required minlength="6" placeholder="تکرار کلمه عبور">
                        </div>
                        <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center; margin-top: 1rem;">
                            به‌روزرسانی کلمه عبور
                        </button>
                    </form>
                </div>

                <!-- Box 2: Add New Admin -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <div class="card-header">
                        <h2 class="card-title">➕ افزودن مدیر جدید به سیستم</h2>
                    </div>
                    
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem; line-height: 1.6;">
                        مدیر جدید می‌تواند با نام کاربری و رمز اختصاصی خود وارد پنل مدیریت شود و تغییرات را ثبت کند.
                    </p>

                    <form id="addAdminForm">
                        <div class="form-group">
                            <label class="form-label">نام کاربری مدیر جدید:</label>
                            <input type="text" id="newAdminUsername" class="form-control" required minlength="3" placeholder="مثال: admin2 یا mojtaba">
                        </div>
                        <div class="form-group">
                            <label class="form-label">کلمه عبور مدیر جدید (حداقل ۶ کاراکتر):</label>
                            <input type="password" id="newAdminPassword" class="form-control" required minlength="6" placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                            <span>➕</span>
                            <span>ایجاد حساب مدیر جدید</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Box 3: Existing Admins List -->
            <div class="panel-card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">👥 لیست مدیران فعال سیستم</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                            توجه: طبق استاندارد امنیتی، همیشه باید حداقل ۱ مدیر در سیستم فعال باشد و امکان حذف آخرین مدیر وجود ندارد.
                        </p>
                    </div>
                    <button onclick="loadAdmins()" class="btn btn-outline btn-sm">
                        <span>🔄</span>
                        <span>به‌روزرسانی لیست</span>
                    </button>
                </div>

                <div id="adminsTableContainer">
                    <p style="color: var(--text-muted); text-align: center; padding: 1.5rem;">در حال دریافت لیست مدیران...</p>
                </div>
            </div>

        </div>

    </main>

    <!-- ─── CATEGORY ADD / EDIT MODAL ─── -->
    <div id="categoryModal" class="modal-overlay">
        <div class="modal-box" style="max-width: 480px;">
            <div class="card-header">
                <h3 id="categoryModalHeading" class="card-title">دسته‌بندی جدید قوانین</h3>
                <button onclick="closeCategoryModal()" style="background: none; border: none; color: var(--text-muted); font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            
            <input type="hidden" id="categoryModalId">
            
            <div class="form-group">
                <label class="form-label">عنوان دسته‌بندی موضوعی:</label>
                <input type="text" id="categoryModalLabel" class="form-control" required placeholder="مثال: دعاوی و جرایم مرتبط با آب">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeCategoryModal()" class="btn btn-outline">انصراف</button>
                <button type="button" onclick="saveCategoryItem()" class="btn btn-success">ذخیره دسته‌بندی</button>
            </div>
        </div>
    </div>

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
                <input type="text" id="modalLawTitle" class="form-control" required placeholder="مثال: قانون تعیین تکلیف چاه‌های آب فاقد پروانه">
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <label class="form-label" style="margin-bottom: 0;">دسته‌بندی موضوعی قانون در سایت:</label>
                    <button type="button" onclick="openCategoryModal()" style="background: none; border: none; color: var(--cyan-light); font-size: 0.775rem; cursor: pointer; text-decoration: underline;">
                        ➕ ایجاد دسته‌بندی جدید
                    </button>
                </div>
                <select id="modalLawCategory" class="form-control" style="background-color: var(--bg-input);">
                    <!-- Dynamically populated -->
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">متن کامل مواد و تبصره‌ها (پشتیبانی از چندخطی):</label>
                <textarea id="modalLawContent" class="form-control" style="min-height: 280px; font-size: 0.875rem;" required placeholder="ماده ۱ - ...&#10;تبصره ۱ - ..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeLawModal()" class="btn btn-outline">انصراف</button>
                <button type="button" onclick="saveLawItem()" class="btn btn-success">ذخیره قانون</button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        let currentSiteData = { general: {}, laws: [], categories: [] };
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

            if (tabId === 'analytics') {
                loadAnalytics();
            } else if (tabId === 'security') {
                loadAdmins();
            }
        }

        // Load Data on Startup
        async function loadSiteData() {
            try {
                const res = await fetch('api.php?action=get_data');
                const result = await res.json();
                if (result.csrf_token) currentCsrfToken = result.csrf_token;
                if (result.success && result.data) {
                    currentSiteData = result.data;
                    if (!currentSiteData.categories || currentSiteData.categories.length === 0) {
                        currentSiteData.categories = [
                            { id: 'wells', label: 'چاه‌ها و آب‌های زیرزمینی' },
                            { id: 'rivers', label: 'بستر، حریم و تأسیسات آبی' },
                            { id: 'lands', label: 'اراضی موقوفه، منابع طبیعی و سایر' }
                        ];
                    }
                    populateGeneralForm(currentSiteData.general || {});
                    renderCategorizedLaws();
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

        function escapeHtml(str) {
            return (str || '').replace(/[&<>"']/g, m => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            })[m]);
        }

        /* ─── DYNAMIC CATEGORIES & DISTINCT CATEGORY SECTIONS ─── */
        function renderCategorizedLaws() {
            const container = document.getElementById('lawsCategorizedContainer');
            if (!container) return;

            const categories = currentSiteData.categories || [];
            const laws = currentSiteData.laws || [];

            if (categories.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <p>هیچ دسته‌بندی موضوعی تعریف نشده است.</p>
                        <button onclick="openCategoryModal()" class="btn btn-primary" style="margin-top: 1rem;">
                            ➕ ایجاد اولین دسته‌بندی
                        </button>
                    </div>
                `;
                return;
            }

            // Sync category dropdown in law modal
            populateLawCategoryDropdown();

            let html = '';
            categories.forEach(cat => {
                const catLaws = laws.filter(l => (l.category || categories[0].id) === cat.id);
                const countFa = catLaws.length.toLocaleString('fa-IR');

                html += `
                <div class="category-section-card" data-cat-id="${cat.id}">
                    <div class="category-header">
                        <div class="category-title-group">
                            <span style="font-size: 1.25rem;">📁</span>
                            <strong style="font-size: 1rem; color: #ffffff;">${escapeHtml(cat.label)}</strong>
                            <span class="category-badge-count">${countFa} قانون</span>
                        </div>
                        <div class="category-actions">
                            <button onclick="openLawModal('${cat.id}')" class="btn btn-success btn-sm" title="افزودن قانون مستقیماً به این بخش">
                                <span>➕</span>
                                <span>افزودن قانون به این بخش</span>
                            </button>
                            <button onclick="editCategory('${cat.id}', '${escapeHtml(cat.label)}')" class="btn btn-outline btn-sm" title="ویرایش عنوان دسته‌بندی">
                                <span>✏️</span>
                                <span>ویرایش نام</span>
                            </button>
                            <button onclick="deleteCategory('${cat.id}', '${escapeHtml(cat.label)}')" class="btn btn-danger btn-sm" title="حذف این دسته‌بندی">
                                <span>🗑️</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="category-laws-list">
                `;

                if (catLaws.length === 0) {
                    html += `
                        <div class="category-empty-state">
                            هنوز قانونی در بخش «${escapeHtml(cat.label)}» ثبت نشده است. 
                            <a href="javascript:void(0)" onclick="openLawModal('${cat.id}')" style="color: var(--cyan-light); text-decoration: underline; margin-right: 0.5rem;">
                                اولین قانون را به این بخش اضافه کنید
                            </a>
                        </div>
                    `;
                } else {
                    catLaws.forEach(law => {
                        html += `
                        <div class="law-item">
                            <div class="law-info">
                                <span class="law-badge">قانون #${law.id}</span>
                                <span class="law-title" title="${escapeHtml(law.title)}">${escapeHtml(law.title)}</span>
                            </div>
                            <div class="law-actions">
                                <button onclick="editLaw(${law.id})" class="btn btn-outline btn-sm">
                                    ✏️ ویرایش
                                </button>
                                <button onclick="deleteLaw(${law.id})" class="btn btn-danger btn-sm">
                                    🗑️ حذف
                                </button>
                            </div>
                        </div>
                        `;
                    });
                }

                html += `
                    </div>
                </div>
                `;
            });

            container.innerHTML = html;
        }

        function populateLawCategoryDropdown() {
            const select = document.getElementById('modalLawCategory');
            if (!select) return;
            const categories = currentSiteData.categories || [];
            select.innerHTML = categories.map(c => 
                `<option value="${escapeHtml(c.id)}">${escapeHtml(c.label)}</option>`
            ).join('');
        }

        // Category Modal Handlers
        function openCategoryModal(id = '', label = '') {
            document.getElementById('categoryModalId').value = id;
            document.getElementById('categoryModalLabel').value = label;
            document.getElementById('categoryModalHeading').textContent = id ? 'ویرایش عنوان دسته‌بندی' : 'دسته‌بندی جدید قوانین';
            document.getElementById('categoryModal').style.display = 'flex';
            setTimeout(() => document.getElementById('categoryModalLabel').focus(), 50);
        }

        function editCategory(id, label) {
            openCategoryModal(id, label);
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').style.display = 'none';
        }

        async function saveCategoryItem() {
            const id = document.getElementById('categoryModalId').value.trim();
            const label = document.getElementById('categoryModalLabel').value.trim();

            if (!label) {
                showToast('لطفاً عنوان دسته‌بندی را وارد کنید.', true);
                return;
            }

            try {
                const res = await fetch('api.php?action=save_category', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ category: { id, label } })
                });
                const result = await res.json();
                if (result.success) {
                    showToast(result.message || 'دسته‌بندی با موفقیت ذخیره شد.');
                    closeCategoryModal();
                    currentSiteData.categories = result.categories;
                    renderCategorizedLaws();
                    populateLawCategoryDropdown();
                    if (!id && result.categories && result.categories.length > 0) {
                        const newCat = result.categories[result.categories.length - 1];
                        const sel = document.getElementById('modalLawCategory');
                        if (sel) sel.value = newCat.id;
                    }
                } else {
                    showToast(result.error || 'خطا در ذخیره دسته‌بندی', true);
                }
            } catch (err) {
                showToast('خطا در ذخیره اطلاعات', true);
            }
        }

        async function deleteCategory(id, label) {
            if ((currentSiteData.categories || []).length <= 1) {
                showToast('حداقل یک دسته‌بندی باید در سایت وجود داشته باشد.', true);
                return;
            }

            if (!confirm(`آیا از حذف دسته‌بندی «${label}» مطمئن هستید؟ در صورت وجود قوانین در این بخش، آنها به صورت خودکار به دسته‌بندی دیگر منتقل خواهند شد.`)) {
                return;
            }

            try {
                const res = await fetch('api.php?action=delete_category', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ id })
                });
                const result = await res.json();
                if (result.success) {
                    showToast(result.message || 'دسته‌بندی با موفقیت حذف گردید.');
                    currentSiteData.categories = result.categories;
                    if (result.laws) currentSiteData.laws = result.laws;
                    renderCategorizedLaws();
                } else {
                    showToast(result.error || 'خطا در حذف دسته‌بندی', true);
                }
            } catch (err) {
                showToast('خطا در حذف اطلاعات', true);
            }
        }

        // Open Law Modal (Add)
        function openLawModal(preselectedCatId = '') {
            document.getElementById('modalLawId').value = '';
            document.getElementById('modalLawHeading').textContent = 'افزودن قانون جدید به کتابخانه';
            document.getElementById('modalLawTitle').value = '';
            document.getElementById('modalLawContent').value = '';
            
            populateLawCategoryDropdown();
            if (preselectedCatId) {
                document.getElementById('modalLawCategory').value = preselectedCatId;
            }
            document.getElementById('lawModal').style.display = 'flex';
        }

        // Open Law Modal (Edit)
        function editLaw(id) {
            const law = (currentSiteData.laws || []).find(l => (l.id == id));
            if (!law) return;

            document.getElementById('modalLawId').value = law.id;
            document.getElementById('modalLawHeading').textContent = 'ویرایش قانون شماره ' + law.id;
            document.getElementById('modalLawTitle').value = law.title;
            populateLawCategoryDropdown();
            document.getElementById('modalLawCategory').value = law.category || (currentSiteData.categories[0] ? currentSiteData.categories[0].id : 'wells');
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
            const category = document.getElementById('modalLawCategory').value;
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
                            category,
                            content
                        }
                    })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('قانون با موفقیت ذخیره شد.');
                    closeLawModal();
                    currentSiteData.laws = result.laws;
                    renderCategorizedLaws();
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
                    renderCategorizedLaws();
                } else {
                    showToast(result.error || 'خطا در حذف', true);
                }
            } catch (err) {
                showToast('خطا در حذف اطلاعات', true);
            }
        }

        /* ─── VISUAL ANALYTICS & CHARTS ─── */
        async function loadAnalytics() {
            try {
                const res = await fetch('api.php?action=get_analytics');
                const result = await res.json();
                if (result.success && result.analytics) {
                    const a = result.analytics;
                    const formatNum = (n) => (n || 0).toLocaleString('fa-IR');
                    document.getElementById('statViews').textContent = formatNum(a.views);
                    document.getElementById('statPhone').textContent = formatNum(a.phone);
                    document.getElementById('statEitaa').textContent = formatNum(a.eitaa);
                    document.getElementById('statInstagram').textContent = formatNum(a.instagram);
                    document.getElementById('statBale').textContent = formatNum(a.bale);
                    document.getElementById('statRubika').textContent = formatNum(a.rubika);
                    document.getElementById('statMaps').textContent = formatNum(a.maps);
                    document.getElementById('statLastUpdated').textContent = a.last_updated || '-';

                    renderVisualCharts(a);
                }
            } catch (err) {
                console.error('Error loading analytics', err);
            }
        }

        function renderVisualCharts(a) {
            const channels = [
                { key: 'phone', label: 'تماس مستقیم تلفنی', icon: '📞', color: '#34d399', count: a.phone || 0 },
                { key: 'eitaa', label: 'پیام‌رسان ایتا', icon: '💬', color: '#f59e0b', count: a.eitaa || 0 },
                { key: 'instagram', label: 'صفحه اینستاگرام', icon: '📱', color: '#ec4899', count: a.instagram || 0 },
                { key: 'bale', label: 'پیام‌رسان بله', icon: '💬', color: '#10b981', count: a.bale || 0 },
                { key: 'rubika', label: 'پیام‌رسان روبیکا', icon: '💬', color: '#6366f1', count: a.rubika || 0 },
                { key: 'maps', label: 'مسیریابی نقشه و بلد', icon: '🗺️', color: '#38bdf8', count: a.maps || 0 }
            ];

            const totalInteractions = channels.reduce((sum, ch) => sum + ch.count, 0);
            const maxVal = Math.max(...channels.map(c => c.count), 1);

            // 1. Render Horizontal Bar Chart
            const barsContainer = document.getElementById('barsChartContainer');
            if (barsContainer) {
                barsContainer.innerHTML = channels.map(ch => {
                    const pctOfMax = ((ch.count / maxVal) * 100).toFixed(1);
                    const pctOfTotal = totalInteractions > 0 ? ((ch.count / totalInteractions) * 100).toFixed(1) : 0;
                    return `
                    <div class="bar-item">
                        <div class="bar-meta">
                            <span class="bar-label-group">
                                <span>${ch.icon}</span>
                                <strong>${ch.label}</strong>
                            </span>
                            <span>
                                <strong style="color: ${ch.color}; margin-left: 0.4rem;">${ch.count.toLocaleString('fa-IR')}</strong>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">(${Number(pctOfTotal).toLocaleString('fa-IR')}٪)</span>
                            </span>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: ${ch.count > 0 ? Math.max(pctOfMax, 4) : 0}%; background-color: ${ch.color};"></div>
                        </div>
                    </div>
                    `;
                }).join('');
            }

            // 2. Render SVG Donut Chart
            renderSvgDonut(channels, totalInteractions);
        }

        function renderSvgDonut(channels, total) {
            const svg = document.getElementById('donutSvg');
            const legend = document.getElementById('donutLegend');
            const totalCountEl = document.getElementById('donutTotalCount');
            if (!svg || !legend) return;

            totalCountEl.textContent = total.toLocaleString('fa-IR');

            if (total === 0) {
                // Empty circle state
                svg.innerHTML = `
                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="rgba(14, 116, 144, 0.2)" stroke-width="14" />
                `;
                legend.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); font-size: 0.775rem;">
                        هنوز رویداد و کلیکی ثبت نشده است
                    </div>
                `;
                return;
            }

            const circumference = 2 * Math.PI * 38; // r = 38 => ~238.76
            let currentOffset = 0;
            let svgSlices = '';
            let legendItems = '';

            channels.forEach(ch => {
                if (ch.count <= 0) return;
                const ratio = ch.count / total;
                const strokeDash = ratio * circumference;
                const strokeSpace = circumference - strokeDash;
                const pct = (ratio * 100).toFixed(1);

                svgSlices += `
                    <circle cx="50" cy="50" r="38" fill="transparent"
                        stroke="${ch.color}"
                        stroke-width="14"
                        stroke-dasharray="${strokeDash} ${strokeSpace}"
                        stroke-dashoffset="${-currentOffset}"
                        style="transition: all 0.6s ease;"
                    >
                        <title>${ch.label}: ${ch.count} (${pct}%)</title>
                    </circle>
                `;
                currentOffset += strokeDash;

                legendItems += `
                    <div class="legend-item">
                        <span class="legend-color-dot" style="background-color: ${ch.color};"></span>
                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${ch.label}:</span>
                        <strong style="color: var(--text-main); margin-right: auto;">${Number(pct).toLocaleString('fa-IR')}٪</strong>
                    </div>
                `;
            });

            svg.innerHTML = svgSlices;
            legend.innerHTML = legendItems;
        }

        async function resetAnalytics() {
            if (!confirm('آیا از ریست و صفر کردن تمام آمارهای بازدید و کلیک مطمئن هستید؟')) return;
            try {
                const res = await fetch('api.php?action=reset_analytics', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    }
                });
                const result = await res.json();
                if (result.success) {
                    showToast('آمارها با موفقیت صفر شدند.');
                    loadAnalytics();
                } else {
                    showToast(result.error || 'خطا در بازنشانی آمار', true);
                }
            } catch (err) {
                showToast('خطا در برقراری ارتباط با سرور', true);
            }
        }

        /* ─── MULTI-ADMIN MANAGEMENT & PASSWORD CHANGE ─── */
        async function loadAdmins() {
            const container = document.getElementById('adminsTableContainer');
            if (!container) return;

            try {
                const res = await fetch('api.php?action=get_admins');
                const result = await res.json();
                if (result.success && result.admins) {
                    const admins = result.admins;
                    const canDelete = admins.length > 1;

                    let html = `
                    <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>نام کاربری</th>
                                <th>تاریخ ایجاد</th>
                                <th>وضعیت</th>
                                <th style="text-align: left;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;

                    admins.forEach(adm => {
                        const isCurrent = adm.is_current;
                        html += `
                        <tr>
                            <td>
                                <strong style="color: #ffffff; font-size: 0.95rem;">${escapeHtml(adm.username)}</strong>
                                ${isCurrent ? '<span style="background: rgba(5,150,105,0.25); color: #34d399; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 3px; margin-right: 0.5rem; border: 1px solid rgba(5,150,105,0.4);">شما (لاگین جاری)</span>' : ''}
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.8rem;">
                                ${escapeHtml(adm.created_at)}
                            </td>
                            <td>
                                <span style="color: #34d399; font-size: 0.8rem;">● فعال</span>
                            </td>
                            <td style="text-align: left;">
                                <button onclick="deleteAdmin('${adm.id}', '${escapeHtml(adm.username)}')" 
                                    class="btn btn-danger btn-sm" 
                                    ${!canDelete ? 'disabled title="حداقل ۱ مدیر باید در سیستم باشد و امکان حذف وجود ندارد"' : ''}>
                                    🗑️ حذف مدیر
                                </button>
                            </td>
                        </tr>
                        `;
                    });

                    html += `
                        </tbody>
                    </table>
                    </div>
                    `;

                    if (!canDelete) {
                        html += `
                        <div style="margin-top: 0.75rem; padding: 0.65rem 1rem; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 4px; font-size: 0.775rem; color: #fbbf24;">
                            ⚠️ فقط ۱ مدیر در سیستم ثبت شده است. دکمه حذف جهت حفظ امنیت و جلوگیری از قفل شدن پنل، غیرفعال می‌باشد.
                        </div>
                        `;
                    }

                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p style="color: #ef4444; text-align: center; padding: 1rem;">خطا در دریافت لیست مدیران.</p>';
                }
            } catch (err) {
                container.innerHTML = '<p style="color: #ef4444; text-align: center; padding: 1rem;">خطا در برقراری ارتباط با سرور.</p>';
            }
        }

        // Add New Admin
        const addAdminForm = document.getElementById('addAdminForm');
        if (addAdminForm) {
            addAdminForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const username = document.getElementById('newAdminUsername').value.trim();
                const password = document.getElementById('newAdminPassword').value;

                if (username.length < 3) {
                    showToast('نام کاربری باید حداقل ۳ کاراکتر باشد.', true);
                    return;
                }
                if (password.length < 6) {
                    showToast('کلمه عبور باید حداقل ۶ کاراکتر باشد.', true);
                    return;
                }

                try {
                    const res = await fetch('api.php?action=add_admin', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': currentCsrfToken
                        },
                        body: JSON.stringify({ username, password })
                    });
                    const result = await res.json();
                    if (result.success) {
                        showToast(result.message || 'مدیر جدید با موفقیت اضافه شد.');
                        addAdminForm.reset();
                        loadAdmins();
                    } else {
                        showToast(result.error || 'خطا در ثبت مدیر جدید', true);
                    }
                } catch (err) {
                    showToast('خطا در برقراری ارتباط با سرور', true);
                }
            });
        }

        // Delete Admin
        async function deleteAdmin(id, username) {
            if (!confirm(`آیا از حذف دسترسی مدیر «${username}» اطمینان دارید؟`)) {
                return;
            }

            try {
                const res = await fetch('api.php?action=delete_admin', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ id })
                });
                const result = await res.json();
                if (result.success) {
                    showToast(result.message || 'مدیر با موفقیت حذف شد.');
                    if (result.logged_out) {
                        alert('شما حساب کاربری جاری خود را حذف کردید و از سیستم خارج می‌شوید.');
                        window.location.reload();
                        return;
                    }
                    loadAdmins();
                } else {
                    showToast(result.error || 'خطا در حذف مدیر', true);
                }
            } catch (err) {
                showToast('خطا در برقراری ارتباط با سرور', true);
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
