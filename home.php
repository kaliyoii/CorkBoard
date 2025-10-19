<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cork Board - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="home">
    <h1>Cork Board</h1>
    <div class="main">
        <div class="head">
            <form action="newboard.php" class="new-board">
                <h3>Create new board</h3>
                <div>
                    <input type="color" name="color" id="color" value="#9c7d52">
                    <input type="text" name="title" id="title" placeholder="Title" required>
                    <button type="submit">+</button>
                </div>
            </form>
            <a href="profile.php" class="profile"><ion-icon name="person-circle-outline"></ion-icon></a>
        </div>
        <div class="body">
            <h3 class="body-title">Your boards</h3>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

            <div class="board-item">
                <a href="board.php?id=">
                    <div class="board-col" style="background-color: #9c7d52;"></div>
                    <h3>Board Title</h3>
                </a>
                <button id="delete"><ion-icon name="trash-outline"></ion-icon></button>
            </div>

        </div>
    </div>
    <div class="footer">
        <p>&copy;<?=date('Y')?> - KALIYOII & FLUNCKS</p>
    </div>
    <script src="assets/js/home.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>