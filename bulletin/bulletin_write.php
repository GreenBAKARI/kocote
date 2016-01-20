<?php
session_start();
 ?>

<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/bb_style.css"　type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>

<!-- コメント投稿処理 -->
<?php
//DB情報
$db = "greenbakari";
$host = "localhost";
$user = "root";
$pass = "root";
//ユーザ情報
  $user_id = $_SESSION[user_id];

//table情報
  $comment_count = 0;
  $comment = $_POST['posted_content'];
  $bb_id = $_POST['id'];
  $table = "PF".$bb_id;
?>

<!--コメント数取得 -->
<?php
$link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");
$sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
$sql = "SELECT COUNT(*) FROM $table";
$result_comment_num = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);
$comment_num = mysql_result($result_comment_num, 0);
mysql_close($link) or die("MySQL切断に失敗しました。");
$next_com_num = $comment_num + 1;
 ?>

<!-- 現在時刻の取得 -->
 <?php
 date_default_timezone_set('Asia/Tokyo');
 $time = date('Y-m-d H:i:s');
 ?>

<!--コメント投稿(pfテーブルにinsert)-->
<?php
   //SQL発行
   $pdo = new PDO("mysql:dbname=$db", $user, $pass);
   $st = $pdo->prepare("INSERT INTO $table VALUES(?,?,?,?,?)");
   $st->execute(array($bb_id, $user_id, $next_com_num, $comment, $time));
 ?>


<?php
print("投稿しました。");
?>

<!--コメント数と投稿時間更新-->
<?php
$link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");
$sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");
$sql = "UPDATE BB SET COMMENT_COUNT = $comment_num, LAST_POSTED_DATE = '$time' WHERE BB_ID = $bb_id";
$result_comment_update = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);
mysql_close($link) or die("MySQL切断に失敗しました。");
 ?>

<a href="bulletin_detail.php?bb_id=<?php echo $bb_id ?>">掲示板へ</a>

</body>
</html>
