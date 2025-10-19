<?php
require_once __DIR__ . '/../includes/object/login/auth_check.php';
require_once __DIR__ . '/../includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
  exit;
}

$userId = $_SESSION['user_id'] ?? null;
$noteId = isset($_POST['note_id']) ? (int)$_POST['note_id'] : 0;

if (!$userId || $noteId <= 0) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Bad request']);
  exit;
}

// Ensure the note belongs to the logged in user (via its board)
$stmt = $pdo->prepare('SELECT n.id, b.user_id FROM notes n JOIN boards b ON n.board_id = b.id WHERE n.id = ? LIMIT 1');
$stmt->execute([$noteId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row || (int)$row['user_id'] !== (int)$userId) {
  http_response_code(403);
  echo json_encode(['ok' => false, 'error' => 'Forbidden']);
  exit;
}

try {
  $pdo->beginTransaction();
  
  // Delete note (cascade will handle note_content and note_layout)
  $stmt = $pdo->prepare('DELETE FROM notes WHERE id = ?');
  $stmt->execute([$noteId]);
  
  $pdo->commit();
  
  header('Content-Type: application/json');
  echo json_encode(['ok' => true]);
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Database error']);
}
exit;
?>
