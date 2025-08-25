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
    set_setting('redirect_schedule_enabled', isset($_POST['redirect_schedule_enabled']) ? '1' : '0');
    set_setting('redirect_schedule_url', $_POST['redirect_schedule_url'] ?? '');
    set_setting('redirect_schedule_start', $_POST['redirect_schedule_start'] ?? '');
    set_setting('redirect_schedule_end', $_POST['redirect_schedule_end'] ?? '');
    set_setting('redirect_refer_enabled', isset($_POST['redirect_refer_enabled']) ? '1' : '0');
    set_setting('redirect_refer_pattern', $_POST['redirect_refer_pattern'] ?? '');
    set_setting('redirect_refer_url', $_POST['redirect_refer_url'] ?? '');
    if (!empty($_POST['new_pass'])) {
        set_setting('admin_pass', password_hash($_POST['new_pass'], PASSWORD_DEFAULT));
    }
    $msg = 'Salvo!';
}
$home = get_setting('home', 'sites/home/index.php');
$blocked_redirect = get_setting('blocked_redirect', 'sites/blocked/index.php');
$redirect_schedule_enabled = get_setting('redirect_schedule_enabled', '0');
$redirect_schedule_url = get_setting('redirect_schedule_url', '');
$redirect_schedule_start = get_setting('redirect_schedule_start', '');
$redirect_schedule_end = get_setting('redirect_schedule_end', '');
$redirect_refer_enabled = get_setting('redirect_refer_enabled', '0');
$redirect_refer_pattern = get_setting('redirect_refer_pattern', '');
$redirect_refer_url = get_setting('redirect_refer_url', '');
?>
<!doctype html>
<html>
<head><title>Configurações</title><link rel="stylesheet" href="/assets/style.css"></head>
<body>
<h1>Configurações</h1>
<p><a href="index.php">Voltar</a></p>
<?php if (!empty($msg)) echo '<p style="color:green">'.$msg.'</p>'; ?>
<form method="post">
  <label>Home:
    <input type="text" name="home" value="<?=htmlspecialchars($home)?>">
  </label>
  <label>Destino bloqueado:
    <input type="text" name="blocked_redirect" value="<?=htmlspecialchars($blocked_redirect)?>">
  </label>
  <label><input type="checkbox" name="redirect_schedule_enabled" value="1" <?= $redirect_schedule_enabled?'checked':'' ?>> Ativar redirecionamento por horário</label>
  <div class="indent">
    <label>Início: <input type="time" name="redirect_schedule_start" value="<?=htmlspecialchars($redirect_schedule_start)?>"></label>
    <label>Fim: <input type="time" name="redirect_schedule_end" value="<?=htmlspecialchars($redirect_schedule_end)?>"></label>
    <label>URL destino: <input type="text" name="redirect_schedule_url" value="<?=htmlspecialchars($redirect_schedule_url)?>"></label>
  </div>
  <label><input type="checkbox" name="redirect_refer_enabled" value="1" <?= $redirect_refer_enabled?'checked':'' ?>> Ativar redirecionamento por referer</label>
  <div class="indent">
    <label>Referer contém: <input type="text" name="redirect_refer_pattern" value="<?=htmlspecialchars($redirect_refer_pattern)?>"></label>
    <label>URL destino: <input type="text" name="redirect_refer_url" value="<?=htmlspecialchars($redirect_refer_url)?>"></label>
  </div>
  <label>Nova senha:
    <input type="password" name="new_pass">
  </label>
  <button type="submit">Salvar</button>
</form>
</body>
</html>