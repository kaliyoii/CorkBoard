<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Sign up</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Cork Board</h1>
    <form action="/php/signincheck.php" class="main">
        <h2>Sign up</h2>
        <div>
            <input type="text" required placeholder="Username" name="username" id="username">
            <input type="email" required placeholder="Email address" name="email" id="email">
            <div class="password-field">
                <input type="password" required placeholder="Password" name="password" id="password">
                <button type="button" id="eye">
                    <ion-icon id="hide" name="eye-off-outline"></ion-icon>
                    <ion-icon id="show" style="display: none;" name="eye-outline"></ion-icon>
                </button> 
            </div>
            <button type="submit">Sign up</button>
        </div>
    <a href="signin.php">Already have an account?</a>
    </form>
    <div class="footer">
        <p>&copy;<?=date('Y')?> - KALIYOII & FLUNCKS</p>
    </div>
    <script src="assets/js/signup.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>