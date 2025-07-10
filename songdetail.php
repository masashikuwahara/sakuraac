<?php
$song_id = $_GET['id'];

require('connect.php');
$dbh->query('SET NAMES utf8');
$sql = 'SELECT id, title, release_date, lyricist, composer, arranger, is_recorded, lyric, titlesong, youtube, photo FROM songs WHERE id=?';
$stmt = $dbh->prepare($sql);
$data = [$song_id];
$stmt->execute($data);

$song = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$song) {
  echo '楽曲が見つかりませんでした。';
  exit();
}

$song_title = $song['title'];
$song_release_date = $song['release_date'];
$song_lyricist = $song['lyricist'];
$song_composer = $song['composer'];
$song_arranger = $song['arranger'];
$song_is_recorded = $song['is_recorded'];
$song_lyric = $song['lyric'];
$song_youtube = $song['youtube'];
$song_photo = $song['photo'];
?>

<?php include('partial/top.php') ?>

<link rel="stylesheet" href="css/songdetails.css">

<title><?php echo $song_title; ?></title>

<?php require('partial/header.php'); ?>

<div class="song-details">
  <div class="song-flex">
    <div class="song-image">
      <?php if ($song_photo !== ''): ?>
        <img src="photos/<?php echo $song_photo; ?>" alt="<?php echo $song_title; ?>">
      <?php endif; ?>
    </div>

    <div class="song-info">
      <h1><?php echo $song_title; ?></h1>
      <div class="info">
        <p>リリース日：<?php echo (new DateTime($song_release_date))->format('Y年n月j日'); ?></p>
        <p>作詞：<?php echo $song_lyricist; ?></p>
        <p>作曲：<?php echo $song_composer; ?></p>
        <p>編曲：<?php echo $song_arranger; ?></p>
        <p>収録：<?php echo $song_is_recorded; ?></p>
      </div>

      <?php if(!empty($song_lyric)): ?>
      <div class="extra-info">
        <h2>歌詞リンク</h2>
        <a href="<?php echo $song_lyric; ?>" target="_blank" rel="noopener">歌詞はこちら</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
// 同じ「収録作品」に属する他の楽曲を取得（現在の曲を除く）
try {
  require('connect.php');
  $dbh->query('SET NAMES utf8');

  $sql = 'SELECT id, title, photo FROM songs WHERE is_recorded = ? AND id != ?';
  $stmt = $dbh->prepare($sql);
  $stmt->execute([$song_is_recorded, $song_id]);

  $relatedSongs = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($relatedSongs)) {
    echo '<div class="song-details">';
    echo '<h2>同じ作品に収録されている楽曲</h2>';
    echo '<div class="song-list">';

    foreach ($relatedSongs as $song) {
      $img = $song['photo'] !== '' 
        ? '<img src="photos/'.$song['photo'].'" alt="'.$song['title'].'">' 
        : '';
      echo '<div class="song-card">'.
              '<a href="songdetail.php?id='.$song['id'].'">'.
                '<div class="song-image">'.$img.'</div>'.
                '<p class="song-title">'.$song['title'].'</p>'.
              '</a>'.
           '</div>';
    }

    echo '</div></div>';
  }

} catch (Exception $e) {
  echo '収録曲の取得時にエラーが発生しました。';
}
?>

<?php
try {
  require('connect.php');
  $dbh->query('SET NAMES utf8');

  $sql = 'SELECT members.id, members.name, members.image, song_members.is_center
          FROM song_members
          JOIN members ON song_members.member_id = members.id
          WHERE song_members.song_id = :song_id';
  
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':song_id', $song_id, PDO::PARAM_INT);
  $stmt->execute();

  $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo 'メンバー情報の取得中にエラーが発生しました。';
  exit();
}
?>

<?php if (!empty($members)): ?>
  <div class="song-details">
    <div class="extra-info">
      <h2>参加メンバー</h2>
      <div class="member-list">
        <?php foreach ($members as $member): ?>
          <div class="member-card">
            <a href="memberdetail.php?id=<?php echo $member['id']; ?>">
              <?php if (!empty($member['image'])): ?>
                <img src="images/<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
              <?php endif; ?>
              <p>
                <?php echo htmlspecialchars($member['name']); ?>
                <?php if ($member['is_center'] === 1): ?>
                  <div class="center-label">（センター）</div>
                <?php endif; ?>
              </p>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php endif; ?>


<?php if (!empty($song_youtube)): ?>
  <div class="song-details">
    <div class="extra-info">
      <h2>ミュージックビデオ</h2>
      <div class="video-wrapper">
        <?php
          $youtube_iframe = preg_replace('/<iframe/', '<iframe class="responsive-iframe"', $song_youtube);
          echo $youtube_iframe;
        ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require('partial/footer.php'); ?>
