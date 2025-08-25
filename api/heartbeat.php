<?php
require __DIR__ . '/../includes/bootstrap.php';
$ip = get_ip();
$page = $_GET['page'] ?? '';
update_visit($ip, $page, !empty($_SESSION['human']));
echo 'ok';
?>
