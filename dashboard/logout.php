<?php
require __DIR__ . '/../includes/bootstrap.php';
unset($_SESSION['admin']);
header('Location: login.php');
exit;
?>
