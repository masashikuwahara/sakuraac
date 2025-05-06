<?php
require_once('library.php');
session();
$userName = $_SESSION['user_name'] ?? 'ゲスト';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>管理パネル</title>
</head>
<body>
    <header>
        <h1>管理パネル</h1>
        <p class="welcome-message"><?php echo htmlspecialchars($userName, 
        ENT_QUOTES, 'UTF-8'); ?>さんログイン中</p>
    </header>
    <main>
        <ul class="menu">
            <li><a href="members/">メンバー管理ページ</a></li>
            <li><a href="images/">メンバー画像管理ページ</a></li>
            <li><a href="songs/">楽曲管理ページ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </main>
    <?php include("partial/footer.php") ?>