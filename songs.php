<?php include('partial/top.php') ?>

<title>楽曲一覧</title>

<?php include('partial/header.php') ?>

  <?php
  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');
    $sql='SELECT id, title, photo FROM songs ';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    while(true)
    {
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if(!$rec)
      {
        break;
      }

      if($rec['photo'] === '')
      {
        $img_name = '';
      }
      else
      {
        $img_name = '<img style="width:360px" src="photos/'.$rec['photo'].'">';
      }

      echo '<span class="img_style">'.
          '<a href="songdetail.php?id='.$rec['id'].'">'.
          $img_name.
          '<br />'.
          $rec['title'].
            '</a>'.
          '<br />'.
          '</span>';
    }
  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
</main>

<?php include('partial/footer.php') ?>