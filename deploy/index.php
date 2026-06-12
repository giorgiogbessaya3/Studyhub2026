<?php

// ─────────────────────────────────────────────────────────────────────────────
// ÉTAPE 1 — Servir les assets statiques depuis Studyhub2026/public/
// PHP les lit et les envoie directement, sans passer par Laravel ni .htaccess
// ─────────────────────────────────────────────────────────────────────────────
$uri        = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$staticFile = __DIR__ . '/Studyhub2026/public' . $uri;

if ($uri !== '/' && is_file($staticFile)) {

    $ext = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));

    $mimeTypes = [
        // Images
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'webp'  => 'image/webp',
        // Styles & scripts
        'css'   => 'text/css; charset=utf-8',
        'js'    => 'application/javascript; charset=utf-8',
        'map'   => 'application/json',
        // Polices
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        // Divers
        'pdf'   => 'application/pdf',
        'txt'   => 'text/plain',
        'xml'   => 'application/xml',
        'json'  => 'application/json',
    ];

    if (isset($mimeTypes[$ext])) {
        http_response_code(200);
        header('Content-Type: '  . $mimeTypes[$ext]);
        header('Content-Length: ' . filesize($staticFile));
        header('Cache-Control: public, max-age=31536000, immutable');
        header('X-Content-Type-Options: nosniff');
        readfile($staticFile);
        exit;
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// ÉTAPE 2 — Bootstrapper Laravel
// ─────────────────────────────────────────────────────────────────────────────
define('LARAVEL_START', microtime(true));

require __DIR__ . '/Studyhub2026/vendor/autoload.php';

$app = require_once __DIR__ . '/Studyhub2026/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
