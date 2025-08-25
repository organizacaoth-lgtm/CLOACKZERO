<?php
require __DIR__ . '/../includes/bootstrap.php';

if (isset($_POST['user'], $_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hash = get_setting('admin_pass');
    if (!$hash) {
        $hash = password_hash('admin', PASSWORD_DEFAULT);
        set_setting('admin_pass', $hash);
    }
    if ($user === 'admin' && password_verify($pass, $hash)) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Login inválido';
    }
}
?>
<!doctype html>
<html>
<head><title>Login</title><link rel="stylesheet" href="/assets/style.css"></head>
<body>
<h1>Login</h1>
<?php if (!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
  <label>Usuário: <input type="text" name="user"></label><br>
  <label>Senha: <input type="password" name="pass"></label><br>
  <button type="submit">Entrar</button>
</form>
</body>
</html>
