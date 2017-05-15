<?php
	session_start();
	$error_message = '';

	#データベース設定
	#keijibanデータベース,userテーブルを使用
	$link = mysqli_connect("localhost",'root','root');
	$useDB = mysqli_select_db($link,'Keijiban');

	#ユーザー名とパスワードが入力されていることを確認
	if(isset($_POST['name']) && isset($_POST['password'])){
		#userテーブル内のデータを全て検索
		$sql = "SELECT * FROM User";
		$res = mysqli_query($link,$sql);

		#全件検索
		while($row = mysqli_fetch_array($res)){
			#ユーザー名とパスのハッシュ値を判定
			if ($_POST['name'] === $row['name'] && password_verify($_POST['password'],$row['password'])) {
				#セッション情報に格納
				$_SESSION['name'] = $row['name'];

				#掲示板に遷移
				header('Location: http://' .$_SERVER['HTTP_HOST'] .'/keijiban.php');
				exit();
			}
		}
	$error_message = 'ログイン失敗';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<!--PHP部-->
	<?php
		if(!empty($error_message)){
			echo '<p>' .$error_message .'</p>';
		}
	?>

	<form method="post">
		<div>
			ユーザー名： <input type="text" name = "name"/>
		</div>
		<div>
			パスワード： <input type="password" name = "password" size="10"/>
		</div>
		<div>
			<input type="submit" value="ログイン"/>
		</div>
	</form>

	<!-- ユーザー登録画面に遷移 -->
	<form action="adduser.php">
		<div>
			<hr>
			<input type="submit" value="ユーザー登録" />
		</div>
	</form>
</body>
</html>
