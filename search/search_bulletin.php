<html>
<head>
<meta charset = "utf-8">
<title>掲示板検索</title>
</head>
<center>
<link rel="stylesheet" href="style.css"　type="text/css">
<body topmargin = "100" bottommargin = "100">

<div style = "background-image: url(img/search_src.jpg);
-moz-background-size:100% 100%;
background-size:100% 100%;">

<div id = "headerArea"></div>
<div id = "footerArea"></div>
<br>

<div id = "box">
<a href = "http://localhost/event.php">
<img src = "img/ev_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/bulletin.php">
<img src = "img/bb_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/search.php">
<img src = "img/se_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/dm.php">
<img src = "img/dm_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/mypage.php">
<img src = "img/mp_home.jpg" height = "7%" width = "16%"></a>
</div><br><br><br>

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width =" 40%">
<br>



<?php
$url = 'localhost';  //ローカル環境へのURL
$user = 'masaki';    //MySQLサーバの利用者ID
$pass = '1234';      //MySQLのパスワード
$db = 'greenbakari'; //MySQLのデータベース名

//mysql_close() - MySQLサーバへの接続をオープンにする
$link = mysql_connect($url, $user, $pass);

//mysql_error() - 直近に実行されたMySQL操作のエラーメッセージを返す
if (!$link) {
    die('接続失敗です。'.mysql_error());
}
//print('<p>接続に成功しました。</p>');

//mysql_select_db() - MySQLサーバへの接続後に利用したいデータベースを選択する
$db_select = mysql_select_db($db, $link);

if (!$db_select) {
    die('データベース選択失敗です。'.mysql_error());
}
//print('<p>データベースを選択しました。</p>');

//mysql_set_charset() - MySQLデータベースで使用する文字コードを指定する
mysql_set_charset('utf8');

//_POST[] - HTTP POSTメソッドから掲示板検索に渡された変数の連想配列を定義する
$keyword = $_POST['bb_keyword'];   //キーワード
$category = $_POST['bb_category']; //分類

//キーワード・分類が入力されていない場合、またはキーワードが入力されておらず、分類が入力されている場合の検索条件の生成
if (!$keyword && !$category || !$keyword && $category) {
    //mysql_query() - MySQLデータベースへクエリを発行する
    $result = mysql_query("SELECT BB_ID, BB_NAME, LAST_POSTED_DATE, COMMENT_COUNT FROM BB 
        WHERE BB_NAME LIKE '%$keyword%' AND CATEGORY = $category");
//キーワード・分類が入力されている場合、またはキーワードが入力されており、分類が入力されていない場合の検索条件の生成
} else {
    $result = mysql_query("SELECT BB_ID, BB_NAME, LAST_POSTED_DATE, COMMENT_COUNT FROM BB 
        WHERE BB_NAME LIKE '%$keyword%' OR CATEGORY = $category");
}

if (!$result) {
    die('クエリが失敗しました。'.mysql_error());
}
//print('<p>クエリが成功しました。</p>');

//抽出結果に表示番号を割り振る
$display_num = 1;

//mysql_num_rows() - クエリの実行結果から行の数を取得する
$rows = mysql_num_rows($result);

if ($rows) {
	//mysql_fetch_array() - クエリの実行結果を連想配列として取得する
	while ($row = mysql_fetch_array($result)) {
        $send = $row['BB_ID'];
        $date = $row['LAST_POSTED_DATE'];
		$temp = $temp."<tr>";
        $temp = $temp."<td>&nbsp;&nbsp;".$dispaly_num++."</td>";
        $temp = $temp."<td>&nbsp;&nbsp;<a href=bulletin_datail.php?bb_id=$send>".$row['BB_NAME']."</a></td>";
        $temp = $temp."<td>&nbsp;&nbsp;".substr($date, 0, 4)."年".substr($date, 5, 2)."月".substr($date, 8, 2)."日"."</td>";
        $temp = $temp."<td>&nbsp;&nbsp;".$row['COMMENT_COUNT']."</td>";
        $temp = $temp."</tr>";
    }
    $msg = "<p><h3>検索結果： 該当する掲示板が".$rows."件表示されました。</h3></p><br>";
} else {
	$msg = "<p><h3>検索結果： 該当する掲示板は存在しません。</h3></p>";
}

//mysql_close() - MySQLサーバへの接続をクローズにする
$close_flag = mysql_close($link);
    
if (!$close_flag) {
    die('切断に失敗しました。'.mysql_error());
}
//print('<p>切断に成功しました。</p>');
?>



<?= $msg ?>
<table border = "1" cellpadding="5">
<tr bgcolor = "#87ceeb">
<td width = 90>&nbsp;&nbsp;表示番号</td>
<td width = 200>&nbsp;&nbsp;掲示板タイトル</td>
<td width = 200>&nbsp;&nbsp;最終投稿日時</td>
<td width = 110>&nbsp;&nbsp;コメント数</td>
<?= $temp ?>
</table><br><br><br>

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width =" 40%">
<br><br>

</body>
</html>
