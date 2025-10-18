<?php
// auth/delete_account.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <!doctype html><html><body>
    <h2>Delete Account</h2>
    <p>This action can not be undone. Please enter your username below to confirm with account deletion:</p>
    <form method="post">
      <input name="confirm_username" placeholder="Your username" required>
      <button type="submit">Delete account</button>
    </form>
    <p><a href="/CorkBoard/boards/boards.php">Back</a></p>
    </body></html>
    <?php
    exit;
}

$confirm = sanitize($_POST['confirm_username'] ?? '');
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$uid]);
$user = $stmt->fetch();
if (!$user) { echo "user not found"; exit; }
if ($confirm !== $user['username']) {
    echo "username mismatch"; exit;
}

// delete user -> cascades
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$uid]);

$_SESSION = [];
session_destroy();

echo "Account deleted. <a href='/CorkBoard/auth/register.php'>Register</a>";
exit;
