<?php
// Aucune erreur PHP ne doit polluer les réponses binaires (images, CSS, JS)
error_reporting(0);
ini_set('display_errors', '0');

// Buffer tout — ob_end_clean() garantit une réponse propre avant readfile()
ob_start();

// ─────────────────────────────────────────────────────────────────────────────
// ÉTAPE 1 — Assets statiques depuis Studyhub2026/public/
// ─────────────────────────────────────────────────────────────────────────────
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));

// Sécurité : bloquer les tentatives de path traversal
if (strpos($uri, '..') !== false) {
    ob_end_clean();
    http_response_code(403);
    exit;
}

$staticFile = __DIR__ . '/Studyhub2026/public' . $uri;

if ($uri !== '/' && is_file($staticFile) && is_readable($staticFile)) {

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
        'xml'   => 'application/xml',
        'json'  => 'application/json',
        'txt'   => 'text/plain; charset=utf-8',
    ];

    if (isset($mimeTypes[$ext])) {
        ob_end_clean();       // Vide tout buffer avant les headers
        header_remove();      // Supprime tout header résiduel
        http_response_code(200);
        header('Content-Type: '   . $mimeTypes[$ext]);
        header('Content-Length: ' . filesize($staticFile));
        header('Cache-Control: public, max-age=31536000, immutable');
        header('X-Content-Type-Options: nosniff');
        readfile($staticFile);
        exit(0);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// ÉTAPE 2 — Bootstrap Laravel
// ─────────────────────────────────────────────────────────────────────────────
ob_end_clean();

define('LARAVEL_START', microtime(true));

require __DIR__ . '/Studyhub2026/vendor/autoload.php';

$app = require_once __DIR__ . '/Studyhub2026/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
