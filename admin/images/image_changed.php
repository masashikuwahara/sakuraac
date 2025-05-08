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
        $post=($_POST);
        $member_id = $post['id'];
        $member_imageold = $post['member_imageold'];
        $member_image = $post['img'];

        require('../connect.php');

        $sql = 'UPDATE members SET image=? WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $member_image;
        $data[] = $member_id;
        $stmt->execute($data);

        $dbh = null;

        if($member_imageold !=$member_image)
        {
            if($member_imageold !='')
            {
                unlink('../../images/'.$member_imageold);
            }
        }

        echo '画像を変更しました。<br />';
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