<?php
include '../login/auth_check.php'; // this file does session_start + redirect if not logged in

echo "Hello, " . htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Note</title>
</head>
<body>

  <h2>Edit Note</h2>
  <a href="index.php">KEMBALI</a>
  <br><br>

  <?php
  include '../koneksi.php';

  if (!isset($_GET['id'])) {
    echo "Missing id";
    exit;
  }

  $id = (int) $_GET['id'];
  $q  = mysqli_query($koneksi, "SELECT * FROM notes WHERE id = $id");
  if (!$q || mysqli_num_rows($q) === 0) {
    echo "Data tidak ditemukan";
    exit;
  }
  $d = mysqli_fetch_assoc($q);

  // helper kecil buat amanin output
  function e($v){ return htmlspecialchars((string)$v ?? '', ENT_QUOTES, 'UTF-8'); }
  ?>

  <form method="post" action="update_proses.php">
    <input type="hidden" name="id" value="<?= e($d['id']) ?>">

    <table cellpadding="6">
      <tr>
        <td>Title</td>
        <td><input type="text" name="title" value="<?= e($d['title']) ?>" required></td>
      </tr>
      <tr>
        <td>Content</td>
        <td><textarea name="content" rows="6" cols="50"><?= e($d['content']) ?></textarea></td>
      </tr>
      <tr>
        <td>Color</td>
        <td><input type="text" name="color" value="<?= e($d['color']) ?>"></td>
      </tr>
      <tr>
        <td>Pin Color</td>
        <td><input type="text" name="pin_color" value="<?= e($d['pin_color']) ?>"></td>
      </tr>
      <tr>
        <td>Timestamp</td>
        <td><input type="text" name="timestamp" value="<?= e($d['timestamp']) ?>"></td>
      </tr>
      <tr>
        <td>Type</td>
        <td><input type="text" name="type" value="<?= e($d['type']) ?>"></td>
      </tr>
      <tr>
        <td>Img</td>
        <td><input type="text" name="img" value="<?= e($d['img']) ?>"></td>
      </tr>
      <tr>
        <td>X</td>
        <td><input type="number" name="x" value="<?= e($d['x']) ?>"></td>
      </tr>
      <tr>
        <td>Y</td>
        <td><input type="number" name="y" value="<?= e($d['y']) ?>"></td>
      </tr>
      <tr>
        <td>W</td>
        <td><input type="number" name="w" value="<?= e($d['w']) ?>"></td>
      </tr>
      <tr>
        <td>H</td>
        <td><input type="number" name="h" value="<?= e($d['h']) ?>"></td>
      </tr>
      <tr>
        <td></td>
        <td><button type="submit">SIMPAN</button></td>
      </tr>
    </table>
  </form>

</body>
</html>
