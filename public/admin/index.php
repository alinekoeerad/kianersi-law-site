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

        .admin-icon {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
            stroke-width: 2;
            stroke: currentColor;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }
        .admin-icon-sm { width: 0.85rem; height: 0.85rem; }
        .admin-icon-lg { width: 1.35rem; height: 1.35rem; }

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
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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

        /* ─── Images & SEO Management Styles ─── */
        .seo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .image-card {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(14, 116, 144, 0.25);
            border-radius: 6px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: all 0.2s ease;
        }
        .image-card:hover {
            border-color: rgba(6, 182, 212, 0.45);
            box-shadow: 0 4px 20px rgba(6, 182, 212, 0.1);
        }
        .image-card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .image-preview-box {
            position: relative;
            width: 100%;
            height: 200px;
            background: #090d16;
            border: 1px dashed rgba(14, 116, 144, 0.35);
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.25s ease;
        }
        .image-preview-badge {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: rgba(6, 182, 212, 0.85);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }
        .image-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .image-actions .btn {
            flex: 1 1 calc(50% - 0.25rem);
        }
        .file-upload-input {
            display: none;
        }
        /* Google SERP Live Simulator */
        .google-serp-preview {
            background: #202124;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 1.25rem;
            font-family: Arial, sans-serif;
            text-align: right;
            direction: rtl;
            margin-top: 1rem;
        }
        .serp-url-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #bdc1c6;
            margin-bottom: 0.4rem;
        }
        .serp-url-row .serp-favicon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #303134;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }
        .serp-title {
            font-size: 1.15rem;
            font-weight: 400;
            color: #8ab4f8;
            margin-bottom: 0.35rem;
            line-height: 1.4;
            word-break: break-word;
            cursor: pointer;
        }
        .serp-title:hover {
            text-decoration: underline;
        }
        .serp-description {
            font-size: 0.875rem;
            color: #bdc1c6;
            line-height: 1.58;
            word-break: break-word;
        }
        .char-counter {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            display: flex;
            justify-content: space-between;
        }
        .char-counter.good {
            color: #10b981;
        }
        .char-counter.warn {
            color: #f59e0b;
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
            <div class="panel-card">
                <div class="card-header">
                    <h2 class="card-title">تنظیمات اصلی و اطلاعات تماس</h2>
                    <button onclick="saveGeneralData()" class="btn btn-success">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
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
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
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
                            <img id="lawyerImagePreview" src="./images/lawyer-portrait.webp" alt="پرتره وکیل">
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
                            <img id="logoImagePreview" src="./logo.webp" alt="لوگو دفتر">
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
                            <img id="seoImagePreview" src="./preview.webp" alt="پیش‌نمایش سئو">
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

            <!-- Part 2: SEO Meta Text & Google SERP Simulator -->
            <div class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">تنظیمات متنی متای سئو و موتورهای جستجو (Google SEO)</h2>
                        <p style="color: var(--text-muted); font-size: 0.825rem; margin-top: 0.25rem;">
                            مدیریت تایتل و توضیحات متای وب‌سایت برای افزایش رتبه در جستجوهای وکیل کرج، آب و دعاوی ملکی.
                        </p>
                    </div>
                    <button type="button" onclick="saveSeoData()" class="btn btn-success">
                        <svg class="admin-icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>ذخیره تنظیمات سئو</span>
                    </button>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">عنوان صفحه در گوگل و تب مرورگر (Meta Title):</label>
                        <input type="text" id="seoTitle" class="form-input" placeholder="محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک" oninput="updateGooglePreview()">
                        <div class="char-counter">
                            <span>پیشنهاد سئو: ۵۰ تا ۶۰ کاراکتر</span>
                            <span id="seoTitleCount">۰ کاراکتر</span>
                        </div>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">توضیحات متا برای موتورهای جستجو (Meta Description):</label>
                        <textarea id="seoDescription" class="form-textarea" rows="3" placeholder="دفتر وکالت تخصصی محمدحسن کیان‌ارثی، وکیل پایه یک دادگستری کرج. مشاوره تخصصی در دعاوی حفر چاه غیرمجاز، کمیسیون آب‌های زیرزمینی، حریم رودخانه و اراضی ملی البرز." oninput="updateGooglePreview()"></textarea>
                        <div class="char-counter" id="seoDescCounterBox">
                            <span>طول ایده‌آل گوگل: ۱۲۰ تا ۱۶۰ کاراکتر</span>
                            <span id="seoDescCount">۰ کاراکتر</span>
                        </div>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">کلمات کلیدی متا (Meta Keywords - جدا شده با کاما یا ویرگول):</label>
                        <textarea id="seoKeywords" class="form-textarea" rows="2" placeholder="وکیل کرج, وکیل آب, دعاوی چاه کشاورزی, حریم رودخانه, وکیل ملکی البرز, کمیسیون آبهای زیرزمینی, محمدحسن کیان ارثی"></textarea>
                    </div>
                </div>

                <!-- Live Google Search Result Preview (SERP Simulator) -->
                <div style="margin-top: 1.5rem;">
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg class="admin-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <span>پیش‌نمایش زنده در نتایج جستجوی گوگل (Google SERP Simulator):</span>
                    </label>
                    
                    <div class="google-serp-preview">
                        <div class="serp-url-row">
                            <span class="serp-favicon">
                                <svg class="admin-icon" style="width: 12px; height: 12px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            </span>
                            <span>https://vakilkianersi.ir</span>
                            <span style="color: #9aa0a6;">› دفتر-وکالت</span>
                        </div>
                        <div id="googlePreviewTitle" class="serp-title">محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک</div>
                        <div id="googlePreviewDesc" class="serp-description">دفتر وکالت تخصصی محمدحسن کیان‌ارثی، وکیل پایه یک دادگستری کرج. مشاوره تخصصی در دعاوی حفر چاه غیرمجاز، کمیسیون آب‌های زیرزمینی، حریم رودخانه و اراضی ملی البرز.</div>
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

            // Image Previews
            const cacheBuster = '?v=' + Date.now();
            if (document.getElementById('lawyerImagePreview')) {
                document.getElementById('lawyerImagePreview').src = (gen.lawyerImage || './images/lawyer-portrait.webp') + cacheBuster;
            }
            if (document.getElementById('logoImagePreview')) {
                document.getElementById('logoImagePreview').src = (gen.logoImage || './logo.webp') + cacheBuster;
            }
            if (document.getElementById('seoImagePreview')) {
                document.getElementById('seoImagePreview').src = (gen.seoImage || './preview.webp') + cacheBuster;
            }

            updateGooglePreview();
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
        function updateGooglePreview() {
            const titleEl = document.getElementById('seoTitle');
            const descEl = document.getElementById('seoDescription');
            const previewTitle = document.getElementById('googlePreviewTitle');
            const previewDesc = document.getElementById('googlePreviewDesc');
            const titleCount = document.getElementById('seoTitleCount');
            const descCount = document.getElementById('seoDescCount');
            const descBox = document.getElementById('seoDescCounterBox');

            if (!titleEl || !descEl) return;

            const titleVal = titleEl.value.trim() || 'محمدحسن کیان‌ارثی | وکیل پایه یک دادگستری کرج | متخصص دعاوی آب و املاک';
            const descVal = descEl.value.trim() || 'دفتر وکالت تخصصی محمدحسن کیان‌ارثی، وکیل پایه یک دادگستری کرج. مشاوره تخصصی در دعاوی حفر چاه غیرمجاز، کمیسیون آب‌های زیرزمینی، حریم رودخانه و اراضی ملی البرز.';

            if (previewTitle) previewTitle.textContent = titleVal;
            if (previewDesc) previewDesc.textContent = descVal;

            if (titleCount) titleCount.textContent = titleEl.value.length + ' کاراکتر';
            if (descCount) descCount.textContent = descEl.value.length + ' کاراکتر';

            if (descBox) {
                const len = descEl.value.length;
                if (len >= 120 && len <= 165) {
                    descBox.className = 'char-counter good';
                } else if (len > 0) {
                    descBox.className = 'char-counter warn';
                } else {
                    descBox.className = 'char-counter';
                }
            }
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
                            const img = document.getElementById(previewMap[type]);
                            if (img) img.src = result.url + '?t=' + Date.now();
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
                    const img = document.getElementById(previewMap[type]);
                    if (img) img.src = result.url + '?t=' + Date.now();
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
