<?php
	include 'database.php';
	
	// idがあるかどうか
	if (!empty($_GET['id'])){
		
		// 登録処理
		if ($statement = $pdo->prepare("DELETE FROM `posts` WHERE `id` = {$_GET['id']}")) {
			$excuse = $statement->execute();
			
			if ($excuse)	$_SESSION['flash'] = array('message'=>'削除しました','class' => 'danger');
		}
	}
	
	header('Location: ./');
	exit;
	