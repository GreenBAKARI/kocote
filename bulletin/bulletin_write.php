<!-- ユーザIDのコメントアウト外す必要アリ-->
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
$url = "localhost";
$user = "root";
$pass = "kappaebisen";
$db = "test_bulletin";

//ユーザ情報
  $user_id = 165848;
  //$user_id = $_COOKIE["user_id"];

//table情報
  $comment_count = 0;
  $comment = $_POST['posted_content'];
  $bb_id = $_POST['id'];
  //echo $_POST['id'];
  $table = "pf".$bb_id;
?>

<!--コメント数取得 -->
<?php
$link = mysql_connect("localhost", "root", "kappaebisen") or die("MySQLへの接続に失敗しました。");
$sdb = mysql_select_db("test_bulletin", $link) or die("データベースの選択に失敗しました。");
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
   $pdo = new PDO("mysql:dbname=$db", "root", "kappaebisen");
   $st = $pdo->prepare("INSERT INTO $table VALUES(?,?,?,?,?)");
   $st->execute(array($bb_id, $user_id, $next_com_num, $comment, $time));
 ?>


<?php
print("投稿しました。");
?>

<!--コメント数と投稿時間更新-->
<?php
$link = mysql_connect("localhost", "root", "kappaebisen") or die("MySQLへの接続に失敗しました。");
$sdb = mysql_select_db("test_bulletin", $link) or die("データベースの選択に失敗しました。");
$sql = "UPDATE bb SET comment_count = $comment_num, last_posted_date = '$time' WHERE bb_id = $bb_id";
$result_comment_update = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);
mysql_close($link) or die("MySQL切断に失敗しました。");
 ?>

<a href="bulletin_detail.php?bb_id=<?php echo $bb_id ?>">掲示板へ</a>

</body>
</html>
