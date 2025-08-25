<?php
require __DIR__ . '/../includes/bootstrap.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
$ip = $_POST['ip'] ?? '';
if ($ip) {
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM blocked_ips WHERE ip = ?');
    $stmt->execute([$ip]);
    log_event($ip, '', 'unblock');
}
header('Location: index.php');
exit;
?>
