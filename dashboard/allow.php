<?php
require __DIR__ . '/../includes/bootstrap.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
$ip = $_POST['ip'] ?? '';
if ($ip) {
    $db = get_db();
    $stmt = $db->prepare('REPLACE INTO allowed_ips (ip) VALUES (?)');
    $stmt->execute([$ip]);
    log_event($ip, '', 'allow');
}
header('Location: index.php');
exit;
?>
