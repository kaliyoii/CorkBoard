<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I'm Trying ToT</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body id="body">
    <div class="board" id="board">

        <div class="note">
            <div class="note-head">
                <div class="pin"></div>
            </div>
            <div class="note-body">
                <p>ONE</p>
            </div>
        </div>

    </div>
    <div class="sidebar" id="sidebar">
        <div class="delete" id="delete">
                <ion-icon name="trash-outline"></ion-icon>
            <h3>
                Drag here to delete
            </h3>
        </div>
    </div>
        <div class="zoom-controls" id="zoom-controls">
        <button id="zoomIn">＋</button>
        <button id="zoomOut">－</button>
    </div>

    <div class="hint" id="hint">
        <span>Drag anywhere to pan. Double-click to reset.</span>
        <button id="closeHint">✕</button>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

<script src="assets/js/board.js"></script>  
</html>
