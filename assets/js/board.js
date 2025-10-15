const notes = document.querySelectorAll('.note');
let boardTranslateX = 0;
let boardTranslateY = 0;


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
        };



        const onMouseUp = (e) => {
            if (!isDragging) { // click, not drag
                openNoteMenu(note, pin);
            }
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            isDragging = false;
            document.getElementById('sidebar').style.zIndex = ++topZ;
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

const board = document.getElementById('board');
let isBoardDragging = false;
let boardStartX = 0, boardStartY = 0;

board.addEventListener('mousedown', (e) => {
    if (e.target.closest('.note')) return; // ignore if clicking on a note
    isBoardDragging = true;
    boardStartX = e.clientX - boardTranslateX;
    boardStartY = e.clientY - boardTranslateY;
    board.style.cursor = "grabbing";
    e.preventDefault();
});

document.addEventListener('mousemove', (e) => {
    if (!isBoardDragging) return;
    boardTranslateX = e.clientX - boardStartX;
    boardTranslateY = e.clientY - boardStartY;
    board.style.transform = `translate(${boardTranslateX}px, ${boardTranslateY}px)`;
});

document.addEventListener('mouseup', () => {
    isBoardDragging = false;
    board.style.cursor = "default";
});
