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

    $now = date('H:i');
    if (get_setting('redirect_schedule_enabled', '0') && ($url = get_setting('redirect_schedule_url'))) {
        $start = get_setting('redirect_schedule_start', '00:00');
        $end   = get_setting('redirect_schedule_end', '00:00');
        $inWindow = ($start <= $end) ? ($now >= $start && $now <= $end)
                                     : ($now >= $start || $now <= $end);
        if ($inWindow) {
            header('Location: ' . $url);
            exit;
        }
    }

    if (get_setting('redirect_refer_enabled', '0') && ($pattern = get_setting('redirect_refer_pattern'))) {
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer && stripos($referer, $pattern) !== false) {
            $url = get_setting('redirect_refer_url');
            if ($url) {
                header('Location: ' . $url);
                exit;
            }
        }
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