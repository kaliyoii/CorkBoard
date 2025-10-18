<?php
// notes/connect_notes.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error'=>'POST only'], 405);

$source = intval($_POST['source_id'] ?? 0);
$target = intval($_POST['target_id'] ?? 0);
if (!$source || !$target) json_response(['error'=>'missing ids'], 400);
if ($source === $target) json_response(['error'=>'source and target cannot be the same'], 400);

// verify both notes belong to same board and user
$stmt = $pdo->prepare("SELECT b.user_id, n.board_id FROM notes n JOIN boards b ON b.id = n.board_id WHERE n.id = ? LIMIT 1");
$stmt->execute([$source]); $s = $stmt->fetch();
$stmt->execute([$target]); $t = $stmt->fetch();

if (!$s || !$t || $s['user_id'] != $uid || $t['user_id'] != $uid || $s['board_id'] != $t['board_id']) {
    json_response(['error'=>'Access denied or notes not in same board'], 403);
}

$stmt = $pdo->prepare("INSERT INTO connections (source_id, target_id, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$source, $target]);

json_response(['ok'=>true, 'id' => $pdo->lastInsertId()]);
