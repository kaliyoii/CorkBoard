const boardItems = document.querySelectorAll('.board-item');

boardItems.forEach(item => {
  const deleteButton = item.querySelector('.delete-btn');
  
  if (deleteButton) {
    deleteButton.addEventListener('click', function(e) {
      const confirmed = confirm("Delete this board?");
      if (!confirmed) {
        e.preventDefault(); // stop form from submitting
      } else {
        console.log("Confirmed");
      }
    });
  }
});
