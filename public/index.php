<?php
// Root index.php - Dynamic SEO & Instant Client Hydration for Crawlers (Telegram, WhatsApp, Google)
$base_dir = __DIR__;
$html_file = $base_dir . '/index.html';
$data_file = $base_dir . '/site-data.json';

if (!file_exists($html_file)) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><body><h1>Error: index.html not found</h1></body></html>';
    exit;
}

$html = file_get_contents($html_file);
$siteData = file_exists($data_file) ? json_decode(@file_get_contents($data_file), true) : null;

if ($siteData && isset($siteData['general'])) {
    $gen = $siteData['general'];

    $title = $gen['seoTitle'] ?? '';
    $desc = $gen['seoDescription'] ?? '';
    $keywords = $gen['seoKeywords'] ?? '';
    $raw_image = !empty($gen['seoImage']) ? $gen['seoImage'] : (!empty($gen['lawyerImage']) ? $gen['lawyerImage'] : './preview.webp');

    // Build absolute URL for crawlers
    $clean_image = ltrim(preg_replace('/^\.\//', '', $raw_image), '/');
    if (!preg_match('/^https?:\/\//i', $clean_image)) {
        $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                    (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
                    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $scheme = $is_https ? 'https' : 'https';
        $host = $_SERVER['HTTP_HOST'] ?? 'vakilkianersi.ir';
        $image_url = $scheme . '://' . $host . '/' . $clean_image;
    } else {
        $image_url = $clean_image;
    }

    // Cache-busting query string based on disk file modification time
    $disk_file = $base_dir . '/' . $clean_image;
    $v = file_exists($disk_file) ? filemtime($disk_file) : time();
    $image_url_versioned = $image_url . (strpos($image_url, '?') === false ? '?v=' . $v : '');

    if (!empty($title)) {
        $esc_title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/<title>[\s\S]*?<\/title>/i', '<title>' . $esc_title . '</title>', $html);
        $html = preg_replace('/<meta\s+property=["\']og:title["\']\s+content=["\'][^"\']*["\']/i', '<meta property="og:title" content="' . $esc_title . '"', $html);
        $html = preg_replace('/<meta\s+name=["\']twitter:title["\']\s+content=["\'][^"\']*["\']/i', '<meta name="twitter:title" content="' . $esc_title . '"', $html);
    }

    if (!empty($desc)) {
        $esc_desc = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/<meta\s+name=["\']description["\']\s+content=["\'][^"\']*["\']/i', '<meta name="description" content="' . $esc_desc . '"', $html);
        $html = preg_replace('/<meta\s+property=["\']og:description["\']\s+content=["\'][^"\']*["\']/i', '<meta property="og:description" content="' . $esc_desc . '"', $html);
        $html = preg_replace('/<meta\s+name=["\']twitter:description["\']\s+content=["\'][^"\']*["\']/i', '<meta name="twitter:description" content="' . $esc_desc . '"', $html);
    }

    if (!empty($keywords)) {
        $esc_kw = htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/<meta\s+name=["\']keywords["\']\s+content=["\'][^"\']*["\']/i', '<meta name="keywords" content="' . $esc_kw . '"', $html);
    }

    if (!empty($image_url)) {
        $esc_img = htmlspecialchars($image_url_versioned, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/<meta\s+property=["\']og:image["\']\s+content=["\'][^"\']*["\']/i', '<meta property="og:image" content="' . $esc_img . '"', $html);
        $html = preg_replace('/<meta\s+name=["\']twitter:image["\']\s+content=["\'][^"\']*["\']/i', '<meta name="twitter:image" content="' . $esc_img . '"', $html);
    }

    // Dynamically update the LCP preload image tag to match the active lawyer portrait
    $lawyer_img = $gen['lawyerImage'] ?? './images/lawyer-portrait.webp';
    if (!empty($lawyer_img)) {
        $clean_lawyer = htmlspecialchars($lawyer_img, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/<link\s+rel=["\']preload["\']\s+as=["\']image["\']\s+href=["\'][^"\']*["\']/i', '<link rel="preload" as="image" href="' . $clean_lawyer . '"', $html);
    }

    // Embed initial data synchronously into window.__INITIAL_SITE_DATA__
    // This guarantees 0ms instantaneous client mount with NO image flickering
    $initial_script = '<script>window.__INITIAL_SITE_DATA__ = ' . json_encode($siteData, JSON_UNESCAPED_UNICODE) . ';</script>';
    if (strpos($html, '</head>') !== false) {
        $html = str_replace('</head>', "    " . $initial_script . "\n  </head>", $html);
    }
}

// Headers
@header('Content-Type: text/html; charset=utf-8');
@header('Cache-Control: public, max-age=60');
echo $html;

