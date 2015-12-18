<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>画像アップロード</title>
</HEAD>
<BODY>
	<FORM method="POST" enctype="multipart/form-data" action="upload.php">
		<P>画像アップロード</P>
		画像パス：<INPUT type="file" name="upfile" size="50"><BR> <INPUT
			type="submit" name="submit" value="送信">
	</FORM>

<?php
if (count($_POST) > 0 && isset($_POST["submit"])){
	$upfile = $_FILES["upfile"]["tmp_name"];
	if ($upfile==""){
		print("ファイルのアップロードができませんでした。<BR>\n");
		exit;
	}

	// ファイル取得
	$imgdat = file_get_contents($upfile);
	$imgdat = mysql_real_escape_string($imgdat);

	// DB接続
	// MySQLと接続
	$link = mysql_connect ( 'localhost' , 'root');

	// データベースを選択
	$dbLink = mysql_select_db ( 'hogehoge' , $link);


	// データ追加
	$sql = "INSERT INTO IMAGES (IMG) VALUES ('$imgdat')";

	$result = mysql_query($sql);
	if (!$result){
		print("SQLの実行に失敗しました<BR>");
		print(mysql_errno().": ".mysql_error()."<BR>");
		exit;
	}

	print("登録が終了しました<BR>");
}
?>
</BODY>
</HTML>
