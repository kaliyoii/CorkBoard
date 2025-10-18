<?php
// auth/logout.php
require_once __DIR__ . '/../includes/functions.php';
$_SESSION = [];
session_destroy();
header('Location: /CorkBoard/auth/login.php');
exit;
