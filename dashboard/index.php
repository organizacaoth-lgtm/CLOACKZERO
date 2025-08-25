<?php
require __DIR__ . '/../includes/bootstrap.php';
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$db = get_db();
$visStmt = $db->prepare('SELECT ip, last_page, last_activity FROM visits WHERE last_activity > ?');
$visStmt->execute([time() - 300]);
$visitors = $visStmt->fetchAll(PDO::FETCH_ASSOC);
$blocked = $db->query('SELECT ip FROM blocked_ips')->fetchAll(PDO::FETCH_ASSOC);
$allowed = $db->query('SELECT ip FROM allowed_ips')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head><title>Dashboard</title><link rel="stylesheet" href="/assets/style.css"></head>
<body>
<h1>Dashboard</h1>
<p><a href="logout.php">Logout</a> | <a href="settings.php">Configurações</a></p>
<h2>Visitantes Online</h2>
<table>
<tr><th>IP</th><th>Última Página</th><th>Última Atividade</th></tr>
<?php foreach ($visitors as $v): ?>
<tr><td><?=htmlspecialchars($v['ip'])?></td><td><?=htmlspecialchars($v['last_page'])?></td><td><?=date('H:i:s', $v['last_activity'])?></td></tr>
<?php endforeach; ?>
</table>

<h2>Bloquear IP</h2>
<form method="post" action="block.php">
  <input name="ip" placeholder="IP" required>
  <button type="submit">Bloquear</button>
</form>
<ul>
<?php foreach ($blocked as $b): ?>
<li><?=htmlspecialchars($b['ip'])?> <form style="display:inline" method="post" action="unblock.php"><input type="hidden" name="ip" value="<?=htmlspecialchars($b['ip'])?>"><button>Desbloquear</button></form></li>
<?php endforeach; ?>
</ul>

<h2>Autorizar IP</h2>
<form method="post" action="allow.php">
  <input name="ip" placeholder="IP" required>
  <button type="submit">Autorizar</button>
</form>
<ul>
<?php foreach ($allowed as $a): ?>
<li><?=htmlspecialchars($a['ip'])?> <form style="display:inline" method="post" action="unallow.php"><input type="hidden" name="ip" value="<?=htmlspecialchars($a['ip'])?>"><button>Remover</button></form></li>
<?php endforeach; ?>
</ul>
</body>
</html>
