<?php
// DB接続
// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
// データベースを選択
$dbLink = mysql_select_db ( 'greenbakari', $link );

/* 画像データ取得
 * GET@in
 * img_type		:
 * img_table	:
 */

// ▽ idに該当する利用者
// if (! $sql_result_icon_image = mysql_query ( "SELECT " . $_GET ['img_type'] . " FROM " . $_GET ['img_table'] . " WHERE USER_ID = '" . $_POST ['id'] . "'" ))
// ▽ 1番目に該当する利用者を仮定
if (! $sql_result_image = mysql_query ( "SELECT " . $_GET ['img_type'] . " FROM " . $_GET ['img_table'] . " WHERE USER_ID = '" . 1 . "'" ))
	die ( '画像取得失敗' . mysql_error () );

$row = mysql_fetch_array ( $sql_result_image );

// 画像ヘッダとしてjpegを指定
header ( "Content-Type: image/jpeg" );
// バイナリデータを直接表示
echo $row [$_GET ['img_type']];
?>
