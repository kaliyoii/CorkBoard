<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Notes</title>
    <link rel="stylesheet" href="assets/css/style_copy.css">
    <link rel="stylesheet" href="assets/css/drag.css">
</head>
<body>
    <div class="sidebar">

    </div>
<div class="stage" id="stage">
    <div class="item" style="left:9600px; top:9600px">
      <div class="note">
            <dialog>
                <div class="dialog-content">
                    <div class="dialog-buttons">
                        <a class="edit btn-dialog"><ion-icon name="create-outline"></ion-icon></a>
                        <a class="close btn-dialog"><ion-icon name="close-outline"></ion-icon></a>
                    </div>
                </div>
            </dialog>
            <div class="note-head">
                <div class="pin"></div>
            </div>
            <div class="note-body">
                <p>ONE</p>
            </div>
        </div>
    </div>
</div>

  <div class="zoom-controls" id="zoom-controls">
    <button id="zoomIn">＋</button>
    <button id="zoomOut">－</button>
  </div>

  <div class="hint" id="hint">
    <span>Drag anywhere to pan. Double-click to reset.</span>
    <button id="closeHint">✕</button>
  </div>
  <script src="assets/js/drag.js"></script>
</body>
</html>
