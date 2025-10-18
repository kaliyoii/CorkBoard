<?php
// boards/delete_board.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

$board_id = intval($_GET['id'] ?? 0);
if (!$board_id) {
    header('Location: boards.php'); exit;
}

// verify ownership
$stmt = $pdo->prepare("SELECT user_id FROM boards WHERE id = ? LIMIT 1");
$stmt->execute([$board_id]);
$b = $stmt->fetch();
if (!$b || $b['user_id'] != $uid) {
    header('Location: boards.php'); exit;
}

// delete board (cascades)
$stmt = $pdo->prepare("DELETE FROM boards WHERE id = ?");
$stmt->execute([$board_id]);

header('Location: boards.php');
exit;
