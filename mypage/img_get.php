<?php
// DB接続
// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
// データベースを選択
$dbLink = mysql_select_db ( 'greenbakari', $link );

// 画像データ取得
if (! $sql_result_icon_image = mysql_query ( "SELECT " . $_GET ['img'] . " FROM ua WHERE USER_ID = '" . $_GET ['id'] . "'" ))
	die ( 'クエリ失敗。' . mysql_error () );
$row = mysql_fetch_array ( $sql_result_icon_image );

// 画像ヘッダとしてjpegを指定
header ( "Content-Type: image/jpeg" );

// バイナリデータを直接表示
echo $row [$_GET['img']];
?>
