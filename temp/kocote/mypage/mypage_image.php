<?php

session_start();
$user_id = $_SESSION['user_id'];
if (empty($user_id)) {
    header("LOCATION: ../login.php");
}

//利用者IDの受け取り
$NOW_ID = $_GET['id'];
//配列の初期化
$icon_image = array();
$header_image = array();
//データベースへの接続
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
    die('接続失敗です。' . mysql_error());
}
//データベースの選択
$db_selected = mysql_select_db('greenbakari', $link);
if (!$db_selected) {
    die('データベース選択失敗です。' . mysql_error());
}

//文字コード設定
mysql_set_charset('utf8');

//アイコン画像とヘッダ画像の取得
$sql = "SELECT ICON_IMAGE, HEADER_IMAGE FROM UA WHERE USER_ID = $NOW_ID";

//クエリの実行
$result = mysql_query($sql, $link);
if (!$result) {
    die('クエリが失敗しました。' . mysql_error());
}

header("Content-Type: image/jpeg");

//抽出したデータを1件ずつ配列の最後に格納していく
while ($row = mysql_fetch_array($result)) {
    array_push($icon_image, $row['ICON_IMAGE']);
    array_push($header_image, $row['HEADER_IMAGE']);
}
//アイコン画像の表示
if ($_GET['image'] == 1) {
    echo $icon_image[0];
}
//ヘッダー画像の表示
if ($_GET['image'] == 2) {
    echo $header_image[0];
}
mysql_close($link);
?>
