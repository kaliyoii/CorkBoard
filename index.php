<?php
// absolutely first line
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
else {
    header('Location: home.php');
    exit;
}
?>