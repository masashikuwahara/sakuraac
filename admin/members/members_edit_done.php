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
    <title>修正しました</title>
</head>
<body>
<header>
    <h1>修正しました</h1>
</header>
<main>
    <?php
    try
    {
        $mem = ($_POST);
        $members_id = $mem['id'];
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

        require('../connect.php');

        $sql = 'UPDATE members SET name=?, furigana=?, nickname=?, birth=?, constellation=?, 
        height=?,blood=?, birthplace=?, color1=?, colorname1=?, color2=?, colorname2=?, sns=?,
        graduation=?, blog=? WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $members_name;
        $data[] = $members_furigana;
        $data[] = $members_nickname;
        $data[] = $members_birth;
        $data[] = $members_constellation;
        $data[] = $members_height;
        $data[] = $members_blood;
        $data[] = $members_birthplace;
        $data[] = $members_color1;
        $data[] = $members_colorname1;
        $data[] = $members_color2;
        $data[] = $members_colorname2;
        $data[] = $members_sns;
        $data[] = $members_graduation;
        $data[] = $members_blog;
        $data[] = $members_id;
        $stmt->execute($data);

        $dbh = null;
        
        $members_name = mb_convert_encoding($members_name, "UTF-8", "auto");
        echo $members_name.'を修正しました。<br />';
    }
    catch (Exception $e)
    {
        echo('Error:'.$e->getMessage());
        exit();
    }
    ?>
    <p class="btn-group"><a href="index.php" class="btn">トップメニューへ</a></p>
</main>
<?php include("../partial/footer.php") ?>
</body>
</html>
