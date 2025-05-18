<?php include('partial/top.php') ?>

<title>櫻坂46データベースサイト(仮)</title>

<!-- accumulation -->
<?php include('partial/header.php') ?>
version 1.0.0-alpha
<form method="GET" action="search.php" class="search-form">
  <div class="radio-group">
    <input type="radio" id="member" class="option-input" name="select" value="member" checked>
    <label for="member" class="radio-label">メンバーを検索</label>

    <input type="radio" id="song" class="option-input" name="select" value="song">
    <label for="song" class="radio-label">楽曲を検索</label>
  </div>
  
  <div class="search-input-group">
    <input class="search-input" type="text" name="s" placeholder="メンバー名、楽曲名を入力">
    <button type="submit" class="search-button">検索</button>
  </div>
</form>

<main class="member-list">
  <!-- メンバー -->
  <?php
  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');

    // --- メンバー一覧表示 ---
    echo '<section class="member-section">';
    echo '<h2 class="section-title">メンバー</h2>';
    echo '<div class="member-list">';

    $sql = 'SELECT id, name, image FROM members';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 配列をシャッフルして先頭7人を取得
    shuffle($members);
    $selected_members = array_slice($members, 0, 8);

    foreach ($selected_members as $rec) {
      $img_name = $rec['image'] === '' ? '' : '<img src="images/'.$rec['image'].'" alt="'.$rec['name'].'">';
      echo '<div class="member-card">'.
            '<a href="memberdetail.php?id='.$rec['id'].'">'.
              $img_name.'<p>'.$rec['name'].'</p></a>'.
            '</div>';
    }

    echo '</div>';
    echo '<div class="more-button-wrapper">'.
            '<a href="members.php" class="more-button">もっと見る</a>'.
         '</div>';
    echo '</section>';
    
    // --- 楽曲一覧表示 ---
    echo '<section class="song-section">';
    echo '<h2 class="section-title">楽曲一覧</h2>';
    echo '<div class="member-list">';

    $sql = 'SELECT id, title, photo FROM songs';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;

    // 配列をシャッフルして先頭7人を取得
    shuffle($members);
    $selected_members = array_slice($members, 0, 8);

    foreach ($selected_members as $rec) {
      $img_name = $rec['photo'] === '' ? '' : '<img src="photos/'.$rec['photo'].'" alt="'.$rec['title'].'">';
      echo '<div class="member-card">'.
              '<a href="songdetail.php?id='.$rec['id'].'">'.
              $img_name.'<p>'.$rec['title'].'</p></a>'.
            '</div>';
    }

    echo '</div>';
    echo '<div class="more-button-wrapper">'.
            '<a href="songs.php" class="more-button">もっと見る</a>'.
          '</div>';
    echo '</section>';
  
  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
</main>

<?php include('partial/footer.php') ?>