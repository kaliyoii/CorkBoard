<?php
include '../login/auth_check.php';  // this starts the session & checks login
include '../koneksi.php';           // mysqli connection in $koneksi

// Ambil data dari POST
$id        = (int) $_POST['id'];
$title     = $_POST['title']     ?? null;
$content   = $_POST['content']   ?? null;
$color     = $_POST['color']     ?? null;
$pin_color = $_POST['pin_color'] ?? null;
$timestamp = $_POST['timestamp'] ?? ($_POST['timestasmp'] ?? null);
$type      = $_POST['type']      ?? null;
$img       = $_POST['img']       ?? null;
$x         = isset($_POST['x']) ? (int)$_POST['x'] : null;
$y         = isset($_POST['y']) ? (int)$_POST['y'] : null;
$w         = isset($_POST['w']) ? (int)$_POST['w'] : null;
$h         = isset($_POST['h']) ? (int)$_POST['h'] : null;

// Ambil ID user yang login dari session
$user_id = $_SESSION['user_id'];

if ($id <= 0 || !$user_id) {
    http_response_code(400);
    exit('Invalid ID or user not logged in');
}

// Buat query UPDATE
$sql = "UPDATE `notes`
        SET 
            `user_id` = '$user_id',
            `title` = '$title',
            `content` = '$content',
            `color` = '$color',
            `pin_color` = '$pin_color',
            `timestamp` = '$timestamp',
            `type` = '$type',
            `img` = '$img',
            `x` = '$x',
            `y` = '$y',
            `w` = '$w',
            `h` = '$h'
        WHERE `id` = '$id'";

// Jalankan query
if (mysqli_query($koneksi, $sql)) {
    header("Location: view.php");
    exit;
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
