<?php
require_once('../library.php');
session();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>楽曲管理ページ</title>
</head>
<body>
    <header>
        <h1>楽曲一覧</h1>
    </header>
    <main>
        <?php
        try {
            require('../../connect.php');
            $dbh->query('SET NAMES utf8');
            
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            } else {
                $page = 1;
            }
            
            $start = ($page > 1) ? ($page * 10) - 10 : 0;
            
            $songs = $dbh->prepare("SELECT id, title FROM songs LIMIT {$start}, 10");
            $songs->execute();
            $songs = $songs->fetchAll(PDO::FETCH_ASSOC);
            
            $page_num = $dbh->prepare("SELECT COUNT(*) FROM songs");
            $page_num->execute();
            $pagination = ceil($page_num->fetchColumn() / 10);
        } catch (Exception $e) {
            echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
            exit();
        }
        ?>
        
        <form method="post" action="songs_branch.php">
            <div class="btn-group">
                <input class="btn disabled" type="submit" name="add" disabled value="楽曲を追加">
            </div>
            <ul class="menu">
                <?php foreach ($songs as $post): ?>
                    <li>
                        <label>
                            <input type="radio" name="id" value="<?= $post['id'] ?>">
                            <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="pagination">
                <?php for ($x = 1; $x <= $pagination; $x++): ?>
                    <a href="?page=<?= $x ?>" class="btn"><?= $x ?></a>
                <?php endfor; ?>
            </div>
            <div class="btn-group">
                <input class="btn" type="submit" name="disp" value="参照">
                <input class="btn" type="submit" name="edit" value="修正">
                <input class="btn disabled" type="submit" name="delete" disabled value="削除">
            </div>
        </form>
        
        <h2>楽曲名で検索する</h2>
        <form action="songs_search.php" method="get">
            <input class="sea" type="text" name="s" placeholder="楽曲名">
            <div class="btn-group">
                <input class="btn" type="submit" value="検索">
            </div>
        </form>
        
        <p class="btn-group"><a href="../index.php" class="btn">トップメニューへ</a></p>
    </main>
    <?php include("../partial/footer.php") ?>
</body>
</html>
