<?php
require_once __DIR__ . '/includes/object/login/auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Edit profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/icon/favicon.png" type="image/x-icon">
</head>
<body class="home">
    <a href="home.php" class="home-button"><ion-icon name="home-outline"></ion-icon> Home</a>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div style="background: #4CAF50; color: white; padding: 10px; margin: 10px; border-radius: 5px;">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: #f44336; color: white; padding: 10px; margin: 10px; border-radius: 5px;">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="update_profile.php" method="POST" class="main prof">
        <h2>Edit profile</h2>
        <div>
            <input type="text" required placeholder="Username" name="username" id="username" value="<?= htmlspecialchars($username) ?>">
            <input type="email" required placeholder="Email address" name="email" id="email" value="<?= htmlspecialchars($user_email) ?>">
            <button type="submit">Save</button>
        </div>
    </form>

    <form action="change_password.php" method="POST" class="main prof">
        <h2>Change password</h2>
        <div>
            <div class="password-field">
                <input type="password" required placeholder="Current password" name="current_password" id="current_password">
                <button type="button" class="eye-btn" onclick="togglePassword('current_password')">
                    <ion-icon name="eye-off-outline"></ion-icon>
                </button> 
            </div>
            <div class="password-field">
                <input type="password" required placeholder="New password" name="new_password" id="new_password">
                <button type="button" class="eye-btn" onclick="togglePassword('new_password')">
                    <ion-icon name="eye-off-outline"></ion-icon>
                </button> 
            </div>
            <div class="password-field">
                <input type="password" required placeholder="Confirm new password" name="confirm_password" id="confirm_password">
                <button type="button" onclick="togglePassword('confirm_password')">
                    <ion-icon name="eye-off-outline"></ion-icon>
                </button> 
            </div>
            <button type="submit">Change Password</button>
        </div>
    </form>

    <a href="includes/object/login/logout.php" class="logout"><ion-icon name="log-out-outline"></ion-icon> Log out</a>

    <div class="footer">
        <p>&copy;<?=date('Y')?> - KALIYOII & FLUNCKS</p>
    </div>
    <script src="assets/js/home.js"></script>
    <script src="assets/js/pwswitch.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>