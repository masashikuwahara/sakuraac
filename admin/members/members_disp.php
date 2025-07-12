<?php
require_once('../library.php');
session();

$members_id=$_GET['id'];

require('../../connect.php');
$dbh->query('SET NAMES utf8');
$sql = 'SELECT name, furigana, nickname, birth, constellation, height,
blood,birthplace, grade, color1, colorname1, color2, colorname2, sns,
image, graduation, introduction, blog FROM members WHERE id=?';
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
$members_grade = $mem['grade'];
$members_color1 = $mem['color1'];
$members_colorname1 = $mem['colorname1'];
$members_color2 = $mem['color2'];
$members_colorname2 = $mem['colorname2'];
$members_sns = $mem['sns'];
$members_image = $mem['image'];
$members_graduation = $mem['graduation'];
$members_introduction = $mem['introduction'];
$members_blog = $mem['blog'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $members_name; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1><?php echo $members_name; ?></h1>
    </header>
    <main>
        <?php
        try{
            $dbh = null;

            if($members_image === '')
            {
                $disp_image='';
            }
            else
            {
                $disp_image='<img style="width:360px" src="../../images/'.$members_image.'" class="pic" >';
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
                <h2>ふりがな</h2>
                <?php echo $members_furigana;?>
                <br />
                <h2>あだな</h2>
                <?php echo $members_nickname;?>
                <br />
                <h2>誕生日</h2>
                <?php
                $date = new DateTime($members_birth);
                echo $date->format('Y年n月j日');
                ?>
                <br />
                <h2>星座</h2>
                <?php echo $members_constellation;?>
                <br />
                <h2>身長</h2>
                <?php echo $members_height;?>㎝
                <br />
                <h2>血液型</h2>
                <?php echo $members_blood;?>
                <br />
                <h2>出身地</h2>
                <?php echo $members_birthplace;?>
                <br />
                <h2>何期生</h2>
                <?php echo $members_grade;?>
                <br />
                <h2>ペンライトカラー1</h2>
                <div class="rounded" style="background-color: <?php echo $members_color1;?>"><?php echo $members_color1;?></div>
                <?php echo $members_colorname1;?>
                <br />
                <h2>ペンライトカラー2</h2>
                <div class="rounded" style="background-color: <?php echo $members_color2;?>"><?php echo $members_color2;?></div>
                <?php echo $members_colorname2;?>
                <br />
                <h2>SNS</h2>
                <?php echo $members_sns;?>
                <br />
                <h2>在籍or卒業</h2>
                <?php
                if($members_graduation === 0){
                    echo "在籍";
                } else {
                    echo "卒業";
                }
                ?>
                <br />
                <h2>キャラクター</h2>
                <?php echo $members_introduction;?>
                <br />
                <h2>ブログ</h2>
                <?php echo $members_blog;?>
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