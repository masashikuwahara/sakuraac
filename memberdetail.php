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
      </div>

      <div class="penlight">
        ペンライトカラー：
        <div class="rounded" style="background-color: <?php echo $member_color1; ?>"><?php echo $member_colorname1; ?></div>
        <div class="rounded" style="background-color: <?php echo $member_color2; ?>"><?php echo $member_colorname2; ?></div>
      </div>

      <div class="info">
        <?php if($member_blog): ?>
          <p><a href="<?php echo $member_blog; ?>" target="_blank">ブログ</a></p>
        <?php endif; ?>
        <?php if($member_sns): ?>
          <p>SNS：<a href="<?php echo $member_sns; ?>" target="_blank"><img src="photos/instagramlogo.png" alt="instagram" class="insta" ></a></p>
        <?php endif; ?>
        <p>キャラクター：<?php echo nl2br(htmlspecialchars($member_introduction)); ?></p>
      </div>
    </div>
  </div>
  <?php
  // 例: 上の方で member_id を取得済みとしている想定
  $sql = 'SELECT songs.id, songs.title, song_members.is_center
    FROM song_members
    JOIN songs ON song_members.song_id = songs.id
    WHERE song_members.member_id = ?
    ORDER BY songs.id ASC';
  $stmt = $dbh->prepare($sql);
  $stmt->execute([$member_id]); // ここで $id は該当メンバーのID
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

  <script>
    function showAllSongs() {
      document.querySelectorAll('.song-item').forEach(item => {
        item.style.display = 'list-item';
      });
    }

    function showCenterSongs() {
      document.querySelectorAll('.song-item').forEach(item => {
        if (item.classList.contains('center-song')) {
          item.style.display = 'list-item';
        } else {
          item.style.display = 'none';
        }
      });
    }
  </script>


  <?php require('partial/footer.php'); ?>