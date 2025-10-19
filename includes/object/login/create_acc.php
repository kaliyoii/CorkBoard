<?php
require_once __DIR__ . '/../koneksi.php'; // make sure this connects to your DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        die("<script>alert('All fields are required!');history.back();</script>");
    }

    // Check if email or username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->fetch()) {
        die("<script>alert('Email or username already exists!');history.back();</script>");
    }

    // Hash password securely
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash, created_at, is_admin)
        VALUES (?, ?, ?, NOW(), 0)
    ");
    if ($stmt->execute([$username, $email, $hashed])) {
        echo "<script>alert('Account created successfully! Please log in.');window.location.href='../../../signin.php';</script>";
    } else {
        echo "<script>alert('Error creating account. Please try again.');history.back();</script>";
    }
} else {
    header('Location: ../../signup.php');
    exit;
}
?>
