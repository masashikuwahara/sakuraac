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
    <title>登録しました</title>
</head>
<body>
<header>
    <h1>登録しました</h1>
</header>
<main>
    <?php
    try
    {
        $post=($_POST);
        $castles_cas=$post['cas'];
        $castles_title=$post['title'];
        $castles_structure=$post['structure'];
        $castles_tenshu=$post['tenshu'];
        $castles_builder=$post['builder'];
        $castles_year=$post['year'];
        $castles_lord=$post['lord'];
        $castles_remains=$post['remains'];
        $castles_specify1=$post['specify1'];
        $castles_recommend=$post['recommend'];
        $castles_prefectures=$post['prefectures'];
        $castles_explan=$post['explan'];
        $castles_access=$post['access'];
        $castles_img1=$post['img1'];
        $castles_img2=$post['img2'];
        $castles_img3=$post['img3'];
        $castles_img4=$post['img4'];
        $castles_img5=$post['img5'];

        require('../../connect.php');

        $sql = 'INSERT INTO castles (cas,title,structure,tenshu,builder,year,lord,
        remains,specify1,recommend,prefectures,explan,access,img1,img2,img3,img4,img5) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data[] = $castles_cas;
        $data[] = $castles_title;
        $data[] = $castles_structure;
        $data[] = $castles_tenshu;
        $data[] = $castles_builder;
        $data[] = $castles_year;
        $data[] = $castles_lord;
        $data[] = $castles_remains;
        $data[] = $castles_specify1;
        $data[] = $castles_recommend;
        $data[] = $castles_prefectures;
        $data[] = $castles_explan;
        $data[] = $castles_access;
        $data[] = $castles_img1;
        $data[] = $castles_img2;
        $data[] = $castles_img3;
        $data[] = $castles_img4;
        $data[] = $castles_img5;
        $stmt->execute($data);

        $dbh = null;
        
        $castles_title = mb_convert_encoding($castles_title, "UTF-8", "auto");
        echo $castles_title.'を登録しました。<br />';
    }
    catch (Exception $e)
    {
        echo('Error:'.$e->getMessage());
        exit();
    }
    
    ?>
    <p class="btn-group"><a href="index.php" class="btn">トップメニューへ</a></p>
</main>
<?php include("../footer.php") ?>
</body>
</html>
