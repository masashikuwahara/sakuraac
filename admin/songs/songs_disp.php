<?php
require_once('../library.php');
session();

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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $songs_title; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1><?php echo $songs_title; ?></h1>
    </header>
    <main>
        <?php
        try{
            $dbh = null;

            if($songs_photo === '')
            {
                $disp_image='';
            }
            else
            {
                $disp_image='<img style="width:360px" src="../../photos/'.$songs_photo.'" class="pic" >';
            }
        }
        catch (Exception $e)
        {
            echo'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }

        ?>
        <?php echo $disp_image;?>
            <div class="content">
                <h2>リリース日</h2>
                <?php echo $songs_release_date;?>
                <br />
                <h2>作詞</h2>
                <?php echo $songs_lyricist;?>
                <br />
                <h2>作曲</h2>
                <?php echo $songs_composer;?>
                <br />
                <h2>編曲</h2>
                <?php echo $songs_arranger;?>
                <br />
                <h2>収録</h2>
                <?php echo $songs_is_recorded;?>
                <br />
                <h2>歌詞</h2>
                <?php echo $songs_lyric;?>
                <br />
                <h2>タイトルソング？</h2>
                <?php echo $songs_titlesong;?><br>
                1:表題曲
                2:カップリング曲
                3:アルバム収録曲
                <br />
                <h2>MV</h2>
                <?php echo $songs_youtube;?>
                <br />
                <br />
            </div>
        <form>
            <input class="btn" type="button" onclick="history.back()" value="戻る">
        </form>
    </main>
<?php include("../partial/footer.php") ?>
</body>
</html>