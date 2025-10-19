<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Notes</title>
    <link rel="stylesheet" href="assets/css/board.css">
</head>
<body>
    
  <div class="stage" id="stage">

      <form spellcheck="false" class="item" style="left:9600px; top:9600px">
        <div class="menu" id="editNote">
          <div>
            <button class="delete" id="deleteButton"><ion-icon name="trash-outline"></ion-icon></button>
          </div>
          <div>
            <input type="color" name="noteCol" id="noteColEdit" value="#ffffff">
            <input type="color" name="pinCol" id="pinColEdit" value="#ce3838">
          </div>
        </div>
        <button class="pin"></button>
          <textarea name="content" id="editContent">awawawa</textarea>
      </form>

  </div>
  
  <div class="sidebar" id="sidebar">
    <button class="hide-sidebar" id="hideSidebar">></button>
    <form spellcheck="false" id="board" class="board-form">
      <input type="color" name="color" id="boardColor" value="#9c7d52">
      <input type="text" name="title" id="boardTitle" placeholder="Board title">
    </form>
    <form spellcheck="false" id="newNote">
      <h2>Add new note</h2>
      <div class="new-note">
        <button type="submit" id="insert"><ion-icon name="add-outline"></ion-icon></button>
        <textarea name="content" id="insertContent" placeholder="Note content here..."></textarea>
      </div>
      <div class="color-option">
        <div>
          <input type="color" name="noteCol" id="noteCol" value="#ffffff">
          <label for="noteCol">Note color</label>
        </div>
        <div>
          <input type="color" name="pinCol" id="pinCol" value="#ce3838">
          <label for="pinCol">Pin color</label>
        </div>
      </div>
    </form>
    <a href="#" class="home-button">Home</a>
  </div>

  <div class="controls" id="zoom-controls">
    <button id="reCenter" title="Re-center"><ion-icon name="locate-outline"></ion-icon></button>
    <button id="zoomIn" title="Zoom in"><ion-icon name="add-outline"></ion-icon></button>
    <button id="zoomOut" title="Zoom out"><ion-icon name="remove-outline"></ion-icon></button>
    <!-- <button id="help" title="Help"><ion-icon name="help-outline"></ion-icon></button> -->
  </div>
  <script src="assets/js/board.js"></script>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
