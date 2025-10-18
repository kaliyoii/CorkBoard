<?php
$host = 'localhost'; // atau 'localhost'
$dbname = 'corkboard'; // ganti dengan nama database kamu
$username = 'root'; // default XAMPP user
$password = 'root'; // default XAMPP password kosong

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
