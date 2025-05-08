<?php
$song_id=$_GET['id'];

require('connect.php');
$dbh->query('SET NAMES utf8');
$sql = 'SELECT id, title, release_date, lyricist, composer, arranger, 
is_recorded, lyric, titlesong, youtube, photo FROM songs WHERE id=?';
$stmt = $dbh->prepare($sql);
$data = [$song_id];
$stmt->execute($data);

$song =$stmt->fetch(PDO::FETCH_ASSOC);
$song_title = $song['title'];
$song_release_date = $song['release_date'];
$song_lyricist = $song['lyricist'];
$song_composer = $song['composer'];
$song_arranger = $song['arranger'];
$song_is_recorded = $song['is_recorded'];
$song_lyric = $song['lyric'];
$song_titlesong = $song['titlesong'];
$song_youtube = $song['youtube'];
$song_photo = $song['photo'];
?>
<?php include('partial/top.php') ?>

<link rel="stylesheet" href="css/memberdetails.css">
<title><?php echo $song_title;?></title>

<?php require('partial/header.php'); ?>
<?php
    try{

        if($song_photo === '')
        {
            $disp_photo = '';
        }
        else
        {
          $disp_photo = '<img src="photos/'.$song_photo.'" class="pic" >';
        }
    }
    catch (Exception $e)
    {
        echo'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }
?>
<div>
  <h1><?php echo $song_title; ?></h1>

  <div>
    <div>
      <?php echo $disp_photo; ?>
    </div>

    <div>
      <div>
        <p>リリース日：<?php $date = new DateTime($song_release_date); 
        echo $date->format('Y年n月j日'); ?></p>
        <p>作詞：<?php echo $song_lyricist; ?></p>
        <p>作曲：<?php echo $song_composer; ?></p>
        <p>編曲：<?php echo $song_arranger; ?></p>
        <p>収録：<?php echo $song_is_recorded; ?></p>
      </div>

      <div>
        <h2>歌詞</h2>
        <a href="<?php echo $song_lyric; ?>" target="_blank" rel="noopener">歌詞へのリンクはこちら</a>
      </div>

      <div>
        <h2>ミュージックビデオ</h2>
        <p><?php echo $song_youtube; ?></p>
      </div>

    </div>
  </div>
</div>
  <?php require('partial/footer.php'); ?>