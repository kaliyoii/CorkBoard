<?php
require_once __DIR__ . '/../includes/object/login/auth_check.php';
require_once __DIR__ . '/../includes/object/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
  exit;
}

$userId = $_SESSION['user_id'] ?? null;
$boardId = isset($_POST['board_id']) ? (int)$_POST['board_id'] : 0;

if (!$userId || $boardId <= 0) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Bad request']);
  exit;
}

// Ensure the board belongs to the logged in user
$stmt = $pdo->prepare('SELECT id FROM boards WHERE id = ? AND user_id = ? LIMIT 1');
$stmt->execute([$boardId, $userId]);
$board = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$board) {
  http_response_code(403);
  echo json_encode(['ok' => false, 'error' => 'Forbidden']);
  exit;
}

try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare('DELETE FROM boards WHERE id = ?');
  $stmt->execute([$boardId]);
  $pdo->commit();

  header('Location: ../home.php'); // redirect
  exit;
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Database error']);
}
exit;

?>
