<?php
function get_db()
{
    static $db = null;
    if ($db) {
        return $db;
    }
    $path = __DIR__ . '/../storage/data.sqlite';
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0775, true);
    }
    $db = new PDO('sqlite:' . $path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec('CREATE TABLE IF NOT EXISTS blocked_ips (ip TEXT PRIMARY KEY)');
    $db->exec('CREATE TABLE IF NOT EXISTS allowed_ips (ip TEXT PRIMARY KEY)');
    $db->exec('CREATE TABLE IF NOT EXISTS visits (
        session_id TEXT PRIMARY KEY,
        ip TEXT,
        user_agent TEXT,
        last_page TEXT,
        last_activity INTEGER,
        human INTEGER DEFAULT 0
    )');
    $db->exec('CREATE TABLE IF NOT EXISTS events (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ip TEXT,
        page TEXT,
        ts INTEGER,
        action TEXT
    )');
    $db->exec('CREATE TABLE IF NOT EXISTS settings (
        key TEXT PRIMARY KEY,
        value TEXT
    )');

    return $db;
}
?>
