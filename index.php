<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Notes</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/drag.css">
</head>
<body>
    <div class="sidebar">

    </div>
    <div class="stage" id="stage">
    <div class="item" style="left:9600px; top:9600px">
      <div class="item-header">Center-ish <span id="coords">(X, Y)</span></div>
      <div class="item-body">Content</div>
    </div>
    <div class="item" style="left:500px; top:500px">
      <div class="item-header">Top-left <span id="coords">(X, Y)</span></div>
      <div class="item-body">Content</div>
    </div>
    <div class="item" style="left:18000px; top:300px">
      <div class="item-header">Far right <span id="coords">(X, Y)</span></div>
      <div class="item-body">Content</div>
    </div>
    <div class="item" style="left:300px; top:18000px">
      <div class="item-header">Far bottom <span id="coords">(X, Y)</span></div>
      <div class="item-body">Content</div>
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
