<?php
// notes/move_note.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error'=>'POST only'], 405);

$note_id = intval($_POST['note_id'] ?? 0);
$x = intval($_POST['x'] ?? 0);
$y = intval($_POST['y'] ?? 0);
$w = intval($_POST['w'] ?? 0);
$h = intval($_POST['h'] ?? 0);

if (!$note_id) json_response(['error'=>'missing note id'], 400);

$stmt = $pdo->prepare("SELECT b.user_id FROM notes n JOIN boards b ON b.id = n.board_id WHERE n.id = ? LIMIT 1");
$stmt->execute([$note_id]);
$r = $stmt->fetch();
if (!$r || $r['user_id'] != $uid) json_response(['error'=>'Access denied'], 403);

$stmt = $pdo->prepare("UPDATE note_layout SET x = ?, y = ?, w = COALESCE(NULLIF(?,0), w), h = COALESCE(NULLIF(?,0), h) WHERE note_id = ?");
$stmt->execute([$x, $y, $w, $h, $note_id]);
json_response(['ok'=>true]);
