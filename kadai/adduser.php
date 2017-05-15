<?php
	#ユーザー名とパスワードが入力されているか確認
	if (isset($_POST["user"]) && isset($_POST["password"])) {
		#データベース設定
		$link = mysqli_connect("localhost","root","root");
		$useDB = mysqli_select_db($link,'Keijiban');

		#パスワードをハッシュ値に変換
		$hash = password_hash($_POST['password'],PASSWORD_DEFAULT);
		#userテーブルに追加
		$sql = 'INSERT INTO user VALUES("' .htmlspecialchars($_POST["user"]).'","' .$hash. '")';
		$res = mysqli_query($link,$sql);

		mysqli_close($link);

		#ログインページへ移動
		header('Location: http://' .$_SERVER['HTTP_HOST'] .'/Login.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ユーザー登録</title>
</head>
<body>
	<form method="post">
		<div>
			ユーザー名： <input type="text" name = "user"></input>
		</div>
		<div>
			パスワード： <input type="text" name = "password"></input>
		</div>
		<div>
			<input type="submit" value="登録"></input>
		</div>
	</form>
</body>
</html>
