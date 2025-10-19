<?php
require_once __DIR__ . '/includes/object/login/guest_only.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Sign in</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Cork Board</h1>
    <form action="includes/object/login/ceklogin.php" method="POST" class="main">
        <h2>Sign in</h2>
        <div>
            <input type="text" required placeholder="email" name="email" id="email">
            <div class="password-field">
                <input type="password" required placeholder="Password" name="password" id="password">
                <button type="button" id="eye">
                    <ion-icon id="hide" name="eye-off-outline"></ion-icon>
                    <ion-icon id="show" style="display: none;" name="eye-outline"></ion-icon>
                </button> 
            </div>
            <button type="submit">Sign in</button>
        </div>
    <a href="signup.php">Don't have an account?</a>
    </form>
    <div class="footer">
        <p>&copy;<?=date('Y')?> - KALIYOII & FLUNCKS</p>
    </div>
    <script src="assets/js/signup.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>