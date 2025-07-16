<?php
$member_id=$_GET['id'];

require('connect.php');
$dbh->query('SET NAMES utf8');
$sql = 'SELECT name, furigana, nickname, birth, constellation, height, blood, birthplace, 
 grade, color1, colorname1, color2, colorname2, sns, image, introduction, blog FROM members WHERE id=?';
$stmt = $dbh->prepare($sql);
$data[]=$member_id;
$stmt->execute($data);

$mem =$stmt->fetch(PDO::FETCH_ASSOC);
$member_name = $mem['name'];
$member_furigana = $mem['furigana'];
$member_nickname = $mem['nickname'];
$member_birth = $mem['birth'];
$member_constellation = $mem['constellation'];
$member_height = $mem['height'];
$member_blood = $mem['blood'];
$member_birthplace = $mem['birthplace'];
$member_grade = $mem['grade'];
$member_color1 = $mem['color1'];
$member_colorname1 = $mem['colorname1'];
$member_color2 = $mem['color2'];
$member_colorname2 = $mem['colorname2'];
$member_sns = $mem['sns'];
$member_image = $mem['image'];
$member_introduction = $mem['introduction'];
$member_blog = $mem['blog'];
?>
<?php include('partial/top.php') ?>
<link rel="stylesheet" href="css/memberdetail.css">

<title><?php echo $member_name;?></title>

<?php require('partial/header.php'); ?>
<?php
    try{

        if($member_image === '')
        {
            $disp_image = '';
        }
        else
        {
          $disp_image='<img src="images/'.$member_image.'" class="pic" >';
        }
    }
    catch (Exception $e)
    {
        echo'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }

    // 参加曲数を算出する部分
    $sql = "SELECT COUNT(*) AS total_songs,
      SUM(CASE WHEN is_center = 1 THEN 1 ELSE 0 END) AS center_count,
      SUM(CASE WHEN songs.titlesong = 1 THEN 1 ELSE 0 END) AS titlesong_count
      FROM song_members
      INNER JOIN songs ON song_members.song_id = songs.id
      WHERE song_members.member_id = ?
      ";
      $stmt = $dbh->prepare($sql);
      $stmt->execute([$member_id]);
      $stats = $stmt->fetch(PDO::FETCH_ASSOC);

      $total_songs = $stats['total_songs'];
      $center_count = $stats['center_count'];
      $titlesong_count = $stats['titlesong_count'];


    // 最新ブログのタイトルを取得
    if($member_blog) {
    // HTML取得
    $html = file_get_contents($member_blog);
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $xpath = new DOMXPath($doc);

    // col-l-wrap の中の unit を取得
    $units = $xpath->query('//div[contains(@class, "col-l-wrap")]//div[contains(@class, "member-blog-listm")]');

    $latestDate = null;
    $latestTitle = null;

    foreach ($units as $unit) {
        // 各 unit の中から日付とタイトルを取得
        $dateNode = $xpath->query('.//p[contains(@class, "date wf-a")]', $unit)->item(0);
        $titleNode = $xpath->query('.//h3[contains(@class, "title")]', $unit)->item(0);

        if ($dateNode && $titleNode) {
            $dateStr = trim($dateNode->nodeValue);
            $date = DateTime::createFromFormat('Y/m/d', $dateStr);

            if ($date && ($latestDate === null || $date > $latestDate)) {
                $latestDate = $date;
                $latestTitle = trim($titleNode->nodeValue);
            }
        }
    }
    }
?>
<div class="member-details">
  <h1><?php echo $member_name; ?></h1>
  <p class="furigana"><?php echo $member_furigana; ?></p>

  <div class="member-flex">
    <div class="member-image">
      <?php echo $disp_image; ?>
    </div>

    <div class="member-info">
      <div class="info">
        <p>あだ名：<?php echo $member_nickname; ?></p>
        <p>誕生日：<?php $date = new DateTime($member_birth); 
        echo $date->format('Y年n月j日'); ?></p>
        <p>星座：<?php echo $member_constellation; ?></p>
        <p>身長：<?php echo $member_height; ?>cm</p>
        <p>血液型：<?php echo $member_blood; ?></p>
        <p>出身地：<?php echo $member_birthplace; ?></p>
        <p>加入：<?php echo $member_grade; ?></p>
        <p>参加楽曲数：<?php echo $total_songs; ?>曲</p>
        <p>表題曲参加数：<?php echo $titlesong_count; ?>曲</p>
        <p>センター回数：<?php echo $center_count; ?>回</p>
      </div>

      <div class="penlight">
        ペンライトカラー：
        <div class="rounded" style="background-color: <?php echo $member_color1; ?>"><?php echo $member_colorname1; ?></div>
        <div class="rounded" style="background-color: <?php echo $member_color2; ?>"><?php echo $member_colorname2; ?></div>
      </div>

      <div class="info">
        <?php if(!empty($latestTitle)): ?>
          <p>最新ブログ：<a href="<?php echo $member_blog; ?>" target="_blank"><?php echo $latestTitle; ?> </a></p>
        <?php else: ?>
          <p>最新ブログ：<a href="<?php echo $member_blog; ?>" target="_blank"><?php echo $member_name; ?>のブログへ</a></p>
        <?php endif; ?>
        <?php if($member_sns): ?>
          <p>SNS：<a href="<?php echo $member_sns; ?>" target="_blank"><img src="photos/instagramlogo.png" alt="instagram" class="insta" ></a></p>
        <?php endif; ?>
        <?php if($member_introduction): ?>
          <p>キャラクター：<?php echo nl2br(htmlspecialchars($member_introduction)); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
  // 例: 上の方で member_id を取得済みとしている想定
  $sql = "SELECT songs.id, songs.title, song_members.is_center
    FROM song_members
    JOIN songs ON song_members.song_id = songs.id
    WHERE song_members.member_id = ?
    ORDER BY songs.id ASC";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([$member_id]);
  $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <div class="member-songs">
    <h2>参加楽曲</h2>

    <div class="filter-buttons">
      <button onclick="showAllSongs()">すべて表示</button>
      <button onclick="showCenterSongs()">センター曲のみ</button>
    </div>

    <?php if (count($songs) > 0): ?>
      <ul id="songList">
        <?php foreach ($songs as $song): ?>
          <li class="song-item <?php echo $song['is_center'] ? 'center-song' : ''; ?>">
            <a href="songdetail.php?id=<?php echo $song['id']; ?>">
              <?php echo htmlspecialchars($song['title']); ?>
            </a>
              <?php if ($song['is_center']): ?>
                <span class="center-label">（センター）</span>
              <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>参加楽曲は見つかりませんでした。</p>
    <?php endif; ?>
  </div>
</div>

<button id="back-to-top" title="トップへ戻る">TOP</button>
<script src="script/song.js"></script>
<?php require('partial/footer.php'); ?>