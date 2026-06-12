<?php
// FICHIER DE DIAGNOSTIC — À SUPPRIMER APRÈS UTILISATION
// Accès : https://studyhub.novatechbenin.online/debug-asset.php

$file = __DIR__ . '/Studyhub2026/public/img/car1.png';

echo "=== DIAGNOSTIC ASSET ===\n\n";
echo "__DIR__        : " . __DIR__ . "\n";
echo "Chemin testé   : $file\n";
echo "file_exists()  : " . (file_exists($file) ? 'OUI ✅' : 'NON ❌') . "\n";
echo "is_file()      : " . (is_file($file)     ? 'OUI ✅' : 'NON ❌') . "\n";
echo "is_readable()  : " . (is_readable($file) ? 'OUI ✅' : 'NON ❌') . "\n";
echo "filesize()     : " . (file_exists($file) ? filesize($file) . ' octets' : 'N/A') . "\n";
echo "PHP version    : " . PHP_VERSION . "\n";
echo "REQUEST_URI    : " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
