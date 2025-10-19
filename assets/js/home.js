const boardItems = document.querySelectorAll('.board-item');
	boardItems.forEach(item => {
    const deleteButton = item.querySelector('#delete');

  function deleteAlert(e) {
      const result = confirm("Delete this board?");
      if (result) {
      console.log("Confirmed");
      } else {
      console.log("Cancelled");
      }
    }

  if (deleteButton) {
		deleteButton.addEventListener('click', deleteAlert);
	}
});