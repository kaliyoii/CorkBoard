(function () {
  // ====== STAGE PAN & ZOOM ======
  const stage = document.getElementById('stage');
  let tx = 0, ty = 0, scale = 1;
  let lastX = 0, lastY = 0;
  let dragging = false;

  function applyTransform() {
    stage.style.setProperty('--tx', tx + 'px');
    stage.style.setProperty('--ty', ty + 'px');
    stage.style.setProperty('--scale', scale);
  }

  function centerStage() {
    tx = 0;
    ty = 0;
    scale = 1;
    applyTransform();
  }
  centerStage();

  stage.addEventListener('pointerdown', (e) => {
    if (e.button && e.button !== 0) return;
    dragging = true;
    lastX = e.clientX;
    lastY = e.clientY;
    document.documentElement.classList.add('dragging');
    stage.setPointerCapture(e.pointerId);
  });

  stage.addEventListener('pointermove', (e) => {
    if (!dragging) return;
    const dx = e.clientX - lastX;
    const dy = e.clientY - lastY;
    lastX = e.clientX;
    lastY = e.clientY;
    tx += dx;
    ty += dy;
    applyTransform();
  });

  function endDrag() {
    if (!dragging) return;
    dragging = false;
    document.documentElement.classList.remove('dragging');
  }

  stage.addEventListener('pointerup', endDrag);
  stage.addEventListener('pointercancel', endDrag);
  window.addEventListener('mouseup', endDrag);

  stage.addEventListener('dblclick', () => {
    centerStage();
  });

  // zoom buttons
  document.getElementById('zoomIn').addEventListener('click', () => {
    scale *= 1.1;
    applyTransform();
  });
  document.getElementById('zoomOut').addEventListener('click', () => {
    scale /= 1.1;
    applyTransform();
  });

  // close hint
  document.getElementById('closeHint').addEventListener('click', () => {
    document.getElementById('hint').style.display = 'none';
    document.getElementById('zoom-controls').style.bottom = '10px';
  });

  // ====== DRAGGABLE ITEMS VIA HEADER ======
  const items = document.querySelectorAll('.item');
  items.forEach(item => {
    const header = item.querySelector('.item-header');
    let ix = 0, iy = 0, il = 0, it = 0, moving = false;

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
      if (body) body.textContent = `(${Math.round(il + dx)}, ${Math.round(it + dy)})`;
    });

    header.addEventListener('pointerup', () => {
      moving = false;
      document.documentElement.classList.remove('dragging');
    });

    header.addEventListener('pointercancel', () => {
      moving = false;
    });
  });

  // ====== STICKY NOTES ======
  const notes = document.querySelectorAll('.note');
  let topZ = 1;

  notes.forEach(note => {
    const pin = note.querySelector('.pin');
    const dialog = note.querySelector("dialog");
    const closeButton = dialog.querySelector(".close");
    let isDragging = false;
    let offsetX = 0, offsetY = 0;
    let startX = 0, startY = 0;

    pin.addEventListener('mousedown', (e) => {
      isDragging = false;
      startX = e.clientX;
      startY = e.clientY;
      topZ++;
      note.style.zIndex = topZ;
      const rect = note.getBoundingClientRect();
      offsetX = e.clientX - rect.left;
      offsetY = e.clientY - rect.top;
      e.preventDefault();

      const onMouseMove = (e) => {
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
          isDragging = true;
        }
        if (isDragging) {
          note.style.left = (e.clientX - offsetX) + 'px';
          note.style.top = (e.clientY - offsetY) + 'px';

          const deleteZone = document.getElementById('delete');
          if (deleteZone) {
            const deleteRect = deleteZone.getBoundingClientRect();
            const cursorInsideDelete =
              e.clientX >= deleteRect.left &&
              e.clientX <= deleteRect.right &&
              e.clientY >= deleteRect.top &&
              e.clientY <= deleteRect.bottom;

            note.style.boxShadow = cursorInsideDelete
              ? "0 0 15px 3px red"
              : "";
          }
        }
      };

      const onMouseUp = (e) => {
        if (!isDragging) { // click, not drag
          openNoteMenu(note, pin);
        }
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
        isDragging = false;
        const sidebar = document.getElementById('sidebar');
        if (sidebar) sidebar.style.zIndex = ++topZ;
      };

      document.addEventListener('mousemove', onMouseMove);
      document.addEventListener('mouseup', onMouseUp);
    });

    function openNoteMenu(note, pin) {
      const rect = note.getBoundingClientRect();
      note.classList.add("active");
      dialog.style.position = 'absolute';
      dialog.style.left = `calc(${rect.left + rect.width / 2}px - 7%)`;
      dialog.style.top = `${rect.top + 2}px`;
      dialog.showModal();
      pin.style.display = "none";
      note.style.zIndex = topZ;
    }

    closeButton.addEventListener("click", () => {
      dialog.close();
      pin.removeAttribute("style");
      note.classList.remove("active");
    });
  });
})();
