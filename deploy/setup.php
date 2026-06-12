<?php
/**
 * SCRIPT DE DÉPLOIEMENT STUDYHUB
 * ────────────────────────────────────────────────────────────
 * 1. Copier ce fichier dans le webroot :
 *    /htdocs/studyhub.novatechbenin.online/setup.php
 * 2. Visiter : https://studyhub.novatechbenin.online/setup.php
 * 3. SUPPRIMER ce fichier après exécution (risque de sécurité)
 * ────────────────────────────────────────────────────────────
 */

// Sécurité basique : token d'accès
define('TOKEN', 'studyhub2026deploy');
if (($_GET['token'] ?? '') !== TOKEN) {
    http_response_code(403);
    die('<h2>Accès refusé.</h2><p>Ajouter <code>?token=studyhub2026deploy</code> à l\'URL.</p>');
}

$webroot = __DIR__;
$source  = $webroot . '/Studyhub2026/public';
$errors  = [];
$success = [];

// ── Vérification préalable ──────────────────────────────────
if (!is_dir($source)) {
    die("<h2>❌ Dossier source introuvable :</h2><pre>$source</pre>");
}

// ── Fonction de copie récursive ─────────────────────────────
function copyDir(string $src, string $dst, array &$errors, array &$success): void
{
    if (!is_dir($dst) && !mkdir($dst, 0755, true)) {
        $errors[] = "Impossible de créer : $dst";
        return;
    }
    $items = scandir($src);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $s = "$src/$item";
        $d = "$dst/$item";
        if (is_dir($s)) {
            copyDir($s, $d, $errors, $success);
        } else {
            if (copy($s, $d)) {
                $success[] = str_replace(dirname($dst) . '/', '', $d);
            } else {
                $errors[] = "Échec copie : $s";
            }
        }
    }
}

// ── Copie des dossiers d'assets ─────────────────────────────
$dirs = ['img', 'assets', 'frontend', 'admin'];
foreach ($dirs as $dir) {
    $srcDir = "$source/$dir";
    $dstDir = "$webroot/$dir";
    if (is_dir($srcDir)) {
        copyDir($srcDir, $dstDir, $errors, $success);
        echo "<p>✅ <strong>$dir/</strong> copié (" . count(glob("$dstDir/*")) . " éléments)</p>";
    } else {
        echo "<p>⏭ <em>$dir/</em> absent dans public/ — ignoré</p>";
    }
}

// ── Copie des fichiers individuels ──────────────────────────
$files = ['favicon.ico', 'robots.txt'];
foreach ($files as $file) {
    $srcFile = "$source/$file";
    $dstFile = "$webroot/$file";
    if (file_exists($srcFile)) {
        if (copy($srcFile, $dstFile)) {
            echo "<p>✅ <strong>$file</strong> copié</p>";
        } else {
            $errors[] = "Échec copie : $file";
        }
    }
}

// ── Copie du storage (avatars uploadés) ─────────────────────
$storageSrc = "$webroot/Studyhub2026/storage/app/public";
$storageDst = "$webroot/storage";
if (is_dir($storageSrc)) {
    copyDir($storageSrc, $storageDst, $errors, $success);
    echo "<p>✅ <strong>storage/</strong> (avatars) copié</p>";
} else {
    echo "<p>⏭ <em>storage/app/public/</em> vide ou absent — ignoré</p>";
}

// ── Résumé ──────────────────────────────────────────────────
echo "<hr>";
echo "<p>📦 <strong>" . count($success) . " fichiers copiés</strong></p>";

if (!empty($errors)) {
    echo "<h3>⚠️ Erreurs (" . count($errors) . ")</h3><ul>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul>";
} else {
    echo "<p>✅ Aucune erreur.</p>";
}

echo "<hr><p style='color:red;font-weight:bold'>⛔ SUPPRIMEZ CE FICHIER MAINTENANT : /setup.php</p>";
