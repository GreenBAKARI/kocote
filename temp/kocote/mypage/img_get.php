<?php
$user_id = $_GET ['user_id'];
if (empty ( $user_id )) {
	header ( "LOCATION: ./mypage.php" );
}
// DB接続
// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
// データベースを選択
$dbLink = mysql_select_db ( 'greenbakari', $link );

/*
 * 画像データ取得
 * GET@in
 * img_type :
 * img_table :
 */

if (! $sql_result_image = mysql_query ( "SELECT " . $_GET ['img_type'] . " FROM " . $_GET ['img_table'] . " WHERE USER_ID = '" . $user_id . "'" ))
	die ( '画像取得失敗' . mysql_error () );

$row = mysql_fetch_array ( $sql_result_image );

// 画像ヘッダとしてjpegを指定
header ( "Content-Type: image/jpeg" );
// バイナリデータを直接表示
if (! isset ( $_GET ['raw_img'] )) {
	echo $row [$_GET ['img_type']];
} else {
	echo $_GET ['raw_img'];
}
?>
