<?php include('partial/top.php') ?>

<title>メンバー一覧</title>

<?php include('partial/header.php') ?>

<main class="members-container">
  <button class="accordion-toggle">並び替え</button>
  <div class="sort-buttons">
    <a href="members.php?sort=furigana">50音順</a>
    <a href="members.php?sort=birth">誕生日順</a>
    <a href="members.php?sort=blood">血液型順</a>
    <a href="members.php?sort=height">身長順</a>
    <a href="members.php">デフォルトに戻す</a>
  </div>

  <?php
  $sort_column = 'id';
  $display_field = '';
  $grades = ['一期生', '二期生', '三期生', '四期生'];

  if (isset($_GET['sort'])) {
    $allowed_sorts = ['furigana', 'birth', 'blood', 'height'];
    $sort = $_GET['sort'];
    if (in_array($sort, $allowed_sorts)) {
      if ($sort === 'blood') {
        $sort_column = "FIELD(blood, 'A', 'B', 'O', 'AB')";
      } else {
        $sort_column = $sort;
      }
      $display_field = $sort;
    }
  }

  try {
    require('connect.php');
    $dbh->query('SET NAMES utf8');

    foreach ([0 => '在籍メンバー', 1 => '卒業メンバー'] as $graduation => $label) {
      echo '<section>';
      echo '<h2 class="section-title">' . $label . '</h2>';

      foreach ($grades as $grade) {
        $sql = "SELECT id, name, image, furigana, birth, blood, height, grade FROM members WHERE graduation = :grad AND grade = :grade ORDER BY $sort_column ASC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':grad', $graduation, PDO::PARAM_INT);
        $stmt->bindValue(':grade', $grade, PDO::PARAM_STR);
        $stmt->execute();

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($members) > 0) {
          echo '<h3 class="grade-title">' . htmlspecialchars($grade) . '</h3>';
          echo '<div class="member-list">';

          foreach ($members as $rec) {
            echo '<div class="member-card">';
            echo '<a href="memberdetail.php?id=' . $rec['id'] . '">';
            if ($rec['image'] !== '') {
              echo '<img src="images/' . htmlspecialchars($rec['image']) . '" alt="' . htmlspecialchars($rec['name']) . '">';
            }
            echo '<p>' . htmlspecialchars($rec['name']) . '</p>';

            if ($display_field) {
              echo '<p class="extra-info">';
              switch ($display_field) {
                case 'furigana':
                  echo htmlspecialchars($rec['furigana']);
                  break;
                case 'birth':
                  $date = new DateTime($rec['birth']);
                  echo $date->format('Y年n月j日');
                  break;
                case 'blood':
                  echo htmlspecialchars($rec['blood']);
                  break;
                case 'height':
                  echo htmlspecialchars($rec['height']) . 'cm';
                  break;
              }
              echo '</p>';
            }
            echo '</a></div>';
          }
          echo '</div>'; // .member-list
        }
      }
      echo '</section>';
    }

    $dbh = null;
  } catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>
</main>

<button id="back-to-top" title="トップへ戻る">↑</button>

<script src="script/sort.js"></script>

<?php include('partial/footer.php') ?>