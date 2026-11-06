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
            --bg-deep: #020b14;
            --bg-card: rgba(7, 24, 38, 0.88);
            --bg-card-subtle: rgba(4, 18, 29, 0.78);
            --bg-input: rgba(2, 17, 27, 0.9);
            --border-color: rgba(14, 116, 144, 0.32);
            --border-hover: rgba(56, 189, 248, 0.65);
            --cyan-primary: #0e7490;
            --cyan-hover: #0891b2;
            --cyan-glow: rgba(14, 116, 144, 0.4);
            --cyan-light: #7dd3fc;
            --cyan-accent: #38bdf8;
            --emerald-accent: #059669;
            --emerald-hover: #10b981;
            --emerald-light: #34d399;
            --amber-accent: #f59e0b;
            --rose-accent: #e11d48;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 22px;
            --shadow-card: 0 10px 30px -5px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(14, 116, 144, 0.22);
            --shadow-hover: 0 16px 40px -5px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(56, 189, 248, 0.45);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
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
                radial-gradient(ellipse at 15% 20%, rgba(14, 116, 144, 0.12) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 65%, rgba(6, 95, 70, 0.1) 0%, transparent 60%),
                radial-gradient(ellipse at 50% 90%, rgba(2, 132, 199, 0.08) 0%, transparent 50%);
            background-attachment: fixed;
            line-height: 1.6;
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
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            padding: 2.75rem 2.25rem;
            width: 100%;
            max-width: 430px;
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 50px rgba(0,0,0,0.6), 0 0 30px rgba(14, 116, 144, 0.2);
            text-align: center;
        }

        .login-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            color: #ffffff;
        }

        .login-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }

        /* ─── Dashboard Screen Header ─── */
        .admin-header {
            background: rgba(5, 20, 32, 0.92);
            border-bottom: 1px solid rgba(14, 116, 144, 0.35);
            padding: 0.75rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            width: 100%;
            gap: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-logo-img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(56, 189, 248, 0.4);
            background: rgba(3, 24, 37, 0.8);
            padding: 2px;
            box-shadow: 0 2px 8px rgba(14, 116, 144, 0.3);
        }

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.01em;
        }

        .brand-subtitle {
            font-size: 0.725rem;
            color: var(--cyan-light);
            font-weight: 500;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-wrap: wrap;
        }

        .header-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.75rem;
            background: rgba(5, 150, 105, 0.15);
            border: 1px solid rgba(52, 211, 153, 0.35);
            border-radius: 999px;
            font-size: 0.75rem;
            color: var(--emerald-light);
            font-weight: 600;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--emerald-light);
            box-shadow: 0 0 8px var(--emerald-light);
            animation: pulseStatus 2s infinite ease-in-out;
        }

        @keyframes pulseStatus {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(0.85); }
        }

        .admin-user-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            background: rgba(14, 116, 144, 0.18);
            border: 1px solid rgba(14, 116, 144, 0.4);
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        .admin-user-chip svg {
            color: var(--cyan-accent);
        }

        /* ─── Buttons Design System ─── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.55rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
            user-select: none;
        }

        .btn:hover:not([disabled]) {
            transform: translateY(-1px);
        }

        .btn:active:not([disabled]) {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--cyan-primary) 0%, #0284c7 100%);
            color: #ffffff;
            border-color: rgba(56, 189, 248, 0.35);
            box-shadow: 0 3px 12px rgba(14, 116, 144, 0.35);
        }
        .btn-primary:hover:not([disabled]) {
            background: linear-gradient(135deg, #0891b2 0%, #0369a1 100%);
            box-shadow: 0 4px 16px rgba(56, 189, 248, 0.45);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--emerald-accent) 0%, #047857 100%);
            color: #ffffff;
            border-color: rgba(52, 211, 153, 0.35);
            box-shadow: 0 3px 12px rgba(5, 150, 105, 0.3);
        }
        .btn-success:hover:not([disabled]) {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 16px rgba(52, 211, 153, 0.4);
        }

        .btn-outline {
            background: rgba(14, 116, 144, 0.1);
            border: 1px solid var(--border-color);
            color: var(--cyan-light);
        }
        .btn-outline:hover:not([disabled]) {
            border-color: var(--cyan-accent);
            background: rgba(14, 116, 144, 0.25);
            color: #ffffff;
            box-shadow: 0 3px 12px rgba(14, 116, 144, 0.25);
        }

        .btn-danger {
            background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
            color: #ffffff;
            border-color: rgba(248, 113, 113, 0.3);
            box-shadow: 0 3px 12px rgba(153, 27, 27, 0.3);
        }
        .btn-danger:hover:not([disabled]) {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
        }
        .btn-secondary:hover:not([disabled]) {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        .btn-sm {
            padding: 0.38rem 0.75rem;
            font-size: 0.775rem;
            border-radius: 6px;
        }

        .btn[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
            transform: none !important;
            box-shadow: none !important;
        }

        .admin-icon {
            display: inline-block;
            width: 1.05rem;
            height: 1.05rem;
            vertical-align: middle;
            stroke-width: 2;
            stroke: currentColor;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }
        .admin-icon-sm { width: 0.9rem; height: 0.9rem; }
        .admin-icon-lg { width: 1.35rem; height: 1.35rem; }

        /* ─── Segmented Navigation Tabs Bar ─── */
        .tabs-container {
            max-width: 1200px;
            margin: 1.25rem auto 0;
            padding: 6px;
            background: rgba(4, 20, 32, 0.78);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(14, 116, 144, 0.35);
            border-radius: var(--radius-xl);
            display: flex;
            gap: 0.4rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        }
        .tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            background: transparent;
            border: 1px solid transparent;
            border-radius: var(--radius-md);
            padding: 0.65rem 1.15rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .tab-btn:hover:not(.active) {
            background: rgba(14, 116, 144, 0.15);
            color: #f1f5f9;
            border-color: rgba(14, 116, 144, 0.3);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #0e7490 0%, #0284c7 100%);
            color: #ffffff;
            border-color: rgba(56, 189, 248, 0.4);
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(2, 132, 199, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        /* ─── Main Content Container ─── */
        .main-container {
            max-width: 1200px;
            margin: 1.25rem auto 5rem;
            padding: 0 1.5rem;
            width: 100%;
        }

        .panel-card {
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.65rem;
            box-shadow: var(--shadow-card);
            margin-bottom: 1.5rem;
            width: 100%;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .panel-card:hover {
            border-color: rgba(14, 116, 144, 0.45);
        }

        .card-header {
            margin-bottom: 1.35rem;
            padding-bottom: 0.95rem;
            border-bottom: 1px solid rgba(14, 116, 144, 0.22);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.85rem;
        }

        .card-header-main {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .card-icon-badge {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: rgba(14, 116, 144, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--cyan-accent);
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(14, 116, 144, 0.2);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.3;
        }

        .card-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            line-height: 1.5;
        }

        /* ─── Forms & Input Fields ─── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: 1.25rem;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.15rem;
            width: 100%;
        }

        .form-label {
            display: block;
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--cyan-light);
            margin-bottom: 0.45rem;
        }

        .input-wrap {
            position: relative;
            width: 100%;
        }

        .input-wrap .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cyan-accent);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.85;
        }

        .input-wrap.textarea-wrap .input-icon {
            top: 16px;
            transform: none;
        }

        .form-control {
            width: 100%;
            max-width: 100%;
            padding: 0.7rem 0.95rem;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: #ffffff;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
            line-height: 1.6;
        }

        .form-control.has-icon {
            padding-right: 2.6rem;
        }

        .form-control:focus {
            border-color: var(--cyan-accent);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
            background: rgba(3, 26, 42, 0.95);
        }

        .form-control::placeholder {
            color: var(--text-dim);
            font-size: 0.825rem;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
            line-height: 1.8;
        }

        /* ─── Social Media Channel Cards ─── */
        .social-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
            gap: 1.25rem;
            width: 100%;
        }

        .social-channel-box {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        }

        .social-channel-box:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }

        .social-channel-box.instagram-box:hover { border-color: rgba(225, 48, 108, 0.7); }
        .social-channel-box.eitaa-box:hover { border-color: rgba(230, 126, 34, 0.7); }
        .social-channel-box.bale-box:hover { border-color: rgba(16, 185, 129, 0.7); }
        .social-channel-box.rubika-box:hover { border-color: rgba(142, 68, 173, 0.7); }

        .social-channel-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.15rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .social-icon-box {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        /* ─── Categorized Laws Section Cards ─── */
        .category-section-card {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            margin-bottom: 1.25rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            width: 100%;
            transition: all 0.25s ease;
        }

        .category-section-card:hover {
            border-color: rgba(14, 116, 144, 0.5);
        }

        .category-header {
            background: rgba(14, 116, 144, 0.15);
            border-bottom: 1px solid var(--border-color);
            padding: 0.95rem 1.35rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .category-title-group {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .category-badge-count {
            background: rgba(14, 116, 144, 0.35);
            color: var(--cyan-light);
            font-size: 0.75rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, 0.3);
            font-weight: 600;
        }

        .category-actions {
            display: flex;
            gap: 0.45rem;
            align-items: center;
        }

        .category-laws-list {
            padding: 0.6rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .category-empty-state {
            padding: 1.5rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .law-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(3, 24, 37, 0.6);
            border: 1px solid rgba(14, 116, 144, 0.2);
            border-radius: var(--radius-sm);
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            gap: 0.75rem;
        }

        .law-item:hover {
            background: rgba(14, 116, 144, 0.2);
            border-color: rgba(56, 189, 248, 0.4);
            transform: translateX(-2px);
        }

        .law-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            overflow: hidden;
        }

        .law-badge {
            font-size: 0.725rem;
            font-weight: 700;
            color: var(--cyan-light);
            background: rgba(14, 116, 144, 0.3);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            white-space: nowrap;
        }

        .law-title {
            font-size: 0.875rem;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .law-actions {
            display: flex;
            gap: 0.35rem;
            flex-shrink: 0;
        }

        /* ─── Analytics Dashboard KPI Cards ─── */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-box {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            padding: 1.25rem 1rem;
            border-radius: var(--radius-md);
            text-align: center;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--stat-accent, var(--cyan-accent));
            opacity: 0.7;
        }

        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            border-color: var(--border-hover);
        }

        .chart-card {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .chart-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-layout-grid {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 2rem;
            align-items: center;
        }

        @media (max-width: 860px) {
            .chart-layout-grid {
                grid-template-columns: 1fr;
            }
            .donut-wrapper {
                border-right: none !important;
                border-top: 1px solid rgba(14, 116, 144, 0.2);
                padding-right: 0 !important;
                padding-top: 1.5rem;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        }

        .bars-list {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .bar-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .bar-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .bar-label-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #e2e8f0;
        }

        .bar-track {
            background: rgba(3, 24, 37, 0.9);
            height: 10px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid rgba(14, 116, 144, 0.2);
        }

        .bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .donut-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .donut-legend {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            width: 100%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.775rem;
            color: var(--text-muted);
        }

        .legend-color-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 0.4rem;
        }

        /* ─── Security Tab ─── */
        .security-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(14, 116, 144, 0.25);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: right;
        }

        .admin-table th {
            background: rgba(14, 116, 144, 0.2);
            color: var(--cyan-light);
            padding: 0.85rem 1rem;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(14, 116, 144, 0.15);
            color: #ffffff;
        }

        .admin-table tr:hover td {
            background: rgba(14, 116, 144, 0.08);
        }

        /* ─── Modals ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-box {
            background: var(--bg-card);
            border: 1px solid rgba(56, 189, 248, 0.4);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            width: 100%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 30px rgba(14, 116, 144, 0.3);
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* ─── Toast Notifications ─── */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            background: rgba(5, 20, 32, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--emerald-accent);
            color: #ffffff;
            padding: 0.85rem 1.35rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 500;
            z-index: 999;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 20px rgba(5, 150, 105, 0.3);
            display: none;
            direction: rtl;
        }

        .toast.show {
            display: block;
            animation: toastIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast.error {
            border-color: #ef4444;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 20px rgba(239, 68, 68, 0.3);
        }

        @keyframes toastIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ─── Sticky Save Action Bar ─── */
        .sticky-save-bar {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 85;
            background: rgba(4, 20, 32, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(56, 189, 248, 0.45);
            border-radius: var(--radius-xl);
            padding: 0.55rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.65), 0 0 25px rgba(14, 116, 144, 0.35);
            transition: all 0.3s ease;
            max-width: 92vw;
        }

        .sticky-save-info {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.825rem;
            color: var(--cyan-light);
        }

        .kbd-badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            font-size: 0.725rem;
            font-family: monospace;
            color: #ffffff;
            background: rgba(14, 116, 144, 0.45);
            border: 1px solid rgba(56, 189, 248, 0.35);
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.4);
        }

        /* ─── Images & SEO Tab ─── */
        .seo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
            gap: 1.5rem;
            width: 100%;
        }

        .image-card {
            background: var(--bg-card-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            transition: all 0.25s ease;
        }

        .image-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 6px 25px rgba(0,0,0,0.35);
        }

        .image-card-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
        }

        .image-preview-box {
            position: relative;
            background: rgba(2, 14, 23, 0.9);
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-sm);
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0.5rem;
        }

        .image-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }

        .image-preview-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(14, 116, 144, 0.85);
            color: #ffffff;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .image-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .file-upload-input {
            display: none;
        }

        .preview-columns-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 900px) {
            .preview-columns-grid {
                grid-template-columns: 1fr;
            }
        }

        .google-serp-preview {
            background: #202124;
            border: 1px solid #3c4043;
            border-radius: var(--radius-md);
            padding: 1.25rem;
            direction: rtl;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }

        .serp-url-row {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 0.5rem;
        }

        .serp-favicon-img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: contain;
            background: #303134;
            padding: 2px;
        }

        .serp-site-info {
            display: flex;
            flex-direction: column;
        }

        .serp-site-name {
            font-size: 0.8rem;
            color: #dadce0;
        }

        .serp-site-url {
            font-size: 0.75rem;
            color: #9aa0a6;
            direction: ltr;
            text-align: right;
        }

        .serp-title {
            color: #8ab4f8;
            font-size: 1.15rem;
            font-weight: 400;
            line-height: 1.35;
            margin-bottom: 0.4rem;
            cursor: pointer;
        }

        .serp-title:hover {
            text-decoration: underline;
        }

        .serp-description {
            color: #bdc1c6;
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .messenger-preview-container {
            background: #17212b;
            border: 1px solid rgba(14, 116, 144, 0.35);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }

        .messenger-chat-bubble {
            background: #242f3d;
            border-radius: var(--radius-md);
            padding: 0.85rem;
            max-width: 440px;
            margin: 0 auto;
        }

        .messenger-link-header {
            display: block;
            color: #6ab2f2;
            font-size: 0.8rem;
            direction: ltr;
            text-align: right;
            margin-bottom: 0.5rem;
        }

        .messenger-rich-card {
            border-right: 3px solid #6ab2f2;
            padding-right: 0.75rem;
        }

        .messenger-site-name {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6ab2f2;
            margin-bottom: 0.25rem;
        }

        .messenger-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.35rem;
            line-height: 1.4;
        }

        .messenger-desc {
            font-size: 0.8rem;
            color: #9bb2c9;
            line-height: 1.5;
            margin-bottom: 0.65rem;
        }

        .messenger-image-wrapper {
            width: 100%;
            border-radius: var(--radius-sm);
            overflow: hidden;
            background: #0e1621;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .messenger-image-wrapper img {
            width: 100%;
            height: auto;
            max-height: 520px;
            object-fit: contain;
            display: block;
        }

        .seo-input-group {
            margin-bottom: 1.25rem;
            width: 100%;
        }

        .seo-counter-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.4rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .seo-badge {
            background: rgba(14, 116, 144, 0.25);
            color: var(--cyan-light);
            padding: 0.15rem 0.55rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .seo-badge.good {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        .seo-badge.warn {
            background: rgba(245, 158, 11, 0.18);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        @media (max-width: 768px) {
            .admin-header {
                padding: 0.75rem 1rem;
            }
            .main-container {
                padding: 0 1rem;
            }
            .panel-card {
                padding: 1.25rem 1rem;
            }
            .brand-subtitle, .header-status-pill {
                display: none;
            }
            .sticky-save-bar {
                bottom: 1rem;
                padding: 0.5rem 1rem;
                gap: 0.75rem;
            }
            .kbd-badge {
                display: none;
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
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="#" class="brand-logo">
                <img src="/logo.png" alt="لوگو دفتر وکالت" class="brand-logo-img">
                <div class="brand-info">
                    <span class="brand-title">مدیریت وب‌سایت کیان‌ارثی</span>
                    <span class="brand-subtitle">دفتر وکالت تخصصی دعاوی آب و املاک</span>
                </div>
            </a>
            <div class="header-status-pill">
                <span class="status-dot"></span>
                <span>سامانه فعال و امن</span>
            </div>
        </div>

        <div class="header-actions">
            <div class="admin-user-chip" title="حساب مدیر جاری">
                <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>مدیر: <?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></span>
            </div>
            <a href="api.php?action=download_backup" class="btn btn-outline" style="border-color: #059669; color: #34d399;" title="دانلود کل اطلاعات سایت در یک فایل">
                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span class="btn-text">بک‌آپ</span>
                <span class="btn-text-long"> اطلاعات</span>
            </a>
            <a href="../" target="_blank" class="btn btn-outline" title="مشاهده وب‌سایت در صفحه جدید">
                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                <span class="btn-text">مشاهده سایت</span>
            </a>
            <button onclick="handleLogout()" class="btn btn-danger" title="خروج از پنل مدیریت">
                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="btn-text">خروج</span>
            </button>
        </div>
    </header>

    <?php if (is_using_default_password()): ?>
    <div id="securityWarningBanner" class="security-banner-wrap" style="max-width: 1200px; margin: 0.85rem auto 0; padding: 0 1.5rem;">
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 6px; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.6rem; color: #fca5a5; font-size: 0.825rem; line-height: 1.5;">
                <svg class="admin-icon" style="color: #ef4444; width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span><strong>هشدار امنیتی:</strong> کلمه عبور فعلی، رمز پیش‌فرض اولیه است. لطفاً برای ارتقای امنیت وب‌سایت، هم‌اکنون از تب امنیت رمز خود را تغییر دهید.</span>
            </div>
            <button onclick="switchTab('security')" class="btn btn-danger btn-sm" style="flex-shrink: 0;">
                تغییر فوری رمز
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="tabs-container">
        <button class="tab-btn active" onclick="switchTab('general')">
            <svg class="admin-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span>اطلاعات عمومی و تماس</span>
        </button>
        <button class="tab-btn" onclick="switchTab('seo')">
            <svg class="admin-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            <span>تصاویر و سئو (SEO)</span>
        </button>
        <button class="tab-btn" onclick="switchTab('laws')">
            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
            <span>کتابخانه قوانین و دسته‌بندی‌ها</span>
        </button>
        <button class="tab-btn" onclick="switchTab('analytics')">
            <svg class="admin-icon" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
            <span>آمار و نمودارهای تحلیلی</span>
        </button>
        <button class="tab-btn" onclick="switchTab('security')">
            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect width="6" height="4" x="9" y="11" rx="1"/><path d="M10 11V9a2 2 0 0 1 4 0v2"/></svg>
            <span>امنیت و مدیریت مدیران</span>
        </button>
    </div>

    <main class="main-container">
        
        <!-- TAB 1: GENERAL & CONTACT SETTINGS -->
        <div id="tab-general" class="tab-content">
            
            <!-- Card 1: Identity & Official Titles -->
            <div class="panel-card">
                <div class="card-header">
                    <div class="card-header-main">
                        <div class="card-icon-badge">
                            <svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <h2 class="card-title">هویت و عناوین اصلی وکیل</h2>
                            <p class="card-subtitle">تنظیم نام رسمی وکیل، تیتر هدر و زیرعنوان تخصصی معرفی در صفحه اول</p>
                        </div>
                    </div>
                    <button type="button" onclick="saveGeneralData()" class="btn btn-success">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>ذخیره تغییرات</span>
                    </button>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="lawyerName">نام و نشان وکیل:</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" id="lawyerName" class="form-control has-icon" placeholder="مثال: محمدحسن کیان‌ارثی">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lawyerTitle">عنوان اصلی هدر (Title):</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            </span>
                            <input type="text" id="lawyerTitle" class="form-control has-icon" placeholder="مثال: وکیل پایه یک دادگستری | دعاوی تخصصی آب و املاک">
                        </div>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label" for="lawyerSubtitle">زیرعنوان تخصصی و حوزه فعالیت:</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg>
                            </span>
                            <input type="text" id="lawyerSubtitle" class="form-control has-icon" placeholder="مثال: مشاوره و وکالت تخصصی در دعاوی حریم تأسیسات آبی، چاه‌های کشاورزی، کمیسیون‌های آب منطقه‌ای و دیوان عدالت اداری">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Professional Records & Experience -->
            <div class="panel-card">
                <div class="card-header">
                    <div class="card-header-main">
                        <div class="card-icon-badge">
                            <svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <div>
                            <h2 class="card-title">سوابق حرفه‌ای و صلاحیت‌های علمی</h2>
                            <p class="card-subtitle">کارت‌های شاخص‌های آماری و اعتمادساز در بخش بالایی سایت</p>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="expYears">سال‌های سابقه وکالت پایه یک دادگستری (عدد):</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </span>
                            <input type="text" id="expYears" class="form-control has-icon" placeholder="مثال: ۱۷">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="commYears">سابقه حضور در کمیسیون‌های آب (عدد):</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
                            </span>
                            <input type="text" id="commYears" class="form-control has-icon" placeholder="مثال: ۷">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="eduField">رشته و مقطع تحصیلی دانشگاهی:</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            </span>
                            <input type="text" id="eduField" class="form-control has-icon" placeholder="مثال: کارشناسی ارشد حقوق خصوصی">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Contact & Office Location -->
            <div class="panel-card">
                <div class="card-header">
                    <div class="card-header-main">
                        <div class="card-icon-badge">
                            <svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <h2 class="card-title">ارتباط مستقیم تلفنی و نشانی دفتر کرج</h2>
                            <p class="card-subtitle">تنظیم شماره تماس تماس مستقیم و آدرس دقیق دفتر جهت مراجعه حضوری موکلین</p>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="phone">شماره تلفن مستقیم همراه / دفتر:</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="text" id="phone" class="form-control has-icon" placeholder="۰۹۱۲۷۶۹۸۸۶۴" style="direction: ltr; text-align: right;">
                        </div>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label" for="address">نشانی کامل دفتر وکالت در کرج:</label>
                        <div class="input-wrap textarea-wrap">
                            <span class="input-icon">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <textarea id="address" class="form-control has-icon" style="min-height: 85px;" placeholder="کرج، میدان آزادگان، ..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Iranian & Global Social Networks -->
            <div class="panel-card">
                <div class="card-header">
                    <div class="card-header-main">
                        <div class="card-icon-badge">
                            <svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                        </div>
                        <div>
                            <h2 class="card-title">پیام‌رسان‌های ایرانی و درگاه‌های شبکه‌های اجتماعی</h2>
                            <p class="card-subtitle">مدیریت آیدی و لینک ارتباط آنلاین در ایتا، بله، روبیکا و اینستاگرام</p>
                        </div>
                    </div>
                </div>

                <div class="social-cards-grid">
                    
                    <!-- 1. Instagram -->
                    <div class="social-channel-box instagram-box">
                        <div class="social-channel-header">
                            <div class="social-icon-box" style="background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);">
                                <svg class="admin-icon" style="color: #ffffff;" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </div>
                            <div>
                                <strong style="font-size: 0.95rem; color: #ffffff;">اینستاگرام (Instagram)</strong>
                                <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">صفحه رسمی و ویدیوهای حقوقی</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" for="instagram">آیدی / نام کاربری اینستاگرام:</label>
                            <input type="text" id="instagram" class="form-control" placeholder="vakilkianersi" style="direction: ltr;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="instagramUrl">لینک مستقیم صفحه اینستاگرام:</label>
                            <input type="text" id="instagramUrl" class="form-control" placeholder="https://instagram.com/vakilkianersi" style="direction: ltr;">
                        </div>
                    </div>

                    <!-- 2. Eitaa -->
                    <div class="social-channel-box eitaa-box">
                        <div class="social-channel-header">
                            <div class="social-icon-box" style="background: #e67e22;">
                                <svg class="admin-icon" style="color: #ffffff;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div>
                                <strong style="font-size: 0.95rem; color: #ffffff;">پیام‌رسان ایتا (Eitaa)</strong>
                                <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">مشاوره و ارسال مدارک در ایتا</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" for="eitaa">آیدی کاربری در ایتا:</label>
                            <input type="text" id="eitaa" class="form-control" placeholder="vakilkianersi" style="direction: ltr;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="eitaaUrl">لینک ارتباط مستقیم در ایتا:</label>
                            <input type="text" id="eitaaUrl" class="form-control" placeholder="https://eitaa.com/vakilkianersi" style="direction: ltr;">
                        </div>
                    </div>

                    <!-- 3. Bale -->
                    <div class="social-channel-box bale-box">
                        <div class="social-channel-header">
                            <div class="social-icon-box" style="background: #10b981;">
                                <svg class="admin-icon" style="color: #ffffff;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div>
                                <strong style="font-size: 0.95rem; color: #ffffff;">پیام‌رسان بله (Bale)</strong>
                                <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">ارتباط و ارسال اسناد در بله</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" for="bale">آیدی کاربری در بله:</label>
                            <input type="text" id="bale" class="form-control" placeholder="vakilkianersi" style="direction: ltr;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="baleUrl">لینک ارتباط مستقیم در بله:</label>
                            <input type="text" id="baleUrl" class="form-control" placeholder="https://ble.ir/vakilkianersi" style="direction: ltr;">
                        </div>
                    </div>

                    <!-- 4. Rubika -->
                    <div class="social-channel-box rubika-box">
                        <div class="social-channel-header">
                            <div class="social-icon-box" style="background: #8e44ad;">
                                <svg class="admin-icon" style="color: #ffffff;" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div>
                                <strong style="font-size: 0.95rem; color: #ffffff;">پیام‌رسان روبیکا (Rubika)</strong>
                                <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">کانال و ارتباط در روبیکا</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" for="rubika">آیدی کاربری در روبیکا:</label>
                            <input type="text" id="rubika" class="form-control" placeholder="vakilkianersi" style="direction: ltr;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="rubikaUrl">لینک ارتباط مستقیم در روبیکا:</label>
                            <input type="text" id="rubikaUrl" class="form-control" placeholder="https://rubika.ir/vakilkianersi" style="direction: ltr;">
                        </div>
                    </div>

                </div>

                <div class="form-save-footer" style="text-align: left; margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                    <button type="button" onclick="saveGeneralData()" class="btn btn-success" style="padding: 0.75rem 1.75rem; font-size: 0.9rem;">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>ذخیره کلیه تنظیمات عمومی</span>
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
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
                            <span>دسته‌بندی جدید</span>
                        </button>
                        <button onclick="openLawModal()" class="btn btn-primary">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
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
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                            <span>به‌روزرسانی</span>
                        </button>
                        <button onclick="resetAnalytics()" class="btn btn-danger">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            <span>صفر کردن آمار</span>
                        </button>
                    </div>
                </div>

                <!-- Numerical KPI Cards -->
                <div class="analytics-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: var(--cyan-light);"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></div>
                        <div id="statViews" style="font-size: 1.65rem; font-weight: 700; color: var(--cyan-light);">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">بازدید کل سایت</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #34d399;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                        <div id="statPhone" style="font-size: 1.65rem; font-weight: 700; color: #34d399;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">تماس مستقیم تلفنی</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #f59e0b;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                        <div id="statEitaa" style="font-size: 1.65rem; font-weight: 700; color: #f59e0b;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به ایتا</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #ec4899;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></div>
                        <div id="statInstagram" style="font-size: 1.65rem; font-weight: 700; color: #ec4899;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">صفحه اینستاگرام</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #10b981;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                        <div id="statBale" style="font-size: 1.65rem; font-weight: 700; color: #10b981;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به بله</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #6366f1;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                        <div id="statRubika" style="font-size: 1.65rem; font-weight: 700; color: #6366f1;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مراجعه به روبیکا</div>
                    </div>
                    <div class="stat-box" style="background: rgba(3, 24, 37, 0.7); border: 1px solid var(--border-color); padding: 1.15rem; border-radius: 4px; text-align: center;">
                        <div style="margin-bottom: 0.4rem; color: #38bdf8;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg></div>
                        <div id="statMaps" style="font-size: 1.65rem; font-weight: 700; color: #38bdf8;">۰</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">مسیریابی نقشه و بلد</div>
                    </div>
                </div>

                <!-- VISUAL CHARTS SECTION -->
                <div class="chart-card">
                    <h3 class="chart-title">
                        <svg class="admin-icon" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
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
                        <h2 class="card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span>تغییر کلمه عبور حساب جاری</span>
                        </h2>
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
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
                            <span>به‌روزرسانی کلمه عبور</span>
                        </button>
                    </form>
                </div>

                <!-- Box 2: Add New Admin -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <div class="card-header">
                        <h2 class="card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            <span>افزودن مدیر جدید به سیستم</span>
                        </h2>
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
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            <span>ایجاد حساب مدیر جدید</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Box 3: Existing Admins List -->
            <div class="panel-card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <span>لیست مدیران فعال سیستم</span>
                        </h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                            توجه: طبق استاندارد امنیتی، همیشه باید حداقل ۱ مدیر در سیستم فعال باشد و امکان حذف آخرین مدیر وجود ندارد.
                        </p>
                    </div>
                    <button onclick="loadAdmins()" class="btn btn-outline btn-sm">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                        <span>به‌روزرسانی لیست</span>
                    </button>
                </div>

                <div id="adminsTableContainer">
                    <p style="color: var(--text-muted); text-align: center; padding: 1.5rem;">در حال دریافت لیست مدیران...</p>
                </div>
            </div>

        </div>

        <!-- TAB 5: IMAGES & SEO -->
        <div id="tab-seo" class="tab-content" style="display: none;">
            <!-- Part 1: Visual Image Assets Management with Auto-WebP -->
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">مدیریت تصاویر و هویت بصری سایت</h2>
                        <p style="color: var(--text-muted); font-size: 0.825rem; margin-top: 0.25rem;">
                            بارگذاری و تعویض تصاویر با <strong>تبدیل خودکار به WebP فوق‌العاده باکیفیت و کم‌حجم</strong> جهت افزایش سرعت لود سایت و رضایت کاربران.
                        </p>
                    </div>
                </div>

                <div class="seo-grid">
                    <!-- 1. Lawyer Portrait Card -->
                    <div class="image-card">
                        <div class="image-card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>تصویر پرتره رسمی وکیل</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.775rem;">نمایش در بخش بالایی صفحه اصلی (Hero) و معرفی وکیل.</p>
                        <div class="image-preview-box">
                            <span class="image-preview-badge">WebP 92%</span>
                            <img id="lawyerImagePreview" src="/images/lawyer-portrait.webp" alt="پرتره وکیل">
                        </div>
                        <input type="file" id="fileLawyer" class="file-upload-input" accept="image/png,image/jpeg,image/webp" onchange="previewSelectedFile(this, 'lawyer')">
                        <div class="image-actions">
                            <button type="button" class="btn btn-primary" onclick="triggerFileInput('fileLawyer')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>انتخاب تصویر</span>
                            </button>
                            <button type="button" id="btnUploadLawyer" class="btn btn-success" onclick="uploadImage('lawyer')" disabled>
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                <span>آپلود و تبدیل</span>
                            </button>
                            <button type="button" class="btn btn-secondary" style="flex: 1 1 100%;" onclick="resetImage('lawyer')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                                <span>بازنشانی به تصویر پیش‌فرض اولیه</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Logo Card -->
                    <div class="image-card">
                        <div class="image-card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            <span>لوگو و نشان رسمی دفتر</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.775rem;">نمایش در منوی بالا و فوتر سایت (با حفظ کامل شفافیت / Alpha).</p>
                        <div class="image-preview-box">
                            <span class="image-preview-badge">WebP Transparent</span>
                            <img id="logoImagePreview" src="/logo.webp" alt="لوگو دفتر">
                        </div>
                        <input type="file" id="fileLogo" class="file-upload-input" accept="image/png,image/jpeg,image/webp" onchange="previewSelectedFile(this, 'logo')">
                        <div class="image-actions">
                            <button type="button" class="btn btn-primary" onclick="triggerFileInput('fileLogo')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>انتخاب لوگو</span>
                            </button>
                            <button type="button" id="btnUploadLogo" class="btn btn-success" onclick="uploadImage('logo')" disabled>
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                <span>آپلود و تبدیل</span>
                            </button>
                            <button type="button" class="btn btn-secondary" style="flex: 1 1 100%;" onclick="resetImage('logo')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                                <span>بازنشانی به لوگوی پیش‌فرض اولیه</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3. SEO / Social Share Preview Card -->
                    <div class="image-card">
                        <div class="image-card-title">
                            <svg class="admin-icon" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            <span>تصویر پیش‌نمایش اشتراک‌گذاری (Open Graph)</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.775rem;">نمایش هنگام ارسال لینک سایت در ایتا، بله، روبیکا، واتساپ و تلگرام.</p>
                        <div class="image-preview-box">
                            <span class="image-preview-badge">WebP 1200x630</span>
                            <img id="seoImagePreview" src="/preview.webp" alt="پیش‌نمایش سئو">
                        </div>
                        <input type="file" id="fileSeo" class="file-upload-input" accept="image/png,image/jpeg,image/webp" onchange="previewSelectedFile(this, 'seo')">
                        <div class="image-actions">
                            <button type="button" class="btn btn-primary" onclick="triggerFileInput('fileSeo')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>انتخاب تصویر</span>
                            </button>
                            <button type="button" id="btnUploadSeo" class="btn btn-success" onclick="uploadImage('seo')" disabled>
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                <span>آپلود و تبدیل</span>
                            </button>
                            <button type="button" class="btn btn-secondary" style="flex: 1 1 100%;" onclick="resetImage('seo')">
                                <svg class="admin-icon" viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                                <span>بازنشانی به تصویر پیش‌فرض</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Part 2: SEO Meta Text & Dual Live Simulators -->
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">تنظیمات متنی متای سئو و بهینه‌سازی موتورهای جستجو</h2>
                        <p style="color: var(--text-muted); font-size: 0.825rem; margin-top: 0.25rem;">
                            مدیریت تایتل و توضیحات متای وب‌سایت برای افزایش رتبه در جستجوهای وکیل کرج، دعاوی آب و املاک.
                        </p>
                    </div>
                    <button type="button" onclick="saveSeoData()" class="btn btn-success">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>ذخیره تنظیمات سئو</span>
                    </button>
                </div>

                <!-- Form Controls for SEO -->
                <div>
                    <!-- Meta Title Group -->
                    <div class="seo-input-group">
                        <label class="form-label">
                            <svg class="admin-icon" viewBox="0 0 24 24"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
                            <span>عنوان صفحه در گوگل و تب مرورگر (Meta Title):</span>
                        </label>
                        <input type="text" id="seoTitle" class="form-control" placeholder="محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک" oninput="updateSeoPreviews()">
                        <div class="seo-counter-row">
                            <span>طول استاندارد پیشنهادی گوگل: ۵۰ الی ۶۰ کاراکتر</span>
                            <span id="seoTitleCount" class="seo-badge">۰ کاراکتر</span>
                        </div>
                    </div>

                    <!-- Meta Description Group -->
                    <div class="seo-input-group">
                        <label class="form-label">
                            <svg class="admin-icon" viewBox="0 0 24 24"><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg>
                            <span>توضیحات متا برای موتورهای جستجو و اشتراک لینک (Meta Description):</span>
                        </label>
                        <textarea id="seoDescription" class="form-control" rows="3" placeholder="دفتر وکالت تخصصی محمدحسن کیان‌ارثی در کرج؛ متخصص دعاوی آب، چاه‌های کشاورزی، حریم تأسیسات آبی و دیوان عدالت اداری." oninput="updateSeoPreviews()"></textarea>
                        <div class="seo-counter-row">
                            <span>طول ایده‌آل گوگل و پیام‌رسان‌ها: ۱۲۰ الی ۱۶۰ کاراکتر</span>
                            <span id="seoDescCount" class="seo-badge">۰ کاراکتر</span>
                        </div>
                    </div>

                    <!-- Meta Keywords Group -->
                    <div class="seo-input-group">
                        <label class="form-label">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            <span>کلمات کلیدی متا (Meta Keywords):</span>
                        </label>
                        <textarea id="seoKeywords" class="form-control" rows="2" placeholder="وکیل کرج, وکیل آب, دعاوی چاه کشاورزی, حریم رودخانه, وکیل ملکی البرز, کمیسیون آبهای زیرزمینی, محمدحسن کیان ارثی"></textarea>
                        <div class="seo-counter-row">
                            <span>کلمات کلیدی را با کاما انگلیسی (,) یا ویرگول فارسی (،) جدا نمایید.</span>
                        </div>
                    </div>
                </div>

                <!-- Dual Live Simulators: Google Search + Social Share -->
                <div class="preview-columns-grid">
                    <!-- Column 1: Google SERP Simulator -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <svg class="admin-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <strong style="font-size: 0.9rem; color: #ffffff;">پیش‌نمایش زنده در نتایج جستجوی گوگل</strong>
                        </div>
                        <div class="google-serp-preview">
                            <div class="serp-url-row">
                                <img id="serpLogoPreview" src="/logo.webp" alt="لوگو" class="serp-favicon-img">
                                <div class="serp-site-info">
                                    <span class="serp-site-name">دفتر وکالت محمدحسن کیان‌ارثی</span>
                                    <span class="serp-site-url">https://vakilkianersi.ir</span>
                                </div>
                            </div>
                            <div id="googlePreviewTitle" class="serp-title">محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک</div>
                            <div id="googlePreviewDesc" class="serp-description">دفتر وکالت تخصصی محمدحسن کیان‌ارثی در کرج؛ متخصص دعاوی آب، چاه‌های کشاورزی، حریم تأسیسات آبی و دیوان عدالت اداری.</div>
                        </div>
                    </div>

                    <!-- Column 2: Messenger / Social Share Card (Telegram / Eitaa / Bale / WhatsApp) -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                            <strong style="font-size: 0.9rem; color: #ffffff;">پیش‌نمایش کارت اشتراک لینک در پیام‌رسان‌ها</strong>
                        </div>
                        <div class="messenger-preview-container">
                            <div class="messenger-chat-bubble">
                                <span class="messenger-link-header">https://vakilkianersi.ir/</span>
                                <div class="messenger-rich-card">
                                    <div class="messenger-site-name">دفتر وکالت محمدحسن کیان‌ارثی</div>
                                    <div id="messengerPreviewTitle" class="messenger-title">محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک</div>
                                    <div id="messengerPreviewDesc" class="messenger-desc">دفتر وکالت تخصصی محمدحسن کیان‌ارثی در کرج؛ متخصص دعاوی آب، چاه‌های کشاورزی، حریم تأسیسات آبی و دیوان عدالت اداری.</div>
                                    <div class="messenger-image-wrapper">
                                        <img id="messengerPreviewImage" src="/preview.webp" alt="تصویر پیش‌نمایش اشتراک‌گذاری">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; text-align: left;">
                    <button type="button" onclick="saveSeoData()" class="btn btn-success">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>ذخیره تنظیمات سئو</span>
                    </button>
                </div>
            </div>
        </div>

    
        <!-- Floating Smart Action Bar -->
        <div id="stickySaveBar" class="sticky-save-bar">
            <div class="sticky-save-info">
                <svg class="admin-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                <span id="stickySaveText">آماده برای ثبت تغییرات</span>
                <span class="kbd-badge">Ctrl + S</span>
            </div>
            <button type="button" id="stickySaveBtn" onclick="handleActiveSave()" class="btn btn-success btn-sm">
                <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span id="stickySaveBtnLabel">ذخیره سریع</span>
            </button>
        </div>

    </main>

    <!-- ─── CATEGORY ADD / EDIT MODAL ─── -->
    <div id="categoryModal" class="modal-overlay">
        <div class="modal-box" style="max-width: 480px;">
            <div class="card-header">
                <h3 id="categoryModalHeading" class="card-title">دسته‌بندی جدید قوانین</h3>
                <button onclick="closeCategoryModal()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; display: flex; align-items: center;" aria-label="بستن">
                    <svg class="admin-icon" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
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
                <button onclick="closeLawModal()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; display: flex; align-items: center;" aria-label="بستن">
                    <svg class="admin-icon" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            
            <input type="hidden" id="modalLawId">
            
            <div class="form-group">
                <label class="form-label">عنوان کامل قانون یا آیین‌نامه:</label>
                <input type="text" id="modalLawTitle" class="form-control" required placeholder="مثال: قانون تعیین تکلیف چاه‌های آب فاقد پروانه">
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <label class="form-label" style="margin-bottom: 0;">دسته‌بندی موضوعی قانون در سایت:</label>
                    <button type="button" onclick="openCategoryModal()" style="background: none; border: none; color: var(--cyan-light); font-size: 0.775rem; cursor: pointer; text-decoration: underline; display: inline-flex; align-items: center; gap: 0.25rem;">
                        <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        <span>ایجاد دسته‌بندی جدید</span>
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
        let currentActiveTabId = 'general';

        function handleActiveSave() {
            if (currentActiveTabId === 'seo') {
                saveSeoData();
            } else {
                saveGeneralData();
            }
        }

        // Global Keyboard Shortcut: Ctrl + S / Cmd + S
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                e.preventDefault();
                handleActiveSave();
            }
        });

        function switchTab(tabId) {
            currentActiveTabId = tabId;
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            const target = document.getElementById('tab-' + tabId);
            if (target) target.style.display = 'block';

            const activeBtn = Array.from(document.querySelectorAll('.tab-btn')).find(b => b.getAttribute('onclick').includes(tabId));
            if (activeBtn) activeBtn.classList.add('active');

            // Manage Sticky Bar Visibility and Context
            const stickyBar = document.getElementById('stickySaveBar');
            const stickyText = document.getElementById('stickySaveText');
            const stickyBtnLabel = document.getElementById('stickySaveBtnLabel');
            if (stickyBar) {
                if (tabId === 'general') {
                    stickyBar.style.display = 'flex';
                    if (stickyText) stickyText.textContent = 'تنظیمات عمومی و تماس';
                    if (stickyBtnLabel) stickyBtnLabel.textContent = 'ذخیره عمومی';
                } else if (tabId === 'seo') {
                    stickyBar.style.display = 'flex';
                    if (stickyText) stickyText.textContent = 'تنظیمات سئو و متادیتا';
                    if (stickyBtnLabel) stickyBtnLabel.textContent = 'ذخیره سئو';
                } else {
                    stickyBar.style.display = 'none';
                }
            }

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

            // SEO Text fields
            if (document.getElementById('seoTitle')) {
                document.getElementById('seoTitle').value = gen.seoTitle || '';
            }
            if (document.getElementById('seoDescription')) {
                document.getElementById('seoDescription').value = gen.seoDescription || '';
            }
            if (document.getElementById('seoKeywords')) {
                document.getElementById('seoKeywords').value = gen.seoKeywords || '';
            }

            // Image Previews with Absolute Asset Resolution
            function resolveAssetUrl(url, fallback) {
                if (!url) return fallback;
                let u = String(url).trim();
                if (u.startsWith('./')) u = '/' + u.slice(2);
                else if (!u.startsWith('/') && !u.startsWith('http')) u = '/' + u;
                return u;
            }

            const cacheBuster = '?v=' + Date.now();
            const lawyerUrl = resolveAssetUrl(gen.lawyerImage, '/images/lawyer-portrait.webp');
            const logoUrl = resolveAssetUrl(gen.logoImage, '/logo.webp');
            const seoUrl = resolveAssetUrl(gen.seoImage, '/preview.webp');

            if (document.getElementById('lawyerImagePreview')) {
                document.getElementById('lawyerImagePreview').src = lawyerUrl + cacheBuster;
            }
            if (document.getElementById('logoImagePreview')) {
                document.getElementById('logoImagePreview').src = logoUrl + cacheBuster;
            }
            if (document.getElementById('seoImagePreview')) {
                document.getElementById('seoImagePreview').src = seoUrl + cacheBuster;
            }
            if (document.getElementById('serpLogoPreview')) {
                document.getElementById('serpLogoPreview').src = logoUrl + cacheBuster;
            }
            if (document.getElementById('messengerPreviewImage')) {
                document.getElementById('messengerPreviewImage').src = (seoUrl || lawyerUrl) + cacheBuster;
            }

            updateSeoPreviews();
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

            // Preserve SEO if available
            if (document.getElementById('seoTitle')) general.seoTitle = document.getElementById('seoTitle').value.trim();
            if (document.getElementById('seoDescription')) general.seoDescription = document.getElementById('seoDescription').value.trim();
            if (document.getElementById('seoKeywords')) general.seoKeywords = document.getElementById('seoKeywords').value.trim();

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

        /* ─── SEO & IMAGE MANAGEMENT FUNCTIONS ─── */
        function updateSeoPreviews() {
            const titleEl = document.getElementById('seoTitle');
            const descEl = document.getElementById('seoDescription');
            const previewTitle = document.getElementById('googlePreviewTitle');
            const previewDesc = document.getElementById('googlePreviewDesc');
            const msgTitle = document.getElementById('messengerPreviewTitle');
            const msgDesc = document.getElementById('messengerPreviewDesc');
            const titleCount = document.getElementById('seoTitleCount');
            const descCount = document.getElementById('seoDescCount');

            if (!titleEl || !descEl) return;

            const titleVal = titleEl.value.trim() || 'محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک';
            const descVal = descEl.value.trim() || 'دفتر وکالت تخصصی محمدحسن کیان‌ارثی در کرج؛ متخصص دعاوی آب، چاه‌های کشاورزی، حریم تأسیسات آبی و دیوان عدالت اداری.';

            if (previewTitle) previewTitle.textContent = titleVal;
            if (previewDesc) previewDesc.textContent = descVal;
            if (msgTitle) msgTitle.textContent = titleVal;
            if (msgDesc) msgDesc.textContent = descVal;

            const tLen = titleEl.value.length;
            if (titleCount) {
                titleCount.textContent = tLen + ' کاراکتر';
                if (tLen >= 45 && tLen <= 65) {
                    titleCount.className = 'seo-badge good';
                } else if (tLen > 65) {
                    titleCount.className = 'seo-badge warn';
                } else {
                    titleCount.className = 'seo-badge';
                }
            }

            const dLen = descEl.value.length;
            if (descCount) {
                descCount.textContent = dLen + ' کاراکتر';
                if (dLen >= 120 && dLen <= 165) {
                    descCount.className = 'seo-badge good';
                } else if (dLen > 165) {
                    descCount.className = 'seo-badge warn';
                } else {
                    descCount.className = 'seo-badge';
                }
            }
        }

        function updateGooglePreview() {
            updateSeoPreviews();
        }

        async function saveSeoData() {
            const seoTitle = document.getElementById('seoTitle') ? document.getElementById('seoTitle').value.trim() : '';
            const seoDescription = document.getElementById('seoDescription') ? document.getElementById('seoDescription').value.trim() : '';
            const seoKeywords = document.getElementById('seoKeywords') ? document.getElementById('seoKeywords').value.trim() : '';

            try {
                const res = await fetch('api.php?action=save_general', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ 
                        general: { seoTitle, seoDescription, seoKeywords } 
                    })
                });
                const result = await res.json();
                if (result.success) {
                    showToast('تنظیمات سئو و متای سایت با موفقیت ذخیره شد.');
                    if (currentSiteData && currentSiteData.general) {
                        currentSiteData.general.seoTitle = seoTitle;
                        currentSiteData.general.seoDescription = seoDescription;
                        currentSiteData.general.seoKeywords = seoKeywords;
                    }
                } else {
                    showToast(result.error || 'خطا در ذخیره سئو', true);
                }
            } catch (err) {
                showToast('خطا در ارتباط با سرور', true);
            }
        }

        function triggerFileInput(id) {
            const input = document.getElementById(id);
            if (input) input.click();
        }

        const selectedImageFiles = {};

        function previewSelectedFile(input, type) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            if (file.size > 12 * 1024 * 1024) {
                showToast('حجم فایل انتخابی بیش از حد مجاز (حداکثر ۱۲ مگابایت) است.', true);
                input.value = '';
                return;
            }

            selectedImageFiles[type] = file;

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewMap = {
                    lawyer: 'lawyerImagePreview',
                    logo: 'logoImagePreview',
                    seo: 'seoImagePreview'
                };
                const img = document.getElementById(previewMap[type]);
                if (img) img.src = e.target.result;

                // Sync live simulators immediately
                if (type === 'logo') {
                    const serpLogo = document.getElementById('serpLogoPreview');
                    if (serpLogo) serpLogo.src = e.target.result;
                }
                if (type === 'seo' || type === 'lawyer') {
                    const msgImg = document.getElementById('messengerPreviewImage');
                    if (msgImg) msgImg.src = e.target.result;
                }

                const btnMap = {
                    lawyer: 'btnUploadLawyer',
                    logo: 'btnUploadLogo',
                    seo: 'btnUploadSeo'
                };
                const btn = document.getElementById(btnMap[type]);
                if (btn) btn.disabled = false;
            };
            reader.readAsDataURL(file);
        }

        async function uploadImage(type) {
            const file = selectedImageFiles[type];
            if (!file) {
                showToast('لطفاً ابتدا تصویری انتخاب کنید.', true);
                return;
            }

            const btnMap = {
                lawyer: 'btnUploadLawyer',
                logo: 'btnUploadLogo',
                seo: 'btnUploadSeo'
            };
            const btn = document.getElementById(btnMap[type]);
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span>در حال آپلود و تبدیل به WebP...</span>';
            }

            try {
                const reader = new FileReader();
                reader.onload = async function(e) {
                    const dataUrl = e.target.result;
                    try {
                        const res = await fetch('api.php?action=upload_image', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-Token': currentCsrfToken
                            },
                            body: JSON.stringify({
                                type: type,
                                image_base64: dataUrl
                            })
                        });
                        const result = await res.json();
                        if (result.success) {
                            showToast(result.message || 'تصویر با موفقیت بارگذاری و به WebP بهینه تبدیل شد.');
                            const previewMap = {
                                lawyer: 'lawyerImagePreview',
                                logo: 'logoImagePreview',
                                seo: 'seoImagePreview'
                            };
                            let finalUrl = result.url;
                            if (finalUrl.startsWith('./')) finalUrl = '/' + finalUrl.slice(2);
                            else if (!finalUrl.startsWith('/') && !finalUrl.startsWith('http')) finalUrl = '/' + finalUrl;

                            const freshUrl = finalUrl + '?t=' + Date.now();
                            const img = document.getElementById(previewMap[type]);
                            if (img) img.src = freshUrl;

                            // Sync simulators
                            if (type === 'logo') {
                                const serpLogo = document.getElementById('serpLogoPreview');
                                if (serpLogo) serpLogo.src = freshUrl;
                            }
                            if (type === 'seo' || type === 'lawyer') {
                                const msgImg = document.getElementById('messengerPreviewImage');
                                if (msgImg) msgImg.src = freshUrl;
                            }

                            if (currentSiteData && currentSiteData.general) {
                                currentSiteData.general[result.field] = result.url;
                            }
                            delete selectedImageFiles[type];
                        } else {
                            showToast(result.error || 'خطا در آپلود تصویر', true);
                        }
                    } catch (err) {
                        showToast('خطا در ارسال تصویر به سرور', true);
                    } finally {
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = originalText;
                        }
                    }
                };
                reader.readAsDataURL(file);
            } catch (err) {
                showToast('خطا در خواندن فایل', true);
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            }
        }

        async function resetImage(type) {
            if (!confirm('آیا مطمئن هستید که می‌خواهید این تصویر به حالت پیش‌فرض اولیه بازگردد؟')) {
                return;
            }

            try {
                const res = await fetch('api.php?action=reset_image', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': currentCsrfToken
                    },
                    body: JSON.stringify({ type })
                });
                const result = await res.json();
                if (result.success) {
                    showToast(result.message || 'تصویر به حالت پیش‌فرض بازگشت.');
                    const previewMap = {
                        lawyer: 'lawyerImagePreview',
                        logo: 'logoImagePreview',
                        seo: 'seoImagePreview'
                    };
                    let finalUrl = result.url;
                    if (finalUrl.startsWith('./')) finalUrl = '/' + finalUrl.slice(2);
                    else if (!finalUrl.startsWith('/') && !finalUrl.startsWith('http')) finalUrl = '/' + finalUrl;

                    const freshUrl = finalUrl + '?t=' + Date.now();
                    const img = document.getElementById(previewMap[type]);
                    if (img) img.src = freshUrl;

                    if (type === 'logo') {
                        const serpLogo = document.getElementById('serpLogoPreview');
                        if (serpLogo) serpLogo.src = freshUrl;
                    }
                    if (type === 'seo' || type === 'lawyer') {
                        const msgImg = document.getElementById('messengerPreviewImage');
                        if (msgImg) msgImg.src = freshUrl;
                    }

                    const fieldMap = {
                        lawyer: 'lawyerImage',
                        logo: 'logoImage',
                        seo: 'seoImage'
                    };
                    if (currentSiteData && currentSiteData.general) {
                        currentSiteData.general[fieldMap[type]] = result.url;
                    }
                    delete selectedImageFiles[type];
                    const btnMap = {
                        lawyer: 'btnUploadLawyer',
                        logo: 'btnUploadLogo',
                        seo: 'btnUploadSeo'
                    };
                    const btn = document.getElementById(btnMap[type]);
                    if (btn) btn.disabled = true;
                } else {
                    showToast(result.error || 'خطا در بازنشانی تصویر', true);
                }
            } catch (err) {
                showToast('خطا در ارتباط با سرور', true);
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
                            <svg class="admin-icon" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            <span>ایجاد اولین دسته‌بندی</span>
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
                            <span style="color: var(--cyan-light); display: flex; align-items: center;"><svg class="admin-icon admin-icon-lg" viewBox="0 0 24 24"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg></span>
                            <strong style="font-size: 1rem; color: #ffffff;">${escapeHtml(cat.label)}</strong>
                            <span class="category-badge-count">${countFa} قانون</span>
                        </div>
                        <div class="category-actions">
                            <button onclick="openLawModal('${cat.id}')" class="btn btn-success btn-sm" title="افزودن قانون مستقیماً به این بخش">
                                <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                <span>افزودن قانون به این بخش</span>
                            </button>
                            <button onclick="editCategory('${cat.id}', '${escapeHtml(cat.label)}')" class="btn btn-outline btn-sm" title="ویرایش عنوان دسته‌بندی">
                                <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                <span>ویرایش نام</span>
                            </button>
                            <button onclick="deleteCategory('${cat.id}', '${escapeHtml(cat.label)}')" class="btn btn-danger btn-sm" title="حذف این دسته‌بندی">
                                <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
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
                                    <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                    <span>ویرایش</span>
                                </button>
                                <button onclick="deleteLaw(${law.id})" class="btn btn-danger btn-sm">
                                    <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    <span>حذف</span>
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
                { key: 'phone', label: 'تماس مستقیم تلفنی', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>', color: '#34d399', count: a.phone || 0 },
                { key: 'eitaa', label: 'پیام‌رسان ایتا', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>', color: '#f59e0b', count: a.eitaa || 0 },
                { key: 'instagram', label: 'صفحه اینستاگرام', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>', color: '#ec4899', count: a.instagram || 0 },
                { key: 'bale', label: 'پیام‌رسان بله', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>', color: '#10b981', count: a.bale || 0 },
                { key: 'rubika', label: 'پیام‌رسان روبیکا', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>', color: '#6366f1', count: a.rubika || 0 },
                { key: 'maps', label: 'مسیریابی نقشه و بلد', iconSvg: '<svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>', color: '#38bdf8', count: a.maps || 0 }
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
                                <span style="display: inline-flex; align-items: center; color: ${ch.color};">${ch.iconSvg}</span>
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
                                    <svg class="admin-icon admin-icon-sm" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    <span>حذف مدیر</span>
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
                        <div style="margin-top: 0.75rem; padding: 0.65rem 1rem; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 4px; font-size: 0.775rem; color: #fbbf24; display: flex; align-items: center; gap: 0.4rem;">
                            <svg class="admin-icon admin-icon-sm" style="color: #fbbf24;" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <span>فقط ۱ مدیر در سیستم ثبت شده است. دکمه حذف جهت حفظ امنیت و جلوگیری از قفل شدن پنل، غیرفعال می‌باشد.</span>
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
                        const warningBanner = document.getElementById('securityWarningBanner');
                        if (warningBanner) {
                            warningBanner.style.transition = 'opacity 0.4s ease, max-height 0.4s ease, margin 0.4s ease, padding 0.4s ease';
                            warningBanner.style.opacity = '0';
                            warningBanner.style.maxHeight = '0';
                            warningBanner.style.overflow = 'hidden';
                            warningBanner.style.margin = '0';
                            warningBanner.style.padding = '0';
                            setTimeout(() => { warningBanner.remove(); }, 400);
                        }
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
