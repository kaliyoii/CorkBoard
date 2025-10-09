<?php
// FIRST LINE, no whitespace before
session_start();
include '../koneksi.php';

// validate input
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// TODO: use password_hash in real apps. This is demo-only.
$sql = "SELECT id, username FROM user WHERE username=? AND password=?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if ($user) {
    // IMPORTANT: set session BEFORE redirect
    $_SESSION['user_id']  = (int)$user['id'];
    $_SESSION['username'] = $user['username'];

    // (Optional) harden session
    session_regenerate_id(true);

    header("Location: ../crud/view.php");
    exit;
} else {
    // bad creds
    header("Location: /login.php?err=1");
    exit;
}
