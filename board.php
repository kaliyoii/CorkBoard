<?php
require_once __DIR__ . '/includes/object/login/auth_check.php';
require_once __DIR__ . '/includes/object/koneksi.php';

$board_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($board_id <= 0) {
  header('Location: home.php');
  exit;
}

// Ensure the board belongs to the logged-in user
$stmt = $pdo->prepare("SELECT id, user_id, title, color FROM boards WHERE id = ? AND user_id = ?");
$stmt->execute([$board_id, $_SESSION['user_id']]);
$board = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$board) {
  header('Location: home.php');
  exit;
}

// Load notes for this board with content and layout
$stmt = $pdo->prepare(
  "SELECT n.id AS note_id,
          nc.content,
          nc.color AS note_color,
          nc.pin_color,
          IFNULL(nl.pos_x, 9600) AS pos_x,
          IFNULL(nl.pos_y, 9600) AS pos_y
   FROM notes n
   LEFT JOIN note_content nc ON nc.note_id = n.id
   LEFT JOIN note_layout nl ON nl.note_id = n.id
   WHERE n.board_id = ?
   ORDER BY n.id ASC"
);
$stmt->execute([$board_id]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Board</title>
    <!-- DO NOT FORGET -->
    <link rel="stylesheet" href="assets/css/board.css">
</head>
<body>
    
  <div class="stage" id="stage" style="background-color: <?= htmlspecialchars($board['color'] ?? '#9c7d52') ?>;">
      <?php if (!empty($notes)): ?>
        <?php foreach ($notes as $note): ?>
      <form spellcheck="false" class="item" data-note-id="<?= (int)$note['note_id'] ?>" style="left:<?= (int)$note['pos_x'] ?>px; top:<?= (int)$note['pos_y'] ?>px">
        <div class="menu" id="editNote">
          <div>
            <button class="delete" id="deleteButton"><ion-icon name="trash-outline"></ion-icon></button>
          </div>
          <div>
            <input type="color" name="noteCol" id="noteColEdit" value="<?= htmlspecialchars($note['note_color'] ?? '#ffffff') ?>">
            <input type="color" name="pinCol" id="pinColEdit" value="<?= htmlspecialchars($note['pin_color'] ?? '#ce3838') ?>">
          </div>
        </div>
        <button class="pin" style="background-color: <?= htmlspecialchars($note['pin_color'] ?? '#ce3838') ?>;"></button>
          <textarea name="content" id="editContent" style="background-color: <?= htmlspecialchars($note['note_color'] ?? '#ffffff') ?>;"><?= htmlspecialchars($note['content'] ?? '') ?></textarea>
      </form>
        <?php endforeach; ?>
      <?php endif; ?>

  </div>
  
  <div class="sidebar" id="sidebar">
    <button class="hide-sidebar" id="hideSidebar">></button>
    <form spellcheck="false" id="board" class="board-form">
      <input type="color" name="color" id="boardColor" value="<?= htmlspecialchars($board['color'] ?? '#9c7d52') ?>">
      <input type="text" name="title" id="boardTitle" placeholder="Board title" value="<?= htmlspecialchars($board['title'] ?? '') ?>">
    </form>
    <form spellcheck="false" id="newNote" method="POST" action="notes/create_note.php">
  <input type="hidden" name="board_id" value="<?= $board_id ?>">
      <h2>Add new note</h2>
      <div class="new-note">
        <button type="submit" id="insert"><ion-icon name="add-outline"></ion-icon></button>
        <textarea name="content" id="insertContent" placeholder="Note content here..."></textarea>
      </div>
      <div class="color-option">
        <div>
          <input type="color" name="noteCol" id="noteCol" value="#ffffff">
          <label for="noteCol">Note color</label>
        </div>
        <div>
          <input type="color" name="pinCol" id="pinCol" value="#ce3838">
          <label for="pinCol">Pin color</label>
        </div>
      </div>
    </form>
    <a href="home.php" class="home-button">Home</a>
  </div>

  <div class="controls" id="zoom-controls">
    <button id="reCenter" title="Re-center"><ion-icon name="locate-outline"></ion-icon></button>
    <button id="zoomIn" title="Zoom in"><ion-icon name="add-outline"></ion-icon></button>
    <button id="zoomOut" title="Zoom out"><ion-icon name="remove-outline"></ion-icon></button>
    <!-- <button id="help" title="Help"><ion-icon name="help-outline"></ion-icon></button> -->
  </div>
  <script src="assets/js/board.js"></script>
<script src="assets/js/reload.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
