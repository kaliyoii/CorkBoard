<?php
// auth/register.php
require_once __DIR__ . '/../includes/functions.php';
if (isset($_SESSION['user_id'])) {
    header('Location: /CorkBoard/boards/boards.php'); exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = "All fields required.";
    } else {
        // check duplicates
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            $_SESSION['user_id'] = (int)$pdo->lastInsertId();
            $_SESSION['username'] = $username;
            header('Location: /CorkBoard/boards/boards.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title></head><body>
<h2>Register</h2>
<?php foreach ($errors as $e): ?><p style="color:red;"><?= $e ?></p><?php endforeach; ?>
<form method="post">
  <input name="username" placeholder="Username" required>
  <input name="email" type="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button type="submit">Register</button>
</form>
<p><a href="login.php">Already have an account? Login</a></p>
</body></html>
