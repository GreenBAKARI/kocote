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



// ヘッダ画像
if (isset ( $_POST ['header_img'] ))
	$img_table = 'tmp'; // 新しい画像に更新する場合
else
	$img_table = 'ua';
echo '<p>';
echo '<img src="./img_get.php?img_type=HEADER_IMAGE&img_table=' . $img_table . '"/>';
echo '</p>';
// アイコン画像
if (isset ( $_POST ['icon_img'] ))
	$img_table = 'tmp'; // 新しい画像に更新する場合
else
	$img_table = 'ua';
echo '<p>';
echo '<img src="./img_get.php?&img_type=ICON_IMAGE"/>';
echo 'アイコン画像パス：<INPUT type="file" name="icon_img" size="50"><BR>';
echo '</p>';
// 「編集を確認する」ボタン
echo '<input type="submit" value="編集を確認する" name="conf" ></button>';










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
	$sql = "INSERT INTO tmp VALUES ('$imgdat')";

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
