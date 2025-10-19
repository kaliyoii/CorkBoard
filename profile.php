<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="home">
    <a href="home.php" class="home-button"><ion-icon name="home-outline"></ion-icon> Home</a>

    <form action="/php/updateprofile.php" class="main prof">
        <h2>Edit profile</h2>
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
            <button type="submit">Save</button>
        </div>
    </form>

    <form action="/php/updateprofile.php" class="main prof">
        <h2>Edit password</h2>
        <div>
            <div class="password-field">
                <input type="password" required placeholder="Previous password" name="password" id="password">
                <button type="button" id="eye">
                    <ion-icon id="hide" name="eye-off-outline"></ion-icon>
                    <ion-icon id="show" style="display: none;" name="eye-outline"></ion-icon>
                </button> 
            </div>
            <div class="password-field">
                <input type="password" required placeholder="New password" name="password" id="password">
                <button type="button" id="eye">
                    <ion-icon id="hide" name="eye-off-outline"></ion-icon>
                    <ion-icon id="show" style="display: none;" name="eye-outline"></ion-icon>
                </button> 
            </div>
            <button type="submit">Save</button>
        </div>
    </form>

    <a href="logout.php" class="logout"><ion-icon name="log-out-outline"></ion-icon> Log out</a>

    <div class="footer">
        <p>&copy;<?=date('Y')?> - KALIYOII & FLUNCKS</p>
    </div>
    <script src="assets/js/home.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>