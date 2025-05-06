<?php

//メンバー詳細 
if(isset($_POST['disp']) === true)
{
	if(isset($_POST['id']) === false)
	{
		header('Location:members_ng.php');
		exit();
	}
	$id=$_POST['id'];
	header('Location: members_disp.php?id='.$id);
	exit();
}

// メンバー追加
if(isset($_POST['add']) === true)
{
	header('Location: members_add.php');
	exit();
}

// メンバー修正
if(isset($_POST['edit']) === true)
{
	if(isset($_POST['id']) === false)
	{
		header('Location:members_ng.php');
		exit();
	}
	$id=$_POST['id'];
	header('Location:members_edit.php?id='.$id);
	exit();
}

//メンバー削除
if(isset($_POST['delete']) === true)
{
	if(isset($_POST['id']) === false)
	{
		header('Location:members_ng.php');
		exit();
	}
	$id=$_POST['id'];
	header('Location:pro_delete.php?id='.$id);
	exit();
}

?>