<?php
session_start();
require_once __DIR__ . '/assets/object/koneksi.php';

// Check login session
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all boards created by this user
$stmt = $pdo->prepare("SELECT * FROM boards WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$boards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
            <form action="newboard.php" method="POST" class="new-board">
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

            <?php if (count($boards) > 0): ?>
                <?php foreach ($boards as $board): ?>
                    <div class="board-item">
                        <a href="board.php?id=<?= htmlspecialchars($board['id']) ?>">
                            <div>
                                <div class="board-col" style="background-color: <?= htmlspecialchars($board['color']) ?>;"></div>
                                <h3><?= htmlspecialchars($board['title']) ?></h3>
                            </div>
                            <span>Created at <?= date('d/m/Y', strtotime($board['created_at'])) ?></span>
                        </a>
                        <form action="delete_board.php" method="POST" style="display:inline;">
                            <input type="hidden" name="board_id" value="<?= $board['id'] ?>">
                            <button type="submit" id="delete">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #666;">You don't have any boards yet. Create one above!</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>&copy;<?= date('Y') ?> - KALIYOII & FLUNCKS</p>
    </div>

    <script src="assets/js/home.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
