<?php
require_once __DIR__ . '/functions.php';

function run_guard($requested)
{
    $ip = get_ip();

    if (is_blocked($ip)) {
        $dest = get_setting('blocked_redirect', 'sites/blocked/index.php');
        if (filter_var($dest, FILTER_VALIDATE_URL)) {
            header('Location: ' . $dest);
        } else {
            include __DIR__ . '/../' . ltrim($dest, '/');
        }
        log_event($ip, $requested, 'blocked');
        exit;
    }

    if (!is_allowed($ip) && empty($_SESSION['human'])) {
        header('Content-Type: text/html; charset=utf-8');
        echo "<!doctype html><html><head><title>Verificação</title></head><body><p>Verificando...</p><script src='/assets/human.js'></script></body></html>";
        log_event($ip, $requested, 'verify');
        exit;
    }

    update_visit($ip, $requested, !empty($_SESSION['human']));
}
?>
