let topZ = 1;
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

	// STAGE PANNING LOGIC

	stage.addEventListener('pointerdown', (e) => {
	   if (e.button && e.button !== 0) return;
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

	// recenter & zoom
	document.getElementById('reCenter').addEventListener('click', () => { centerStage(); });
	document.getElementById('zoomIn').addEventListener('click', () => { scale *= 1.1; applyTransform(); });
	document.getElementById('zoomOut').addEventListener('click', () => { scale /= 1.1; applyTransform(); });

	const items = document.querySelectorAll('.item');
	items.forEach(item => {
	const pin = item.querySelector('.pin');
	const menu = item.querySelector('.menu');
	const deleteButton = item.querySelector('#deleteButton');
	const textarea = item.querySelector('textarea');
	const noteColorInput = item.querySelector('input[name="noteCol"]');
	const pinColorInput = item.querySelector('input[name="pinCol"]');
	let ix = 0, iy = 0, il = 0, it = 0;
	let pressed = false;
	let menuOpen = false;
	let moving = false;

	function handlePointerDown(e) {
		e.stopPropagation();
		pressed = true;
		moving = false;
		ix = e.clientX;
		iy = e.clientY;
		il = parseInt(item.style.left);
		it = parseInt(item.style.top);
		document.documentElement.classList.add('dragging');
		e.target.setPointerCapture(e.pointerId);
		topZ++;
	}

	function handlePointerMove(e) {
		if (!pressed) return;

		const dx = (e.clientX - ix) / scale;
		const dy = (e.clientY - iy) / scale;

		if (!moving && (Math.abs(dx) > 3 || Math.abs(dy) > 3)) {
			moving = true;
		}

		if (moving) {
			item.style.left = (il + dx) + 'px';
			item.style.top = (it + dy) + 'px';
			item.style.zIndex = topZ;
			if (menuOpen) {
				menuOpen = false;
			}
		}
	}

	function handlePointerUp(e) {
		document.documentElement.classList.remove('dragging');

		if (pressed && !moving) {
			menuOpen = !menuOpen;
		}

		if (menuOpen) {
			menu.classList.add('active');
			pin.classList.add('active');
		} else {
			menu.classList.remove('active');
			pin.classList.remove('active');
		}

		if (moving) {
			const left = parseInt(item.style.left) || 0;
			const top = parseInt(item.style.top) || 0;
			const noteId = item.dataset.noteId;
			if (noteId) {
				fetch('notes/move_note.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: new URLSearchParams({ note_id: noteId, x: Math.round(left), y: Math.round(top) })
				}).then(()=>{}).catch(()=>{});
			}
		}
		pressed = false;
		moving = false;
	}

	function deleteAlert(e) {
		e.preventDefault();
		e.stopPropagation();
		const result = confirm("Delete this note?");
		if (result) {
			const noteId = item.dataset.noteId;
			if (noteId) {
				fetch('notes/delete_note.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: new URLSearchParams({ note_id: noteId })
				}).then(r => r.json()).then(res => {
					if (res.ok) {
						item.remove();
					} else {
						alert('Failed to delete note');
					}
				}).catch(() => {
					alert('Failed to delete note');
				});
			}
		}
	}

	if (pin) {
		pin.addEventListener('pointerdown', handlePointerDown);
		pin.addEventListener('pointermove', handlePointerMove);
		pin.addEventListener('pointerup', handlePointerUp);
		pin.addEventListener('pointercancel', handlePointerUp);
	}

	if (deleteButton) {
		deleteButton.addEventListener('click', deleteAlert);
	}

	// Handle textarea content changes
	if (textarea) {
		textarea.addEventListener('blur', function() {
			const noteId = item.dataset.noteId;
			if (noteId) {
				fetch('notes/update_note.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: new URLSearchParams({
						note_id: noteId,
						content: textarea.value,
						note_color: noteColorInput ? noteColorInput.value : '',
						pin_color: pinColorInput ? pinColorInput.value : ''
					})
				}).then(r => r.json()).then(res => {
					if (!res.ok) {
						console.error('Failed to update note content');
					}
				}).catch(() => {
					console.error('Failed to update note content');
				});
			}
		});
	}

	// Handle note color changes
	if (noteColorInput) {
	noteColorInput.addEventListener('input', function() {
		textarea.style.backgroundColor = this.value;
	});

	noteColorInput.addEventListener('change', function() {
		const noteId = item.dataset.noteId;
		if (noteId) {
			fetch('notes/update_note.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams({
					note_id: noteId,
					content: textarea.value,
					note_color: this.value,
					pin_color: pinColorInput ? pinColorInput.value : ''
				})
			}).then(r => r.json()).then(res => {
				if (!res.ok) {
					console.error('Failed to update note color');
				}
			}).catch(() => {
				console.error('Failed to update note color');
			});
		}
	});
}


	// Handle pin color changes
	if (pinColorInput) {
		pinColorInput.addEventListener('input', function() {
				pin.style.backgroundColor = this.value;
		});
		
		pinColorInput.addEventListener('change', function() {
			const noteId = item.dataset.noteId;
			if (noteId) {
				fetch('notes/update_note.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: new URLSearchParams({
						note_id: noteId,
						content: textarea.value,
						note_color: noteColorInput ? noteColorInput.value : '',
						pin_color: this.value
					})
				}).then(r => r.json()).then(res => {
					if (!res.ok) {
						console.error('Failed to update pin color');
					}
				}).catch(() => {
					console.error('Failed to update pin color');
				});
			}
		});
	}
});

	const sidebar = document.getElementById('sidebar');
	const hideButton = document.getElementById('hideSidebar');
	let sidebarHidden = false;
	function hideSidebar(e) {
		if (sidebarHidden) {
			sidebarHidden = !sidebarHidden;
			sidebar.classList.remove('hidden');
			hideButton.innerText = '>';
		} else {
			sidebarHidden = !sidebarHidden;
			sidebar.classList.add('hidden');
			hideButton.innerText = '<';
		}
		
	}
	if (hideButton) {
			hideButton.addEventListener('click', hideSidebar);
		}

	})();

// Handle board color and title changes
const boardColorInput = document.getElementById('boardColor');
const boardTitleInput = document.getElementById('boardTitle');
const stage = document.getElementById('stage');

if (boardColorInput) {
	boardColorInput.addEventListener('input', function() {
		stage.style.backgroundColor = this.value;
	});
	boardColorInput.addEventListener('change', function() {
		saveBoardChanges();
	});
}

if (boardTitleInput) {
	boardTitleInput.addEventListener('blur', function() {
		saveBoardChanges();
	});
}

function saveBoardChanges() {
	const boardId = new URLSearchParams(window.location.search).get('id');
	if (!boardId) return;
	
	const formData = new URLSearchParams({
		board_id: boardId,
		title: boardTitleInput ? boardTitleInput.value : '',
		color: boardColorInput ? boardColorInput.value : ''
	});
	
	fetch('boards/update_board.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: formData
	}).then(r => r.json()).then(res => {
		if (!res.ok) {
			console.error('Failed to update board');
		}
	}).catch(() => {
		console.error('Failed to update board');
	});
}

document.querySelectorAll("form").forEach(form => {
	form.addEventListener("submit", function(event) {
		if (form.id !== 'newNote') {
			event.preventDefault();
		}
	})
})

const newNoteForm = document.getElementById('newNote');
if (newNoteForm) {
  const noteColInput = newNoteForm.querySelector('#noteCol');
  const pinColInput = newNoteForm.querySelector('#pinCol');
  const textarea = newNoteForm.querySelector('#insertContent');
  const submitButton = newNoteForm.querySelector('#insert');

  if (noteColInput && textarea) {
    noteColInput.addEventListener('input', () => {
      textarea.style.backgroundColor = noteColInput.value;
    });
  }

  if (pinColInput && submitButton) {
    pinColInput.addEventListener('input', () => {
      submitButton.style.backgroundColor = pinColInput.value;
    });
  }
}
