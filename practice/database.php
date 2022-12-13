<?php
	
	// データベース用変数セット
	$host = '';					// ホスト名
	$database_name = '';		// データベース名
	$user_name = '';			// ユーザー名
	$password = '';				// パスワード
	
	// セッションの使用
	session_start();
	
	
	// データベース接続処理（接続ができない場合処理停止）
	try {
		// 接続
		$pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database_name, $user_name, $password);
		
	}catch (PDOException $eroor){// エラーの場合
		echo "MySQL への接続に失敗しました。<br>(" . $eroor->getMessage() . ")";
		exit;
	}
?>