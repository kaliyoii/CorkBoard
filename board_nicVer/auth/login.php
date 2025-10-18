<?php
// auth/login.php
require_once __DIR__ . '/../includes/functions.php';
if (isset($_SESSION['user_id'])) {
    header('Location: /CorkBoard/boards/boards.php'); exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = sanitize($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $error = "Missing fields.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: /CorkBoard/boards/boards.php');
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head><body>
<h2>Login</h2>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
<form method="post">
  <input name="login" placeholder="Username or Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>
<p><a href="register.php">Create an account</a></p>
</body></html>
