(function(){
      const stage = document.getElementById('stage');
      let tx = 0, ty = 0, scale = 1;
      let lastX = 0, lastY = 0;
      let dragging = false; // Flag for panning the stage

      function applyTransform(){
        stage.style.setProperty('--tx', tx + 'px');
        stage.style.setProperty('--ty', ty + 'px');
        stage.style.setProperty('--scale', scale);
      }

      function centerStage(){ tx = 0; ty = 0; scale = 1; applyTransform(); }
      centerStage();

      // --- STAGE PANNING LOGIC ---

      stage.addEventListener('pointerdown', (e) => {
        // Ensure we are not dragging an item by checking if the target is the stage itself
        if (e.button && e.button !== 0) return;
        // Check if the click originated on an interactive element inside the stage
        if (e.target.closest('.item')) return; 

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

      // --- DRAGGABLE ITEMS LOGIC ---
      const items = document.querySelectorAll('.item');
      items.forEach(item => {
        // *** MODIFIED: Select the .pin element for dragging ***
        const pin = item.querySelector('.pin');
        let ix=0, iy=0, il=0, it=0, moving=false;

        // --- Reusable Drag Functions ---
        function handlePointerDown(e) {
          e.stopPropagation(); // Stop event from propagating to the stage (prevents panning)
          moving = true;
          ix = e.clientX;
          iy = e.clientY;
          il = parseInt(item.style.left);
          it = parseInt(item.style.top);
          document.documentElement.classList.add('dragging');
          e.target.setPointerCapture(e.pointerId); // Capture pointer events
        }
        
        function handlePointerMove(e) {
          if (!moving) return;
          // Divide change by scale to account for zoom level
          const dx = (e.clientX - ix) / scale; 
          const dy = (e.clientY - iy) / scale;
          item.style.left = (il + dx) + 'px';
          item.style.top = (it + dy) + 'px';
          
            // The coordinate update logic is removed as the new HTML structure 
            // does not contain an element with the 'coords' ID.
        }

        function handlePointerUp() {
          moving = false;
          document.documentElement.classList.remove('dragging');
        }
        // --- End Reusable Drag Functions ---

        if (pin) {
            // Attach all drag events to the pin
            pin.addEventListener('pointerdown', handlePointerDown);
            pin.addEventListener('pointermove', handlePointerMove);
            pin.addEventListener('pointerup', handlePointerUp);
            pin.addEventListener('pointercancel', handlePointerUp);
        }

      });

    })();