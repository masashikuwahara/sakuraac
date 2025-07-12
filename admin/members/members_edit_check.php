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
    <title>修正内容確認</title>
</head>
    <style>
        .colorname1 {
            display: inline-block;
            width: 800px;
            overflow-wrap: break-word;
        }
    </style>
<body>
<header>
    <h1>修正内容確認</h1>
</header>
<main>
    <?php

    $mem=sanitize($_POST);
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
    $members_introduction = $mem['introduction'];
    $members_blog = $mem['blog'];

    if($members_name === '')
    {
        echo'<p style="color:#ff0000">名前が入力されていません。</p><br />';
    }
    else
    {
        echo'名前:';
        echo$members_name;
        echo'<br />';
    }

    if($members_furigana === '')
    {
        echo'<p style="color:#ff0000">ふりがなが入力されていません。</p><br />';
    }
    else
    {
        echo'ふりがな:';
        echo$members_furigana;
        echo'<br />';
    }

    if($members_nickname === '')
    {
        echo'<p style="color:#ff0000">ニックネームが入力されていません。</p><br />';
    }
    else
    {
        echo'ニックネーム:';
        echo$members_nickname;
        echo'<br />';
    }

    if($members_birth === '')
    {
        echo'<p style="color:#ff0000">誕生日が入力されていません。</p><br />';
    }
    else
    {
        echo'誕生日:';
        echo$members_birth;
        echo'<br />';
    }

    if($members_constellation === '')
    {
        echo'<p style="color:#ff0000">星座が入力されていません。</p><br />';
    }
    else
    {
        echo'星座:';
        echo$members_constellation;
        echo'<br />';
    }

    if($members_height === '')
    {
        echo'<p style="color:#ff0000">身長が入力されていません。</p><br />';
    }
    else
    {
        echo'身長:';
        echo$members_height;
        echo'<br />';
    }

    if($members_blood === '')
    {
        echo'<p style="color:#ff0000">血液型が入力されていません。</p><br />';
    }
    else
    {
        echo'血液型:';
        echo$members_blood;
        echo'<br />';
    }

    if($members_birthplace === '')
    {
        echo'<p style="color:#ff0000">出身地が入力されていません。</p><br />';
    }
    else
    {
        echo'出身地:';
        echo$members_birthplace;
        echo'<br />';
    }    

    
    if($members_color1 === '')
    {
        echo'<p style="color:#ff0000">ペンライトカラー1が入力されていません。</p><br />';
    }
    else
    {
        echo'ペンライトカラー1:';
        echo$members_color1;
        echo'<br />';
    }    

    
    if($members_colorname1 === '')
    {
        echo'<p style="color:#ff0000">ペンライトカラーコード1が入力されていません。</p><br />';
    }
    else
    {
        echo'ペンライトカラーコード1:';
        echo $members_colorname1;
        echo'<br />';
    }    

    if($members_color2 === '')
    {
        echo'<p style="color:#ff0000">ペンライトカラー2が入力されていません。</p><br />';
    }
    else
    {
        echo'ペンライトカラー2:';
        echo $members_color2;
        echo'<br />';
    }  

    if($members_colorname2 === '')
    {
        echo'<p style="color:#ff0000">ペンライトカラーコード2が入力されていません。</p><br />';
    }
    else
    {
        echo'ペンライトカラーコード2:';
        echo $members_colorname2;
        echo'<br />';
    }  

    if($members_sns === '')
    {
        echo'<p style="color:#ff0000">snsが入力されていません。</p><br />';
    }
    else
    {
        echo'sns:';
        echo $members_sns;
        echo'<br />';
    }  

    if($members_graduation === '')
    {
        echo'<p style="color:#ff0000">在籍or卒業が入力されていません。</p><br />';
    }
    else
    {
        echo'在籍or卒業:';
        echo $members_graduation;
        echo'<br />';
    }  

    if($members_introduction === '')
    {
        echo'<p style="color:#ff0000">キャラクターが入力されていません。</p><br />';
    }
    else
    {
        echo'キャラクター:';
        echo $members_introduction;
        echo'<br />';
    }  

    if($members_blog === '')
    {
        echo'<p style="color:#ff0000">ブログが入力されていません。</p><br />';
    }
    else
    {
        echo'ブログ:';
        echo $members_blog;
        echo'<br />';
    }  
        
    if($members_name === ''||$members_furigana === '')
    {
        echo'<form>';
        echo'<input class="btn" type="button" onclick="history.back()" value="戻る">';
        echo'</form>';
    }
    else
    {
        echo'上記の内容を追加します。<br />';
        echo'<form method="post" action="members_edit_done.php">';
        echo'<input type="hidden" name="id" value="'.$members_id.'">';
        echo'<input type="hidden" name="name" value="'.$members_name.'">';
        echo'<input type="hidden" name="furigana" value="'.$members_furigana.'">';
        echo'<input type="hidden" name="nickname" value="'.$members_nickname.'">';
        echo'<input type="hidden" name="birth" value="'.$members_birth.'">';
        echo'<input type="hidden" name="constellation" value="'.$members_constellation.'">';
        echo'<input type="hidden" name="height" value="'.$members_height.'">';
        echo'<input type="hidden" name="blood" value="'.$members_blood.'">';
        echo'<input type="hidden" name="birthplace" value="'.$members_birthplace.'">';
        echo'<input type="hidden" name="color1" value="'.$members_color1.'">';
        echo'<input type="hidden" name="colorname1" value="'.$members_colorname1.'">';
        echo'<input type="hidden" name="color2" value="'.$members_color2.'">';
        echo'<input type="hidden" name="colorname2" value="'.$members_colorname2.'">';
        echo'<input type="hidden" name="sns" value="'.$members_sns.'">';
        echo'<input type="hidden" name="graduation" value="'.$members_graduation.'">';
        echo'<input type="hidden" name="introduction" value="'.$members_introduction.'">';
        echo'<input type="hidden" name="blog" value="'.$members_blog.'">';
        echo'<br />';
        echo'<input class="btn" type="button" onclick="history.back()" value="戻る">&nbsp;';
        echo'<input class="btn" type="submit" value="決定する">';
        echo'</form>';
    }
    ?>
    </main>
    <?php include("../partial/footer.php") ?>
</body>
</html>