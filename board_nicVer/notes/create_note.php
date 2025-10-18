<?php
// boards/board.php
require_once __DIR__ . '/../includes/functions.php';
checkLogin();
$uid = current_user_id();

$board_id = intval($_GET['id'] ?? 0);
if (!$board_id) {
    header('Location: ../boards/boards.php'); exit;
}

// ownership check
$stmt = $pdo->prepare("SELECT * FROM boards WHERE id = ? LIMIT 1");
$stmt->execute([$board_id]);
$board = $stmt->fetch();
if (!$board || $board['user_id'] != $uid) {
    header('Location: boards.php'); exit;
}

// fetch notes + content + layout
$stmt = $pdo->prepare("
  SELECT n.id AS note_id, nc.type, nc.text, nc.img, nc.color, nc.pin_color,
         nl.x, nl.y, nl.w, nl.h
  FROM notes n
  LEFT JOIN note_content nc ON nc.note_id = n.id
  LEFT JOIN note_layout nl ON nl.note_id = n.id
  WHERE n.board_id = ?
");
$stmt->execute([$board_id]);
$notes = $stmt->fetchAll();

// fetch connections for notes of this board
$stmt = $pdo->prepare("
  SELECT c.id, c.source_id, c.target_id
  FROM connections c
  JOIN notes ns ON ns.id = c.source_id OR ns.id = c.target_id
  WHERE ns.board_id = ?
  GROUP BY c.id
");
$stmt->execute([$board_id]);
$conns = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($board['name']) ?></title>
  <style>
    body{font-family:Arial}
    #canvas{position:relative; width:1000px; height:600px; border:1px solid #ccc; margin:10px auto; background:#f7f7f7;}
    .note{position:absolute; box-shadow:0 2px 6px rgba(0,0,0,.15); padding:8px; cursor:move; border-radius:6px;}
    .note textarea{width:100%; height:80px; border:none; background:transparent; resize:none;}
  </style>
</head>
<body>
<h1>Board: <?= htmlspecialchars($board['name']) ?></h1>
<p><a href="boards.php">Back to boards</a></p>

<div style="max-width:1000px;margin:0 auto">
  <form id="add-note-form" method="post" action="/CorkBoard/notes/create_note.php">
    <input type="hidden" name="board_id" value="<?= $board_id ?>">
    <input name="text" placeholder="Note text (optional)">
    <input name="color" placeholder="Color (#hex)" value="#FFF9C4">
    <button type="submit">Add Note</button>
  </form>

  <div id="canvas">
    <!-- notes will be rendered here by JS -->
  </div>
</div>

<script>
const NOTES = <?= json_encode($notes) ?>;
const CONNS = <?= json_encode($conns) ?>;
const BOARD_ID = <?= json_encode($board_id) ?>;

const canvas = document.getElementById('canvas');

function createNoteElement(n){
  const el = document.createElement('div');
  el.className = 'note';
  el.dataset.id = n.note_id;
  el.style.left = (n.x ?? 10) + 'px';
  el.style.top  = (n.y ?? 10) + 'px';
  el.style.width = (n.w ?? 200) + 'px';
  el.style.height = (n.h ?? 150) + 'px';
  el.style.background = n.color ?? '#FFF9C4';

  const ta = document.createElement('textarea');
  ta.value = n.text ?? '';
  ta.addEventListener('change', ()=> {
    fetch('/CorkBoard/notes/update_note.php', {
      method:'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: new URLSearchParams({note_id: n.note_id, text: ta.value})
    }).then(r=>r.json()).then(console.log);
  });

  const delBtn = document.createElement('button');
  delBtn.textContent = 'Delete';
  delBtn.addEventListener('click', ()=>{
    if (!confirm('Delete note?')) return;
    fetch('/CorkBoard/notes/delete_note.php', {
      method:'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: new URLSearchParams({note_id: n.note_id})
    }).then(r=>r.json()).then(res=>{
      if (res.ok) el.remove();
    });
  });

  el.appendChild(ta);
  el.appendChild(delBtn);

  // basic drag (mouse only)
  let drag = false, startX=0, startY=0, origX=0, origY=0;
  el.addEventListener('mousedown', (ev)=>{
    drag = true;
    startX = ev.clientX; startY = ev.clientY;
    origX = parseInt(el.style.left); origY = parseInt(el.style.top);
    el.style.zIndex = 1000;
  });
  window.addEventListener('mousemove', (ev)=>{
    if (!drag) return;
    el.style.left = (origX + ev.clientX - startX) + 'px';
    el.style.top  = (origY + ev.clientY - startY) + 'px';
  });
  window.addEventListener('mouseup', (ev)=>{
    if (!drag) return;
    drag = false;
    el.style.zIndex = '';
    // save layout
    const newX = parseInt(el.style.left), newY = parseInt(el.style.top);
    fetch('/CorkBoard/notes/move_note.php', {
      method:'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: new URLSearchParams({note_id: n.note_id, x: newX, y: newY})
    }).then(r=>r.json()).then(console.log);
  });

  return el;
}

NOTES.forEach(n=>{
  const el = createNoteElement(n);
  canvas.appendChild(el);
});
</script>
</body></html>
