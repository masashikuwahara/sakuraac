<?php include('partial/top.php') ?>

<title>楽曲一覧</title>

<?php include('partial/header.php') ?>

<main class="members-container">
  <h2 class="section-title">楽曲一覧</h2>

  <?php
  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');

    // 表題曲（titlesong = 1）
    $stmt_title = $dbh->prepare('SELECT id, title, photo FROM songs WHERE titlesong = 1');
    $stmt_title->execute();

    echo '<section>';
    echo '<h3 class="subsection-title">表題曲</h3>';
    echo '<div class="song-list">';
    while ($rec = $stmt_title->fetch(PDO::FETCH_ASSOC)) {
      $img = $rec['photo'] !== '' 
        ? '<img src="photos/'.$rec['photo'].'" alt="'.$rec['title'].'">' 
        : '';
      echo '<div class="song-card">'.
            '<a href="songdetail.php?id='.$rec['id'].'">'.
              '<div class="song-image">'.$img.'</div>'.
              '<p class="song-title">'.$rec['title'].'</p>'.
            '</a>'.
           '</div>';
    }
    echo '</div>';
    echo '</section>';

    // アルバム曲（titlesong = 3）
    $stmt_title = $dbh->prepare('SELECT id, title, photo FROM songs WHERE titlesong = 3');
    $stmt_title->execute();

    echo '<section>';
    echo '<h3 class="subsection-title">アルバム曲</h3>';
    echo '<div class="song-list">';
    while ($rec = $stmt_title->fetch(PDO::FETCH_ASSOC)) {
      $img = $rec['photo'] !== '' 
        ? '<img src="photos/'.$rec['photo'].'" alt="'.$rec['title'].'">' 
        : '';
      echo '<div class="song-card">'.
            '<a href="songdetail.php?id='.$rec['id'].'">'.
              '<div class="song-image">'.$img.'</div>'.
              '<p class="song-title">'.$rec['title'].'</p>'.
            '</a>'.
           '</div>';
    }
    echo '</div>';
    echo '</section>';

    // その他の楽曲（titlesong = 0）
    $stmt_other = $dbh->prepare('SELECT id, title, photo FROM songs WHERE titlesong = 0');
    $stmt_other->execute();

    echo '<section>';
    echo '<h3 class="subsection-title">その他の楽曲</h3>';
    echo '<div class="song-list">';
    while ($rec = $stmt_other->fetch(PDO::FETCH_ASSOC)) {
      $img = $rec['photo'] !== '' 
        ? '<img src="photos/'.$rec['photo'].'" alt="'.$rec['title'].'">' 
        : '';
      echo '<div class="song-card">'.
            '<a href="songdetail.php?id='.$rec['id'].'">'.
              '<div class="song-image">'.$img.'</div>'.
              '<p class="song-title">'.$rec['title'].'</p>'.
            '</a>'.
           '</div>';
    }
    echo '</div>';
    echo '</section>';

    $dbh = null;

  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
</main>
<button id="back-to-top" title="トップへ戻る">↑</button>
<?php include('partial/footer.php') ?>
