<?php
require_once __DIR__ . '../login/auth_check.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board_id = intval($_POST['board_id'] ?? 0);
    $content  = trim($_POST['content'] ?? '');
    $noteCol  = $_POST['noteCol'] ?? '#ffffff';
    $pinCol   = $_POST['pinCol'] ?? '#ce3838';

    if (!$board_id) {
        echo json_encode(['ok' => false, 'error' => 'Missing board_id']);
        exit;
    }

    // Connect to database
    global $pdo;
    $pdo->beginTransaction();

    try {
        // 1. Create note
        $stmt = $pdo->prepare("INSERT INTO notes (board_id, created_at, updated_at) VALUES (?, NOW(), NOW())");
        $stmt->execute([$board_id]);
        $note_id = $pdo->lastInsertId();

        // 2. Add note content
        $stmt = $pdo->prepare("
            INSERT INTO note_content (note_id, content, color, pin_color, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([$note_id, $content, $noteCol, $pinCol]);

        // 3. Default layout position
        $stmt = $pdo->prepare("INSERT INTO note_layout (note_id, pos_x, pos_y) VALUES (?, ?, ?)");
        $stmt->execute([$note_id, rand(50, 300), rand(50, 300)]);

        $pdo->commit();

        echo json_encode(['ok' => true, 'note_id' => $note_id]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
}
?>
