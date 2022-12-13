<?php
	include 'database.php';
	
	
	///////////////////////////// ページング取得/////////////////////////////
	
	// テーブルのカラム数取得（deleteでデータ削除する前提）
	$pdo_query = $pdo->prepare("SELECT COUNT(*) FROM posts");		// クエリセット
	$result = $pdo_query->execute();									// クエリ実行
	// データ総数取得（処理が正常じゃない場合0格納）
	if ($result){
			$result_data = $pdo_query->fetch();
			$count = (int)$result_data[0];
	}else	$count = 0;
	
	$perPage = 20; // １ページあたりのデータ件数
	$totalPage = ceil($count / $perPage); // 最大ページ数
		
	$page = (!empty($_GET['page']) ? (int) $_GET['page'] : 1);
	
	// 前のページ番号は1と比較して大きい方を使う
	$prev = max($page - 1, 1);
	
	// 次のページ番号は最大ページ数と比較して小さい方を使う
	$next = min($page + 1, $totalPage);
	
	
	$pageRange = 2; // $pageから前後に表示するページ番号の数
	$start = max($page - $pageRange, 1);
	$end = min($page + $pageRange, $totalPage);
	
	// １ページ目の場合(表示ページ数の2倍)
	if ($page === 1){
		$end = min($pageRange * 2, $totalPage);; // 終点再計算
	}
	// ページ番号格納
	for ($i = $start; $i <= $end; $i++) {
		$nums[] = $i;
	}
	
	
	
	//////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////投稿データ取得/////////////////////////////
	
	// 現在のページ数に応じた内容取得（取得失敗はから配列）
	$pdo_query = $pdo->prepare("SELECT * FROM `posts` ORDER BY `date` DESC LIMIT ".$perPage." OFFSET ".($perPage * ($page - 1)));		// SQL
	$result = $pdo_query->execute();																										// クエリ実行
	$post_data = ($result ? $pdo_query->fetchAll() : array());
	
	//////////////////////////////////////////////////////////////////////////
	
?>




<!DOCTYPE html>
<html lang="ja">
<head>
	
	<!-- メタタグ -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- タイトル -->
	<title>掲示板</title>
	
	<!-- CSS -->
	<link rel="stylesheet" href="css/common.css">
	
</head>
<body>
	<main>
		<?php if ($_SESSION['flash']){
			echo '<div class="flash '.$_SESSION['flash']['class'].'">'.$_SESSION['flash']['message'].'</div>';
			
			// SESSION初期化
			$_SESSION['flash'] = '';
		}?>
		
		<form action="post.php" method="post">
			<div class="input_wrap">
			
				<label><input name="title" class="title" placeholder="タイトル"></label>
				<label><textarea name="body" placeholder="本文を入力してください"></textarea></label>
				<input type="submit" value="投稿">
			</div>
		</form>
		<div class="post_area">
			<?php 
				if (!empty($post_data)){
					foreach ($post_data as $post){
						
						echo '<div class="post">';
						
						echo '<div class="name_area">';
						
						echo '<p class="name">'.$post['name'].'</p>';
						echo '<a href="delete.php?id='.$post['id'].'" class="delete">削除</a>';
						
						echo '</div>';
						echo '<p class="title">'.htmlspecialchars($post['title']).'</p>';
						echo '<p class="body">'.htmlspecialchars($post['body']).'</p>';
						
						echo '</div>';
						
						
					}
				}
			?>
			
			
			<ul class="pageing">
				<?php 
					if (!empty($nums)){
						foreach ($nums as $num){
							echo '<li><a href="?page='.$num.'"'.($page == $num ? 'class="active"': '').'>'.$num.'</a></li>';
						}
					}
				?>
			</ul>
		</div>
		
	</main>
</body>
</html>