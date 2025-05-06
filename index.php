<?php include('partial/top.php') ?>

<title>櫻坂46データベースサイト(仮)</title>

<!-- accumulation -->
<?php include('partial/header.php') ?>
version 1.0.0-alpha
<main class="member-list">
  <?php
  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');
    
    // メンバー全員を取得してからランダムに7人選ぶ
    $sql = 'SELECT id, name, image FROM members';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;

    // 配列をシャッフルして先頭7人を取得
    shuffle($members);
    $selected_members = array_slice($members, 0, 8);

    foreach ($selected_members as $rec) {
      $img_name = $rec['image'] === '' ? '' : '<img src="images/'.$rec['image'].'" alt="'.$rec['name'].'">';
      echo '<div class="member-card">'.
              '<a href="memberdetails.php?id='.$rec['id'].'">'.
              $img_name.'<p>'.$rec['name'].'</p></a>'.
            '</div>';
    }
  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
  <div class="more-button-wrapper">
    <a href="members.php" class="more-button">もっと見る</a>
  </div>
</main>

<?php include('partial/footer.php') ?>