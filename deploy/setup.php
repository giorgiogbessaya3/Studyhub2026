<?php
/**
 * SETUP STUDYHUB — copie les assets vers le webroot
 * URL : https://studyhub.novatechbenin.online/setup.php?token=studyhub2026deploy
 * À SUPPRIMER après exécution.
 */
set_time_limit(300);
ini_set('memory_limit', '256M');
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ── Sécurité ────────────────────────────────────────────────
if (($_GET['token'] ?? '') !== 'studyhub2026deploy') {
    http_response_code(403);
    die('403 Forbidden — ajouter ?token=studyhub2026deploy');
}

$webroot = __DIR__;
$source  = $webroot . '/Studyhub2026/public';

echo '<!DOCTYPE html><html><head><meta charset="UTF-8">
<style>body{font-family:monospace;padding:20px;background:#1e1e1e;color:#d4d4d4}
.ok{color:#4ec9b0}.err{color:#f44747}.warn{color:#dcdcaa}h2{color:#569cd6}</style></head><body>';

echo '<h2>🔍 Diagnostic</h2>';
echo '<p>__DIR__ = <code>' . $webroot . '</code></p>';
echo '<p>Source  = <code>' . $source  . '</code></p>';
echo '<p>PHP     = <code>' . PHP_VERSION . '</code></p>';
echo '<p>Source existe ? <span class="' . (is_dir($source) ? 'ok">✅ OUI' : 'err">❌ NON') . '</span></p>';
echo '<p>Source lisible ? <span class="' . (is_readable($source) ? 'ok">✅ OUI' : 'err">❌ NON') . '</span></p>';

if (!is_dir($source)) {
    echo '<p class="err">❌ Dossier Studyhub2026/public/ introuvable — vérifier le déploiement</p></body></html>';
    exit;
}

// ── Fonction copie récursive ─────────────────────────────────
function copyDir(string $src, string $dst): array
{
    $result = ['ok' => 0, 'err' => []];
    if (!is_dir($dst)) {
        if (!mkdir($dst, 0755, true)) {
            $result['err'][] = "mkdir échoué : $dst";
            return $result;
        }
    }
    foreach (scandir($src) as $item) {
        if ($item === '.' || $item === '..') continue;
        $s = "$src/$item";
        $d = "$dst/$item";
        if (is_dir($s)) {
            $sub = copyDir($s, $d);
            $result['ok']  += $sub['ok'];
            $result['err']  = array_merge($result['err'], $sub['err']);
        } else {
            if (copy($s, $d)) {
                $result['ok']++;
            } else {
                $result['err'][] = "copy échoué : $s → $d";
            }
        }
    }
    return $result;
}

// ── Copie dossiers ───────────────────────────────────────────
echo '<h2>📦 Copie des assets</h2>';

$dirs = ['img', 'assets', 'frontend', 'admin'];
foreach ($dirs as $dir) {
    $srcDir = "$source/$dir";
    $dstDir = "$webroot/$dir";
    if (!is_dir($srcDir)) {
        echo "<p class='warn'>⏭ $dir/ absent — ignoré</p>";
        continue;
    }
    $r = copyDir($srcDir, $dstDir);
    if (empty($r['err'])) {
        echo "<p class='ok'>✅ $dir/ — {$r['ok']} fichiers copiés</p>";
    } else {
        echo "<p class='err'>⚠️ $dir/ — {$r['ok']} copiés, " . count($r['err']) . " erreurs</p>";
        foreach ($r['err'] as $e) echo "<p class='err' style='margin-left:20px'>$e</p>";
    }
    flush();
    ob_flush();
}

// ── Copie fichiers individuels ───────────────────────────────
foreach (['favicon.ico', 'robots.txt'] as $file) {
    $s = "$source/$file";
    $d = "$webroot/$file";
    if (file_exists($s)) {
        echo copy($s, $d)
            ? "<p class='ok'>✅ $file copié</p>"
            : "<p class='err'>❌ $file — échec copy()</p>";
    }
}

// ── Storage (avatars) ────────────────────────────────────────
$storageSrc = "$webroot/Studyhub2026/storage/app/public";
$storageDst = "$webroot/storage";
if (is_dir($storageSrc) && count(scandir($storageSrc)) > 2) {
    $r = copyDir($storageSrc, $storageDst);
    echo "<p class='ok'>✅ storage/ — {$r['ok']} fichiers copiés</p>";
} else {
    echo "<p class='warn'>⏭ storage/app/public/ vide — ignoré</p>";
}

echo '<h2 class="ok">✅ Terminé</h2>';
echo '<p class="err" style="font-size:1.2em;font-weight:bold">
⛔ SUPPRIMEZ CE FICHIER MAINTENANT :<br>
<code>/htdocs/studyhub.novatechbenin.online/setup.php</code></p>';
echo '</body></html>';
