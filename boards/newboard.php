<?php
require_once __DIR__ . '/../includes/object/login/auth_check.php';
require_once __DIR__ . '/../includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../home.php');
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
$title = trim($_POST['title'] ?? '');
$colorInput = trim($_POST['color'] ?? '');

if ($userId === null || $title === '' || $colorInput === '') {
    echo "<script>alert('Please provide all fields.');history.back();</script>";
    exit;
}

// Normalize and validate color; ensure it is a 6-digit hex with leading #
$color = $colorInput;
if ($color[0] !== '#') {
    $color = '#' . $color;
}
if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
    echo "<script>alert('Invalid color format.');history.back();</script>";
    exit;
}

// Constrain title length per DB schema (varchar(100))
if (mb_strlen($title) > 100) {
    echo "<script>alert('Title is too long (max 100 characters).');history.back();</script>";
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO boards (user_id, title, color, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$userId, $title, $color]);
} catch (Throwable $e) {
    echo "<script>alert('Failed to create board.');history.back();</script>";
    exit;
}

header('Location: ../home.php');
exit;
?>


