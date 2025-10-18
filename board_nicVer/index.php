<?php
// index.php - landing page: redirect to boards or login
require_once __DIR__ . '/includes/functions.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /CorkBoard/boards/boards.php');
} else {
    header('Location: /CorkBoard/auth/login.php');
}
exit;
