<?php
$host = '127.0.0.1';
$dbname = 'cork_board';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
} else {
    echo "✅ Connected to MySQL successfully!";
}

mysqli_close($conn);
?>
