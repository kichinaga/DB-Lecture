<html>
	<head></head>

	<body>

		<div>
			<h1>掲示板</h1>
			<p>荒らし、誹謗中傷厳禁！みんな仲良くプレイしましょう！</p>
			<hr>

<?php
	# タイムゾーンの設定
	date_default_timezone_set('Asia/Tokyo');
	# データベースの設定
	$link = mysqli_connect('localhost', 'root', 'root');
	$useDB = mysqli_select_db($link, 'Keijiban');

	# フォームからの入力があれば、keijibanにデータを挿入
	if(isset($_POST['name']) && isset($_POST['message'])){

		# 日付情報を取得
		$now = date('Y/m/d H:i:s');

		# SQL文の作成 (↓ nameに名前、messageにメッセージと入力した時のSQL文)
		# INSERT INTO Keijiban VALUES("名前", "メッセージ", "2017/08/14 07:14:22")
		$sql = 'INSERT INTO Keijiban VALUES("'.htmlspecialchars($_POST['name']).'", "'.htmlspecialchars($_POST['message']).'", "'.$now.'")';

		# クエリの発行
		mysqli_query($link, $sql);
	}

	# keijibanのデータを全件検索
	$sql = 'SELECT * FROM Keijiban';
	$res = mysqli_query($link, $sql);

	### $resは多次元配列のような扱いっぽい
	/*
	$res = [
		['user' => '名前', 'message' => 'メッセージ', 'date' => '日付情報'],
		['user' => '', 'message' => '', 'date' => ''],
		[],...
	]
	mysqli_fetch_arrayは配列の要素を上から一つずつ取り出すみたい
	*/

	# 名前、メッセージ、日付を表示
	foreach($res as $row){
		# html上で "<p>名前さん: メッセージ   2017/08/14 07:14:22</p>" と表示する。
		# &emsp; は空白を表すhtml特殊文字
		echo '<p>'.$row['user'].'さん: '.$row['message'].'&emsp;&emsp;&emsp;'.$row['date'].'</p>';
	}
	/*
	while文でやる場合
	while($row = mysqli_fetch_array($res)){
					echo '<p>' .$row["user"]. 'さん： ' .$row["message"]. '&emsp;&emsp;&emsp;' .$row["date"]. '</p>';
				}
	*/

	echo '<hr>';

	# mysqlを終了
	mysqli_close($link);
?>

			<form method='post'>
				<div>
					名前: <input type='text' name='name'>
				</div>
				<div>
					<textarea cols='30 rows='5 name='message' maxlength='50'></textarea>
				</div>
				<br>
				<div>
					<input type='submit' value='書き込み'>
				</div>
			</form>
		</div>
	</body>
</html>
