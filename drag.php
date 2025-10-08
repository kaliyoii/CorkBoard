<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Draggable Infinite Stage with Zoom</title>
  <style>
    html, body { height:100%; margin:0; overflow:hidden; font-family:system-ui,Segoe UI,Roboto,Arial; }

    .stage {
      position:absolute;
      left:50%; top:50%;
      width:20000px; height:20000px;
      transform: translate(-50%, -50%) translate(var(--tx, 0px), var(--ty, 0px)) scale(var(--scale, 1));
      transform-origin: center center;
      background-image: linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px),
                        linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px);
      background-size: 40px 40px, 40px 40px;
      background-position: 0 0, 0 0;
      box-sizing: border-box;
    }

    .item {
      position:absolute;
      background:rgba(255,255,255,0.9);
      border-radius:8px;
      box-shadow:0 6px 18px rgba(0,0,0,0.08);
      min-width:120px;
    }

    .item-header {
      background:#333;
      color:#fff;
      padding:6px 10px;
      border-radius:8px 8px 0 0;
      cursor:grab;
      font-size:13px;
    }
    .item-body {
      padding:10px;
      font-size:13px;
    }

    .dragging, .dragging * { user-select:none !important; cursor:grabbing !important; }

    .hint { position:fixed; left:10px; bottom:10px; background:#111;color:#fff;padding:8px 10px;border-radius:6px;font-size:13px;opacity:.9; display:flex; align-items:center; gap:6px; }
    .hint button { background:transparent; border:none; color:#fff; cursor:pointer; font-size:14px; }

    .zoom-controls { position:fixed; left:10px; bottom:50px; display:flex; flex-direction:column; gap:6px; }
    .zoom-controls button { background:#111; color:#fff; border:none; border-radius:6px; padding:6px 10px; cursor:pointer; font-size:16px; }
    .zoom-controls button:hover { background:#333; }
  </style>
</head>
<body>
  <div class="stage" id="stage">
    <div class="item" style="left:9600px; top:9600px">
      <div class="item-header">Center-ish</div>
      <div class="item-body">(9600, 9600)</div>
    </div>
    <div class="item" style="left:500px; top:500px">
      <div class="item-header">Top-left</div>
      <div class="item-body">(500, 500)</div>
    </div>
    <div class="item" style="left:18000px; top:300px">
      <div class="item-header">Far right</div>
      <div class="item-body">(18000, 300)</div>
    </div>
    <div class="item" style="left:300px; top:18000px">
      <div class="item-header">Far bottom</div>
      <div class="item-body">(300, 18000)</div>
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

  <script>
    (function(){
      const stage = document.getElementById('stage');
      let tx = 0, ty = 0, scale = 1;
      let lastX = 0, lastY = 0;
      let dragging = false;

      function applyTransform(){
        stage.style.setProperty('--tx', tx + 'px');
        stage.style.setProperty('--ty', ty + 'px');
        stage.style.setProperty('--scale', scale);
      }

      function centerStage(){ tx = 0; ty = 0; scale = 1; applyTransform(); }
      centerStage();

      stage.addEventListener('pointerdown', (e) => {
        if (e.button && e.button !== 0) return;
        dragging = true;
        lastX = e.clientX; lastY = e.clientY;
        document.documentElement.classList.add('dragging');
        stage.setPointerCapture(e.pointerId);
      });

      stage.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - lastX;
        const dy = e.clientY - lastY;
        lastX = e.clientX; lastY = e.clientY;
        tx += dx; ty += dy;
        applyTransform();
      });

      function endDrag(){
        if (!dragging) return;
        dragging = false;
        document.documentElement.classList.remove('dragging');
      }
      stage.addEventListener('pointerup', endDrag);
      stage.addEventListener('pointercancel', endDrag);
      window.addEventListener('mouseup', endDrag);

      stage.addEventListener('dblclick', () => { centerStage(); });

      // zoom buttons
      document.getElementById('zoomIn').addEventListener('click', () => { scale *= 1.1; applyTransform(); });
      document.getElementById('zoomOut').addEventListener('click', () => { scale /= 1.1; applyTransform(); });

      // close hint
      document.getElementById('closeHint').addEventListener('click', () => {
        document.getElementById('hint').style.display = 'none';
        document.getElementById('zoom-controls').style.bottom = '10px';
      });

      // draggable items via header
      const items = document.querySelectorAll('.item');
      items.forEach(item => {
        const header = item.querySelector('.item-header');
        let ix=0, iy=0, il=0, it=0, moving=false;

        header.addEventListener('pointerdown', (e) => {
          e.stopPropagation();
          moving = true;
          ix = e.clientX;
          iy = e.clientY;
          il = parseInt(item.style.left);
          it = parseInt(item.style.top);
          document.documentElement.classList.add('dragging');
          header.setPointerCapture(e.pointerId);
        });

        header.addEventListener('pointermove', (e) => {
          if (!moving) return;
          const dx = (e.clientX - ix) / scale;
          const dy = (e.clientY - iy) / scale;
          item.style.left = (il + dx) + 'px';
          item.style.top = (it + dy) + 'px';
          const body = item.querySelector('.item-body');
          body.textContent = `(${Math.round(il + dx)}, ${Math.round(it + dy)})`;
        });

        header.addEventListener('pointerup', () => {
          moving = false;
          document.documentElement.classList.remove('dragging');
        });
        header.addEventListener('pointercancel', () => { moving = false; });
      });

    })();
  </script>
</body>
</html>
