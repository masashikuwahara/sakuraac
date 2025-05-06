<?php include('partial/top.php') ?>

<title>楽曲一覧</title>

<?php include('partial/header.php') ?>

  <?php
  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');

    $dbh = null;
  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
  ここに楽曲一覧
</main>

<?php include('partial/footer.php') ?>
</body>
</html>