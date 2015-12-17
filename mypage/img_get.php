<?php
// DB接続
// MySQLと接続
$link = mysql_connect ( 'localhost' , 'root');
// データベースを選択
$dbLink = mysql_select_db ( 'hogehoge' , $link);

// 画像データ取得
$sql = "SELECT IMG FROM IMAGES WHERE ID = " . $_GET['id'];
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

// 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
header("Content-Type: image/jpeg");

// バイナリデータを直接表示
echo $row[0];
?>
