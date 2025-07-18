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
                  echo "<div class='result-card'><a href='memberdetail.php?id={$id}'><img src='images/{$img}'><p class='result-title'>{$name}</p></a></div>";
              } else {
                  $img = htmlspecialchars($r['photo'], ENT_QUOTES, 'UTF-8');
                  $title = htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8');
                  $id = (int)$r['id'];
                  echo "<div class='result-card'><a href='songdetail.php?id={$id}'><img src='photos/{$img}'><p class='result-title'>{$title}</p></a></div>";
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

  <h2 class="search-form">もう一度検索する</h2>
<form method="GET" action="search.php" class="search-form">
  <div class="radio-group">
    <input type="radio" id="member" class="option-input" name="select" value="member" checked>
    <label for="member" class="radio-label">メンバーを検索</label>

    <input type="radio" id="song" class="option-input" name="select" value="song">
    <label for="song" class="radio-label">楽曲を検索</label>
  </div>
  
  <div class="search-input-group">
    <input class="search-input" type="text" name="s" placeholder="メンバー名、楽曲で検索">
    <button type="submit" class="search-button">検索</button>
  </div>
</form>

<?php include('partial/footer.php') ?>