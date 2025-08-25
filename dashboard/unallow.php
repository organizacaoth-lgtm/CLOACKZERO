<?php
require __DIR__ . '/../includes/bootstrap.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
$ip = $_POST['ip'] ?? '';
if ($ip) {
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM allowed_ips WHERE ip = ?');
    $stmt->execute([$ip]);
    log_event($ip, '', 'unallow');
}
header('Location: index.php');
exit;
?>
