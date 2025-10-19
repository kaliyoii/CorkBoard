<?php
require_once __DIR__ . '/includes/object/login/auth_check.php';
require_once __DIR__ . '/includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit;
}

$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $_SESSION['error'] = 'All password fields are required.';
    header('Location: profile.php');
    exit;
}

if ($new_password !== $confirm_password) {
    $_SESSION['error'] = 'New passwords do not match.';
    header('Location: profile.php');
    exit;
}

if (strlen($new_password) < 6) {
    $_SESSION['error'] = 'New password must be at least 6 characters long.';
    header('Location: profile.php');
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Get current password hash
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $_SESSION['error'] = 'User not found.';
        header('Location: profile.php');
        exit;
    }
    
    // Verify current password
    if (!password_verify($current_password, $user['password_hash'])) {
        $_SESSION['error'] = 'Current password is incorrect.';
        header('Location: profile.php');
        exit;
    }
    
    // Hash new password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password
    $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $stmt->execute([$new_password_hash, $user_id]);
    
    $pdo->commit();
    
    $_SESSION['success'] = 'Password changed successfully!';
    header('Location: profile.php');
    exit;
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = 'Failed to change password. Please try again.';
    header('Location: profile.php');
    exit;
}
?>
