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
    <a href="members.php?sort=songs">参加楽曲数順</a>
    <a href="members.php?sort=center">センター回数順</a>
    <a href="members.php?sort=titlesong">表題曲参加数順</a>
    <a href="members.php">デフォルトに戻す</a>
  </div>

<?php
$sort_column = 'id';
$display_field = '';
$sort = $_GET['sort'] ?? '';
$sort_sql = '';
$grades = ['一期生', '二期生', '三期生', '四期生'];
$allowed_sorts = ['furigana', 'birth', 'blood', 'height', 'songs', 'center', 'titlesong'];

$sort_labels = [
  'furigana' => '50音順',
  'birth' => '誕生日順',
  'blood' => '血液型順',
  'height' => '身長順',
  'songs' => '参加楽曲数順',
  'center' => 'センター回数順',
  'titlesong' => '表題曲参加数順'
];

if (isset($sort_labels[$sort])) {
  echo '<p class="sort-info">現在は「' . $sort_labels[$sort] . '」でソートしています。</p>';
}

if (in_array($sort, $allowed_sorts)) {
  if ($sort === 'blood') {
    $sort_column = "FIELD(blood, 'A型', 'B型', 'O型', 'AB型', '不明')";
    $sort_sql = "SELECT * FROM members WHERE graduation = :grad ORDER BY $sort_column";
  } elseif ($sort === 'songs') {
    $sort_sql = "SELECT m.*, COUNT(sm.song_id) AS count 
            FROM members m
            LEFT JOIN song_members sm ON m.id = sm.member_id
            WHERE m.graduation = :grad
            GROUP BY m.id
            ORDER BY count DESC";
  } elseif ($sort === 'center') {
    $sort_sql = "SELECT m.*, SUM(sm.is_center) AS count 
            FROM members m
            LEFT JOIN song_members sm ON m.id = sm.member_id
            WHERE m.graduation = :grad
            GROUP BY m.id
            ORDER BY count DESC";
  } elseif ($sort === 'titlesong') {
    $sort_sql = "SELECT m.*, SUM(CASE WHEN s.titlesong = 1 THEN 1 ELSE 0 END) AS count
            FROM members m
            LEFT JOIN song_members sm ON m.id = sm.member_id
            LEFT JOIN songs s ON sm.song_id = s.id
            WHERE m.graduation = :grad
            GROUP BY m.id
            ORDER BY count DESC";
  } else {
    $sort_column = $sort;
    $sort_sql = "SELECT * FROM members WHERE graduation = :grad ORDER BY $sort_column";
  }
  $display_field = $sort;
}

try {
  require('connect.php');
  $dbh->query('SET NAMES utf8');

  foreach ([0 => '在籍メンバー', 1 => '卒業メンバー'] as $graduation => $label) {
    echo '<section>';
    echo '<h2 class="section-title">' . $label . '</h2>';

    if ($display_field) {
      // ★ ソートあり：期生分けずに全メンバー取得
      $sql = "SELECT id, name, image, furigana, birth, blood, height, grade, updated_at 
              FROM members 
              WHERE graduation = :grad 
              ORDER BY $sort_column ASC";
      $stmt = $dbh->prepare($sort_sql);
      $stmt->bindValue(':grad', $graduation, PDO::PARAM_INT);
      $stmt->execute();
      $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($members) {
        echo '<div class="member-list">';
        foreach ($members as $rec) {
          $updated_at = $rec['updated_at'];
          $now = new DateTime();
          $updated = new DateTime($updated_at);
          $diff = $now->diff($updated);
          $isNew = ($diff->days <= 3);

          echo '<div class="member-card">';
          echo '<a href="memberdetail.php?id=' . $rec['id'] . '">';
          if ($rec['image']) {
            echo '<img src="images/' . htmlspecialchars($rec['image']) . '" alt="' . htmlspecialchars($rec['name']) . '">';
          }
          echo '<p>' . htmlspecialchars($rec['name']);
          if ($isNew) {
            echo " <span class='new-badge' style='color: crimson; font-weight: bold;'>NEW!</span>";
          }
          echo '</p>';

          // 追加情報（ソート種別に応じて）
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
              case 'songs':
                echo '参加楽曲数：' . htmlspecialchars($rec['count']) . '曲';
                break;
              case 'center':
                echo 'センター回数：' . htmlspecialchars($rec['count']) . '回';
                break;
              case 'titlesong':
                echo '表題曲参加数：' . htmlspecialchars($rec['count']) . '曲';
                break;
            }
            echo '</p>';
          }

          echo '</a></div>';
        }
        echo '</div>'; // .member-list
      }
    } else {
      // ★ ソートなし：期生で分けて表示
      foreach ($grades as $grade) {
        $sql = "SELECT id, name, image, furigana, birth, blood, height, grade, updated_at 
                FROM members 
                WHERE graduation = :grad AND grade = :grade 
                ORDER BY id ASC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':grad', $graduation, PDO::PARAM_INT);
        $stmt->bindValue(':grade', $grade, PDO::PARAM_STR);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($members) {
          echo '<h3 class="grade-title">' . htmlspecialchars($grade) . '</h3>';
          echo '<div class="member-list">';
          foreach ($members as $rec) {
            $updated_at = $rec['updated_at'];
            $now = new DateTime();
            $updated = new DateTime($updated_at);
            $diff = $now->diff($updated);
            $isNew = ($diff->days <= 3);

            echo '<div class="member-card">';
            echo '<a href="memberdetail.php?id=' . $rec['id'] . '">';
            if ($rec['image']) {
              echo '<img src="images/' . htmlspecialchars($rec['image']) . '" alt="' . htmlspecialchars($rec['name']) . '">';
            }
            echo '<p>' . htmlspecialchars($rec['name']);
            if ($isNew) {
              echo " <span class='new-badge' style='color: crimson; font-weight: bold;'>NEW!</span>";
            }
            echo '</p>';
            echo '</a></div>';
          }
          echo '</div>'; // .member-list
        }
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

<script src="script/sort.js"></script>
<button id="back-to-top" title="トップへ戻る">TOP</button>
<?php include('partial/footer.php') ?>