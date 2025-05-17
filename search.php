<?php include('partial/top.php') ?>
<link rel="stylesheet" href="css/search.css">

<title>検索結果</title>

<?php include('partial/header.php') ?>

<div class="search-result">
  <?php
  try {
      require('connect.php');
  } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }

  $search_query = isset($_GET['s']) ? trim($_GET['s']) : '';
  $select_type = isset($_GET['select']) ? $_GET['select'] : 'member';

  if ($search_query !== '') {
      echo "<div class='result-info'>「" . htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8') . "」の検索結果</div>";

      if ($select_type === 'member') {
          // メンバー検索（名前またはふりがな）
          $stmt = $dbh->prepare("SELECT * FROM members WHERE name LIKE :keyword OR furigana LIKE :keyword");
          $stmt->bindValue(':keyword', '%' . $search_query . '%', PDO::PARAM_STR);
      } else {
          // 楽曲検索（タイトル）
          $stmt = $dbh->prepare("SELECT * FROM songs WHERE title LIKE :keyword");
          $stmt->bindValue(':keyword', '%' . $search_query . '%', PDO::PARAM_STR);
      }

      $stmt->execute();
      $t = $stmt->rowCount();

      if ($t > 0) {
          echo "<div class='result-info'>{$t}件見つかりました</div>";
          echo "<div class='results'>";
          while ($r = $stmt->fetch()) {
              if ($select_type === 'member') {
                  $img = htmlspecialchars($r['image'], ENT_QUOTES, 'UTF-8');
                  $name = htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8');
                  $id = (int)$r['id'];
                  echo "<div class='member-card'><a href='memberdetail.php?id={$id}'><img src='images/{$img}'><p>{$name}</p></a></div>";
              } else {
                  $img = htmlspecialchars($r['photo'], ENT_QUOTES, 'UTF-8');
                  $title = htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8');
                  $id = (int)$r['id'];
                  echo "<div class='song-card'><a href='songdetail.php?id={$id}'><img src='photos/{$img}'><p class='song-title'>{$title}</p></a></div>";
              }
          }
      } else {
        echo "<div class='result-info-error'>そのキーワードでは見つかりませんでした</div>";
      }
    } else {
        echo "<div class='result-info-error'>キーワードを入力してください</div>";
    }
    echo "</div>";
  ?>
  </div>
  <h2 class="search-form">もう一度検索</h2>
  <form  method="GET" action="search.php" class="search-form">
    <label><input type="radio" class="option-input" name="select" value="member" checked>メンバーを検索</label>
    <label><input type="radio" class="option-input" name="select" value="song" >楽曲を検索</label><br />
    <input class="sea" type="text" name="s" placeholder="メンバー名、楽曲名を入力">
    <button type="submit">検索</button>
  </form>
  <script src="https://unpkg.com/scrollreveal"></script>
  <script>
  ScrollReveal().reveal('.result-card',{
    duration: 800,
    viewFactor: 0.2,
  });
  </script>

<?php include('partial/footer.php') ?>