const notes = document.querySelectorAll('.note');
let topZ = 1;

// transform state
let tx = 0, ty = 0, scale = 1;

// drag board
let isBoardDragging = false;
let boardStartX = 0, boardStartY = 0;

const board = document.getElementById('board');

function applyTransform() {
  board.style.setProperty('--tx', tx + 'px');
  board.style.setProperty('--ty', ty + 'px');
  board.style.setProperty('--scale', scale);
}

// center position awal
applyTransform();

// board dragging
board.addEventListener('pointerdown', (e) => {
  if (e.target.closest('.note')) return;
  isBoardDragging = true;
  boardStartX = e.clientX - tx;
  boardStartY = e.clientY - ty;
  document.documentElement.classList.add('dragging');
  board.setPointerCapture(e.pointerId);
});

document.addEventListener('pointermove', (e) => {
  if (!isBoardDragging) return;
  tx = e.clientX - boardStartX;
  ty = e.clientY - boardStartY;
  applyTransform();
});

document.addEventListener('pointerup', () => {
  isBoardDragging = false;
  document.documentElement.classList.remove('dragging');
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
document.getElementById('closeHint').addEventListener('click', () => {
  document.getElementById('hint').style.display = 'none';
  document.getElementById('zoom-controls').style.bottom = '10px';
});

// handle note drag
notes.forEach(note => {
  const pin = note.querySelector('.pin');
  const dialog = note.querySelector("dialog");
  const closeButton = dialog.querySelector(".close");

  let isDragging = false;
  let offsetX = 0, offsetY = 0;
  let startX = 0, startY = 0;

  pin.addEventListener('pointerdown', (e) => {
    isDragging = false;
    startX = e.clientX;
    startY = e.clientY;
    topZ++;
    note.style.zIndex = topZ;

    const rect = note.getBoundingClientRect();
    offsetX = e.clientX - rect.left;
    offsetY = e.clientY - rect.top;
    e.preventDefault();

    function onPointerMove(e) {
      const dx = e.clientX - startX;
      const dy = e.clientY - startY;

      if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
        isDragging = true;
      }

      if (isDragging) {
        // perhatikan transform
        note.style.left = ((e.clientX - offsetX - tx) / scale) + 'px';
        note.style.top = ((e.clientY - offsetY - ty) / scale) + 'px';

        const deleteZone = document.getElementById('delete');
        const deleteRect = deleteZone.getBoundingClientRect();

        const cursorInsideDelete =
          e.clientX >= deleteRect.left &&
          e.clientX <= deleteRect.right &&
          e.clientY >= deleteRect.top &&
          e.clientY <= deleteRect.bottom;

        if (cursorInsideDelete) {
          note.style.boxShadow = "0 0 15px 3px red";
        } else {
          note.style.boxShadow = "";
        }
      }
    }

    function onPointerUp(e) {
      if (!isDragging) {
        openNoteMenu(note, pin);
      }

      document.removeEventListener('pointermove', onPointerMove);
      document.removeEventListener('pointerup', onPointerUp);
      isDragging = false;
      document.getElementById('sidebar').style.zIndex = ++topZ;
    }

    document.addEventListener('pointermove', onPointerMove);
    document.addEventListener('pointerup', onPointerUp);
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
