<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/guard.php';

$requested = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requested = ltrim($requested, '/');

$home = get_setting('home', 'sites/home/index.php');
$homeDir = realpath(__DIR__ . '/' . dirname($home));
$target = realpath($homeDir . '/' . $requested);

if ($target === false || strpos($target, $homeDir) !== 0 || !is_file($target)) {
    $target = __DIR__ . '/' . $home;
    $requested = basename($home);
}

run_guard($requested);

ob_start();
include $target;
$content = ob_get_clean();
if (stripos($content, '</body>') !== false) {
    $content = str_ireplace('</body>', "<script src='/assets/heartbeat.js'></script></body>", $content);
} else {
    $content .= "<script src='/assets/heartbeat.js'></script>";
}

echo $content;
?>
