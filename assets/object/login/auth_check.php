<?php
// absolutely first line
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: ../login/login.php"); // use absolute path to avoid weird relatives
    exit;
}
?>