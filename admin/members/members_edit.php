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

        $members_id=$_GET['id'];

        require('../connect.php');
        $dbh->query('SET NAMES utf8');
        $sql = 'SELECT name, furigana, nickname, birth, constellation, height,
        blood, birthplace, color1, colorname1, color2, colorname2, sns,
        graduation, blog
        FROM members WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $data[]=$members_id;
        $stmt->execute($data);
        
        $mem = $stmt->fetch(PDO::FETCH_ASSOC);
        $members_name = $mem['name'];
        $members_furigana = $mem['furigana'];
        $members_nickname = $mem['nickname'];
        $members_birth = $mem['birth'];
        $members_constellation = $mem['constellation'];
        $members_height = $mem['height'];
        $members_blood = $mem['blood'];
        $members_birthplace = $mem['birthplace'];
        $members_color1 = $mem['color1'];
        $members_colorname1 = $mem['colorname1'];
        $members_color2 = $mem['color2'];
        $members_colorname2 = $mem['colorname2'];
        $members_sns = $mem['sns'];
        $members_graduation = $mem['graduation'];
        $members_blog = $mem['blog'];

        $dbh = null;

    }
    catch (Exception $e)
    {
        echo'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }

    ?>
    <header>
        <h1><?php echo $members_name; ?></h1>
    </header>
    <main>
    <form method="post" action="members_edit_check.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $members_id; ?>">
      名前<br />
      <input class="tex" type="text" name="name" value="<?php echo $members_name; ?>"><br />
      ふりがな<br />
      <input class="tex" type="text" name="furigana" value="<?php echo $members_furigana; ?>"><br />
      ニックネーム<br />
      <input class="tex" type="text" name="nickname" value="<?php echo $members_nickname; ?>"><br />
      誕生日<br />
      <input class="tex" type="text" name="birth" value="<?php echo $members_birth; ?>"><br />
      星座<br />
      <input class="tex" type="text" name="constellation" value="<?php echo $members_constellation; ?>"><br />
      身長<br />
      <input class="tex" type="text" name="height" value="<?php echo $members_height; ?>"><br />
      血液型<br />
      <input class="tex" type="text" name="blood" value="<?php echo $members_blood; ?>"><br />
      出身地<br />
      <input class="tex" type="text" name="birthplace" value="<?php echo $members_birthplace; ?>"><br />
      ペンライトカラーコード1<br />
      <input class="tex" type="text" name="color1" value="<?php echo $members_color1; ?>"><br /><br />
      ペンライトカラー1<br />
      <input class="tex" type="text" name="colorname1" value="<?php echo $members_colorname1; ?>"><br /><br />
      ペンライトカラーコード2<br />
      <input class="tex" type="text" name="color2" value="<?php echo $members_color2; ?>"><br /><br />
      ペンライトカラー2<br />
      <input class="tex" type="text" name="colorname2" value="<?php echo $members_colorname2; ?>"><br /><br />
      SNS<br />
      <input class="tex" type="text" name="sns" value="<?php echo $members_sns; ?>"><br /><br />
      在籍or卒業<br />
      <input class="tex" type="text" name="graduation" value="<?php echo $members_graduation; ?>"><br /><br />
      ブログ<br />
      <input class="tex" type="text" name="blog" value="<?php echo $members_blog; ?>"><br /><br />
      <input class="btn" type="submit" value="次のページへ">
    </form>
    </main>
<?php include("../partial/footer.php") ?>
</body>
</html>