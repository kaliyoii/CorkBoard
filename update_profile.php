<?php
require_once __DIR__ . '/includes/object/login/auth_check.php';
require_once __DIR__ . '/includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validation
if (empty($username) || empty($email)) {
    $_SESSION['error'] = 'Username and email are required.';
    header('Location: profile.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    header('Location: profile.php');
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Check if username is already taken by another user
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? AND id != ?');
    $stmt->execute([$username, $user_id]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Username is already taken.';
        header('Location: profile.php');
        exit;
    }
    
    // Check if email is already taken by another user
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$email, $user_id]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Email is already taken.';
        header('Location: profile.php');
        exit;
    }
    
    // Update user profile
    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
    $stmt->execute([$username, $email, $user_id]);
    
    // Update session data
    $_SESSION['user_data']['username'] = $username;
    $_SESSION['user_data']['email'] = $email;
    
    $pdo->commit();
    
    $_SESSION['success'] = 'Profile updated successfully!';
    header('Location: profile.php');
    exit;
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = 'Failed to update profile. Please try again.';
    header('Location: profile.php');
    exit;
}
?>
