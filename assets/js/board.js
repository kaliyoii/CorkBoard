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
	let ix = 0, iy = 0, il = 0, it = 0;
	let pressed = false;
	let menuOpen = false;

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

		pressed = false;
		moving = false;
	}

	function deleteAlert(e) {
		const result = confirm("Delete this note?");
		if (result) {
		console.log("Confirmed");
		} else {
		console.log("Cancelled");
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

document.querySelectorAll("form").forEach(form => {
  form.addEventListener("submit", function(event) {
    event.preventDefault();})})
