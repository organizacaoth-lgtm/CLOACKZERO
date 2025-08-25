<?php
require __DIR__ . '/../includes/bootstrap.php';
$_SESSION['human'] = true;
$ip = get_ip();
$page = $_GET['page'] ?? '';
update_visit($ip, $page, true);
echo 'ok';
?>
