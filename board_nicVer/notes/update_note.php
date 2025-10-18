<?php
// notes/update_note.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error'=>'POST only'], 405);
}

$note_id = intval($_POST['note_id'] ?? 0);
if (!$note_id) json_response(['error'=>'missing note id'], 400);

// verify ownership
$stmt = $pdo->prepare("SELECT b.user_id FROM notes n JOIN boards b ON b.id = n.board_id WHERE n.id = ? LIMIT 1");
$stmt->execute([$note_id]);
$r = $stmt->fetch();
if (!$r || $r['user_id'] != $uid) json_response(['error'=>'Access denied'], 403);

$text = isset($_POST['text']) ? $_POST['text'] : null;
$color = isset($_POST['color']) ? sanitize($_POST['color']) : null;

$fields = []; $params = [];
if ($text !== null) { $fields[] = "text = ?"; $params[] = $text; }
if ($color !== null) { $fields[] = "color = ?"; $params[] = $color; }
if (empty($fields)) json_response(['ok'=>true]);

$params[] = $note_id;
$sql = "UPDATE note_content SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE note_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
json_response(['ok'=>true]);
