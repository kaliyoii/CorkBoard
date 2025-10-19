<?php
// absolutely first line
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: ../../signin.php');
    exit;
}

// Fetch user data if not already loaded
if (!isset($_SESSION['user_data'])) {
    require_once __DIR__ . '/../koneksi.php';
    
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user_data'] = $user;
    } else {
        // User not found, logout
        session_destroy();
        header('Location: ../../signin.php');
        exit;
    }
}

// Make user data easily accessible
$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_data']['username'];
$user_email = $_SESSION['user_data']['email'];
?>