<?php
require_once __DIR__ . '/db.php';

function get_ip()
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function get_setting($key, $default = null)
{
    $db = get_db();
    $stmt = $db->prepare('SELECT value FROM settings WHERE key = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['value'] : $default;
}

function set_setting($key, $value)
{
    $db = get_db();
    $stmt = $db->prepare('REPLACE INTO settings (key, value) VALUES (?, ?)');
    $stmt->execute([$key, $value]);
}

function is_blocked($ip)
{
    $db = get_db();
    $stmt = $db->prepare('SELECT 1 FROM blocked_ips WHERE ip = ?');
    $stmt->execute([$ip]);
    return (bool)$stmt->fetchColumn();
}

function is_allowed($ip)
{
    $db = get_db();
    $stmt = $db->prepare('SELECT 1 FROM allowed_ips WHERE ip = ?');
    $stmt->execute([$ip]);
    return (bool)$stmt->fetchColumn();
}

function log_event($ip, $page, $action)
{
    $db = get_db();
    $stmt = $db->prepare('INSERT INTO events (ip, page, ts, action) VALUES (?, ?, ?, ?)');
    $stmt->execute([$ip, $page, time(), $action]);
}

function update_visit($ip, $page, $human)
{
    $db = get_db();
    $stmt = $db->prepare('REPLACE INTO visits (session_id, ip, user_agent, last_page, last_activity, human) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        session_id(),
        $ip,
        $_SERVER['HTTP_USER_AGENT'] ?? '',
        $page,
        time(),
        $human ? 1 : 0
    ]);
}
?>
