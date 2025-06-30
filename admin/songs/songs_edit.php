<?php
require_once('../library.php');
session();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <furigana>記事修正</furigana>
</head>
<body>
    <?php
    try{

        $songs_id=$_GET['id'];

        require('../../connect.php');
        $dbh->query('SET NAMES utf8');
        $sql = 'SELECT title, release_date, lyricist, composer, arranger, is_recorded,
        lyric,titlesong, youtube, photo FROM songs WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $data[]=$songs_id;
        $stmt->execute($data);
        
        $song = $stmt->fetch(PDO::FETCH_ASSOC);
        $songs_title = $song['title'];
        $songs_release_date = $song['release_date'];
        $songs_lyricist = $song['lyricist'];
        $songs_composer = $song['composer'];
        $songs_arranger = $song['arranger'];
        $songs_is_recorded = $song['is_recorded'];
        $songs_lyric = $song['lyric'];
        $songs_titlesong = $song['titlesong'];
        $songs_youtube = $song['youtube'];
        $songs_photo = $song['photo'];

        $dbh = null;

    }
    catch (Exception $e)
    {
        echo'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }

    ?>
    <header>
        <h1><?php echo $songs_title; ?></h1>
    </header>
    <main>
    <form method="post" action="songs_edit_check.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $songs_id; ?>">
      タイトル<br />
      <input class="tex" type="text" name="title" value="<?php echo $songs_title; ?>"><br />
      リリース日<br />
      <input class="tex" type="date" name="release" value="<?php echo $songs_release_date; ?>"><br />
      作詞<br />
      <input class="tex" type="text" name="lyricist" value="<?php echo $songs_lyricist; ?>"><br />
      作曲<br />
      <input class="tex" type="text" name="composer" value="<?php echo $songs_composer; ?>"><br />
      編曲<br />
      <input class="tex" type="text" name="arranger" value="<?php echo $songs_arranger; ?>"><br />
      収録<br />
      <input class="tex" type="text" name="is_recording" value="<?php echo $songs_is_recorded; ?>"><br />
      歌詞<br />
      <input class="tex" type="text" name="lyrics" value="<?php echo $songs_lyric; ?>"><br />
      タイトルソング？<br />
      <select name="titlesong" class="tex" value="<?php echo $songs_titlesong; ?>"><br />
        <option value="1" >表題曲</option>
        <option value="2" >カップリング曲</option>
        <option value="3" >アルバム曲</option>
      </select><br />
      MV<br />
      <textarea class="tex" name="youtube"><?php echo $songs_youtube; ?></textarea>
      <input class="btn" type="submit" value="次のページへ">
    </form>
    </main>
<?php include("../partial/footer.php") ?>
</body>
</html>