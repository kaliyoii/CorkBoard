<?php
require_once __DIR__ . '/../koneksi.php'; // adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("<script>alert('Please fill in all fields.');history.back();</script>");
    }

    // Prepare statement using PDO
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];

        echo "<script>alert('Login successful!');window.location.href='../../../home.php';</script>";
    } else {
        echo "<script>alert('Invalid email or password.');history.back();</script>";
    }
} else {
    header('Location: ../../signin.php');
    exit;
}
?>
