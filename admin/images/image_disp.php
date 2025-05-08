<?php
require_once('../library.php');
session();

$member_id=$_GET['id'];

require('../connect.php');
$dbh->query('SET NAMES utf8');
$sql = 'SELECT id, name, image FROM members WHERE id=?';
$stmt = $dbh->prepare($sql);
$data[]=$member_id;
$stmt->execute($data);

$mem = $stmt->fetch(PDO::FETCH_ASSOC);
$member_id = $mem['id'];
$member_name = $mem['name'];
$member_imageold = $mem['image'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $member_name; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1><?php echo $member_name; ?></h1>
    </header>
    <main>
        <?php
        try{

            $dbh = null;

            if($member_imageold === '')
            {
                $disp_image='';
            }
            else
            {
                $disp_image='<img style="width:360px" src="../../images/'.$member_imageold.'" class="pic" >';
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
                <h2>画像の変更</h2>
                <br />
            </div>
            <form method="post" action="image_check.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $member_id; ?>">
                <input type="hidden" name="member_imageold" value="<?php echo $member_imageold;?>">
                    画像を選んでください。<br />
                    <input type="file" name="img" ><br /><br />
                <input class="btn" type="button" onclick="history.back()"value="戻る">
                <input class="btn" type="submit" value="次のページへ">
            </form>
    </main>
<?php include("../partial/footer.php") ?>