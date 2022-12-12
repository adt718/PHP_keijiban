<?php
	include 'database.php';
	
	// POST送信があるかどうか
	if (!empty($_POST)){
		
		// 本文がなかった場合登録しない
		if (!empty($_POST['body'])){
			
			
			$name = '匿名';															// 必ず匿名
			$title = (empty($_POST['title']) ? '無題' : $_POST['title']);		// タイトルが無い場合「無題」挿入
			$body = $_POST['body'];
			
			// 登録処理
			if ($statement = $pdo->prepare("INSERT INTO `posts` (`id`, `name`, `title`, `body`, `date`) VALUES (NULL, '$name', '$title', '$body', NOW())")) {
				$excuse = $statement->execute();
				
				if ($excuse)	$_SESSION['flash'] = array('message'=>'登録しました','class' => 'success');
				else 			$_SESSION['flash'] = array('message'=>'登録できませんでした','class' => 'danger');
			}
		}else 					$_SESSION['flash'] = array('message'=>'本文が入力されておりません','class' => 'danger');
	}
	
	header('Location: ./');
	exit;
	