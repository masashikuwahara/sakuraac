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
    <title>メンバー画像管理ページ</title>
</head>
<body>
    <header>
        <h1>メンバー画像一覧</h1>
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
            
            $members = $dbh->prepare("SELECT id, name FROM members LIMIT {$start}, 10");
            $members->execute();
            $members = $members->fetchAll(PDO::FETCH_ASSOC);
            
            $page_num = $dbh->prepare("SELECT COUNT(*) FROM members");
            $page_num->execute();
            $pagination = ceil($page_num->fetchColumn() / 10);
        } catch (Exception $e) {
            echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
            exit();
        }
        ?>
        
        <form method="post" action="image_branch.php">
            <div class="btn-group">
                <input class="btn disabled" type="submit" name="add" disabled value="メンバーを追加">
            </div>
            <ul class="menu">
                <?php foreach ($members as $post): ?>
                    <li>
                        <label>
                            <input type="radio" name="id" value="<?= $post['id'] ?>">
                            <?= htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8') ?>
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
                <input class="btn disabled" type="submit" name="edit" disabled value="修正">
                <input class="btn disabled" type="submit" name="delete" disabled value="削除">
            </div>
        </form>
        
        <h2>メンバー名で検索する</h2>
        <form action="members_search.php" method="get">
            <input class="sea" type="text" name="s" placeholder="メンバー名">
            <div class="btn-group">
                <input class="btn" type="submit" value="検索">
            </div>
        </form>
        
        <p class="btn-group"><a href="../index.php" class="btn">トップメニューへ</a></p>
    </main>
    <?php include("../partial/footer.php") ?>