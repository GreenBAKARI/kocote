<!-- 掲示板追加 -->
<!-- 参考サイト  http://php5.seesaa.net/category/4121238-1.html-->
<?php
//ファイルの読み込み
require_once("bulletin.php");

//データを取得(要変更)
$pref_cd = $_POST['cd'];
$pref_name = $_POST['name'];

//クエリの送信(要変更)
$sql = "INSERT INTO bb VALUES(".$pref_cd.",'".$pref_name."')";
$result = executeQuery($sql);

?>
