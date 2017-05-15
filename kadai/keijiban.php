<?php
	#ログインしていなかったらログイン画面へ
	session_start();
	if (!isset($_SESSION['name'])) {
		header('Location: http://' .$_SERVER['HTTP_HOST'] .'/Login.php');
		exit();
	}
?>

<html>
	<head>
	<title>掲示板</title>
	</head>
	<body>
		<div>
		<h1>掲示板</h1>
		<p>荒らし、誹謗中傷厳禁！みんな仲良くプレイしましょう！</p>
		<hr>

			<?php
				#タイムゾーンを変更
				date_default_timezone_set('Asia/Tokyo');
				#データベース設定
				$link = mysqli_connect("localhost","root","root");
				$useDB = mysqli_select_db($link,'Keijiban');

				#メッセージが入力されていたら
				#keijibanテーブルに名前,メッセージ,投稿日付を格納
				if (isset($_SESSION['name']) && isset($_POST["message"])) {
					$nowtime = date("Y/m/d H:i:s");
					$sql = 'INSERT INTO Keijiban VALUES("' .$_SESSION['name'].'","' .htmlspecialchars($_POST["message"]). '","' .$nowtime. '")';
					$res = mysqli_query($link,$sql);
				}

				$sql = "SELECT * FROM Keijiban";
				$res = mysqli_query($link,$sql);

				#名前,メッセージ,日付を表示
				while($row = mysqli_fetch_array($res)){
					echo '<p>' .$row["user"]. 'さん： ' .$row["message"]. '&emsp;&emsp;&emsp;' .$row["date"]. '</p>';
				}
				echo "<hr>";

				mysqli_close($link);
			?>

			<form method="post">
				<div>
					<textarea cols="30" rows="5" name="message" maxlength="50"></textarea>
				</div>

				<br>

				<div>
					<input type="submit" value="書き込み"></input>
				</div>
			</form>

			<hr>
			<!-- ログアウトボタン -->
			<form action="logout.php">
				<div>
					<input type="submit" value="ログアウト" />
				</div>
			</form>
		</div>
	</body>
</html>
