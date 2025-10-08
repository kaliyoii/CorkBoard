const notes = document.querySelectorAll('.note');

let topZ = 1;

notes.forEach(note => {
    const pin = note.querySelector('.pin');
    let isDragging = false;
    let offsetX = 0, offsetY = 0;

    // Start dragging when pin is clicked
    pin.addEventListener('mousedown', (e) => {
        isDragging = true;
        topZ++;
        note.style.zIndex = topZ;
        const rect = note.getBoundingClientRect();
        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;
        e.preventDefault();
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        note.style.left = (e.clientX - offsetX) + 'px';
        note.style.top = (e.clientY - offsetY) + 'px';
    });

    document.addEventListener('mouseup', () => {
        if (isDragging) {
            isDragging = false;
        }
    });
});
