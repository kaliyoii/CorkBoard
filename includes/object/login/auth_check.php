<?php
session_start();

// BASE_URL otomatis sesuai host + port container
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST']; // auto: localhost:8080, localhost:80, domain.com
$basePath = '/cork/'; // sesuaikan folder projek kamu
define('BASE_URL', $protocol . $host . $basePath);

// Jika belum login, redirect
if (empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'signin.php');
    exit;
}

// Ambil user jika belum ada
if (!isset($_SESSION['user_data'])) {
    require_once __DIR__ . '/../koneksi.php';
    
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user_data'] = $user;
    } else {
        session_destroy();
        header('Location: ' . BASE_URL . 'signin.php');
        exit;
    }
}

// Akses mudah
$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_data']['username'];
$user_email = $_SESSION['user_data']['email'];
?>
