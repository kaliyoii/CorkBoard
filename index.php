<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Notes</title>
    <!-- <link rel="stylesheet" href="assets/css/style_copy.css">
    <link rel="stylesheet" href="assets/css/drag.css"> -->
    <link rel="stylesheet" href="assets/css/master.css">
</head>
<body>
    
  <div class="stage" id="stage">
<div class="sidebar" id="sidebar">

    </div>
      <div class="item" style="left:9600px; top:9600px; width: 50rem;">
        <div class="pin"></div>
        <div class="note-body">
            <p>ONE ONE ONE ONE ONE ONE ONE ONE ONE ONE ONEO ONEO NEO OEN</p>
        </div>
      </div>

      <div class="item" style="left:9600px; top:9600px">
        <div class="pin"></div>
        <div class="note-body">
            <p>ONE ONE ONE ONE ONE ONE ONE ONE ONE ONE ONEO ONEO NEO OEN</p>
        </div>
      </div>

      <div class="item" style="left:9600px; top:9600px">
        <div class="pin"></div>
        <div class="note-body">
            <p>ONE ONE ONE ONE ONE ONE ONE ONE ONE ONE ONEO ONEO NEO OEN</p>
        </div>
      </div>

  </div>
  <div class="zoom-controls" id="zoom-controls">
    <button id="zoomIn">+</button>
    <button id="zoomOut">-</button>
  </div>

  <div class="hint" id="hint">
    <span>Drag anywhere to pan. Double-click to reset.</span>
    <button id="closeHint">✕</button>
  </div>
  <script src="assets/js/drag.js"></script>
</body>
</html>
