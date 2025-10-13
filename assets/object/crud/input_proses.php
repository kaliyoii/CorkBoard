<?php
// koneksi database
include '../koneksi.php'; // pastikan $koneksi = mysqli connection

// menangkap data yang dikirim dari form
$title     = $_POST['title'];
$content   = $_POST['content'];
$color     = $_POST['color'];
$pin_color = $_POST['pin_color'];
$timestamp = $_POST['timestamp'] ?? ($_POST['timestasmp']); // perbaiki typo lama
$type      = $_POST['type'];
$img       = $_POST['img'];
$x         = isset($_POST['x']) ? (int)$_POST['x'] : 0;
$y         = isset($_POST['y']) ? (int)$_POST['y'] : 0;
$w         = isset($_POST['w']) ? (int)$_POST['w'] : 0;
$h         = isset($_POST['h']) ? (int)$_POST['h'] : 0;

// masukkan data ke database
$query = "
INSERT INTO `notes`
(`id`, `user_id`, `title`, `content`, `color`, `pin_color`, `timestamp`, `type`, `img`, `x`, `y`, `w`, `h`)
VALUES
(NULL, '$user_id', '$title', '$content', '$color', '$pin_color', '$timestamp', '$type', '$img', '$x', '$y', '$w', '$h')
";

if (mysqli_query($koneksi, $query)) {
    // jika berhasil
    header("Location: index.php");
    exit;
} else {
    // jika gagal
    echo "Error: " . mysqli_error($koneksi);
    header("Location: index.php?koneksi gagal");
}
?>
