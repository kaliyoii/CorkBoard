<?php
// boards/boards.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();

$uid = current_user_id();

// create board (simple inline handler)
$create_msg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_board'])) {
    $name = sanitize($_POST['name'] ?? '');
    if ($name === '') {
        $create_msg = "Name required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO boards (user_id, name, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$uid, $name]);
        header("Location: board.php?id=" . $pdo->lastInsertId());
        exit;
    }
}

// fetch boards
$stmt = $pdo->prepare("SELECT id, name, created_at FROM boards WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$uid]);
$boards = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Your Boards</title></head><body>
<h1>Boards — <?= htmlspecialchars($_SESSION['username'] ?? '') ?></h1>
<p><a href="/CorkBoard/auth/logout.php">Logout</a> | <a href="/CorkBoard/auth/delete_account.php">Delete account</a></p>

<h3>Create New Board</h3>
<?php if ($create_msg): ?><p style="color:red;"><?= $create_msg ?></p><?php endif; ?>
<form method="post">
  <input name="name" placeholder="Board name" required>
  <button name="create_board" type="submit">Create</button>
</form>

<h3>Your Boards</h3>
<ul>
<?php foreach ($boards as $b): ?>
  <li>
    <a href="board.php?id=<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['name']) ?></a>
    — <small>created <?= htmlspecialchars($b['created_at']) ?></small>
    — <a href="delete_board.php?id=<?= (int)$b['id'] ?>" onclick="return confirm('Delete this board?')">Delete</a>
  </li>
<?php endforeach; ?>
</ul>
</body></html>
