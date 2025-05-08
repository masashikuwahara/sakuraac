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
    <title>変更内容確認</title>
</head>
<body>
<header>
    <h1>変更内容確認</h1>
</header>
<main>
<div class="content">
    <?php
    $post=sanitize($_POST);
    $member_id=$post['id'];
    $member_imageold=$post['member_imageold'];
    $member_image=$_FILES['img'];

    if( $member_image['size']>0)
    {
        if( $member_image['size']>1000000)
        {
            echo'<p style="color:#ff0000">画像が大きすぎます。</p><br />';
        }
        else
        {
            move_uploaded_file($member_image['tmp_name'],'../../images/'.$member_image['name']);
            echo'<img src="../../images/'.$member_image['name'].'" width="250" >';
            echo'<br />';
        }
    } 
    else 
    {
        echo'<p style="color:#ff0000">画像を選択してください。</p><br />';
    }
    
    if($member_image['size']>1000000 || !$member_image['size'])
    {
        echo'<form>';
        echo'<input class="btn" type="button" onclick="history.back()" value="戻る">';
        echo'</form>';
    }
    else
    {
        echo'上記の内容に変更します。<br />';
        echo'<form method="post" action="image_changed.php">';
        echo'<input type="hidden" name="id" value="'.$member_id.'">';
        echo'<input type="hidden" name="member_imageold" value="'.$member_imageold.'">';
        echo'<input type="hidden" name="img" value="'.$member_image['name'].'">';
        echo'<br />';
        echo'<input class="btn" type="button" onclick="history.back()" value="戻る">&nbsp;';
        echo'<input class="btn" type="submit" value="決定する">';
        echo'</form>';
    }
    ?>
    </div>
</main>
<?php include("../partial/footer.php") ?>