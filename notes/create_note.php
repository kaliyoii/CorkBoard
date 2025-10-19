<?php
require_once __DIR__ . '/../includes/object/login/auth_check.php';
require_once __DIR__ . '/../includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../home.php');
  exit;
}

$userId = $_SESSION['user_id'] ?? null;
$boardId = isset($_POST['board_id']) ? (int)$_POST['board_id'] : 0;
$content = trim($_POST['content'] ?? '');
$noteColor = trim($_POST['noteCol'] ?? '#ffffff');
$pinColor = trim($_POST['pinCol'] ?? '#ff2400');

if ($userId === null || $boardId <= 0) {
  header('Location: ../home.php');
  exit;
}

// Verify that the board belongs to the logged-in user
$stmt = $pdo->prepare('SELECT id FROM boards WHERE id = ? AND user_id = ?');
$stmt->execute([$boardId, $userId]);
$board = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$board) {
  header('Location: ../home.php');
  exit;
}

// Normalize colors
if ($noteColor !== '' && $noteColor[0] !== '#') { $noteColor = '#'.$noteColor; }
if ($pinColor !== '' && $pinColor[0] !== '#') { $pinColor = '#'.$pinColor; }
if (!preg_match('/^#[0-9a-fA-F]{6}$/', $noteColor)) { $noteColor = '#ffffff'; }
if (!preg_match('/^#[0-9a-fA-F]{6}$/', $pinColor)) { $pinColor = '#ff2400'; }

try {
  $pdo->beginTransaction();

  // Create note
  $stmt = $pdo->prepare('INSERT INTO notes (board_id) VALUES (?)');
  $stmt->execute([$boardId]);
  $noteId = (int)$pdo->lastInsertId();

  // Content
  $stmt = $pdo->prepare('INSERT INTO note_content (note_id, content, color, pin_color, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');
  $stmt->execute([$noteId, $content, $noteColor, $pinColor]);

  // Layout default position (near origin)
  $stmt = $pdo->prepare('INSERT INTO note_layout (note_id, pos_x, pos_y) VALUES (?, ?, ?)');
  $stmt->execute([$noteId, 9600, 9600]);

  $pdo->commit();
} catch (Throwable $e) {
  if ($pdo->inTransaction()) { $pdo->rollBack(); }
  echo "<script>alert('Failed to create note.');history.back();</script>";
  exit;
}

header('Location: ../board.php?id=' . $boardId);
exit;
?>


