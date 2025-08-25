<?php
require __DIR__ . '/../includes/bootstrap.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['home'])) {
        set_setting('home', $_POST['home']);
    }
    if (isset($_POST['blocked_redirect'])) {
        set_setting('blocked_redirect', $_POST['blocked_redirect']);
    }
    if (!empty($_POST['new_pass'])) {
        set_setting('admin_pass', password_hash($_POST['new_pass'], PASSWORD_DEFAULT));
    }
    $msg = 'Salvo!';
}
$home = get_setting('home', 'sites/home/index.php');
$blocked_redirect = get_setting('blocked_redirect', 'sites/blocked/index.php');
?>
<!doctype html>
<html>
<head><title>Configurações</title><link rel="stylesheet" href="/assets/style.css"></head>
<body>
<h1>Configurações</h1>
<p><a href="index.php">Voltar</a></p>
<?php if (!empty($msg)) echo '<p style="color:green">'.$msg.'</p>'; ?>
<form method="post">
  <label>Home: <input type="text" name="home" value="<?=htmlspecialchars($home)?>"></label><br>
  <label>Destino bloqueado: <input type="text" name="blocked_redirect" value="<?=htmlspecialchars($blocked_redirect)?>"></label><br>
  <label>Nova senha: <input type="password" name="new_pass"></label><br>
  <button type="submit">Salvar</button>
</form>
</body>
</html>
