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
          const body = item.querySelector('#coords');
          body.textContent = `(${Math.round(il + dx)}, ${Math.round(it + dy)})`;
        });

        header.addEventListener('pointerup', () => {
          moving = false;
          document.documentElement.classList.remove('dragging');
        });
        header.addEventListener('pointercancel', () => { moving = false; });
      });

    })();