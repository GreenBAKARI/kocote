<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="css/style.css"　type="text/css">
<link rel="stylesheet" href="css/bb_style.css"　type="text/css">

<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>


<!--作成されている掲示板の総数の取得 -->
<?php
$url = "localhost";
$user = "root";
$pass = "kappaebisen";
$db = "test_bulletin";
$table = "bb";
$category = "category";
?>

<?php
$pdo = new PDO("mysql:dbname=$db", "root", "kappaebisen");
$st_all = $pdo->query("SELECT * FROM $table");
$st_all -> execute();
$all_rows = $st_all->rowCount();
 ?>

<!-- 現在時刻の取得 -->
<?php
date_default_timezone_set('Asia/Tokyo');
$time = date('Y-m-d H:i:s');
 ?>

 <!--最終IDの取得-->
 <?php
 $link = mysql_connect("localhost", "root", "kappaebisen") or die("MySQLへの接続に失敗しました。");
 $sdb = mysql_select_db("test_bulletin", $link) or die("データベースの選択に失敗しました。");
 $sql = "SELECT bb_id FROM bb WHERE bb_id = (SELECT max(bb_id) FROM bb)";
 $result_last_id = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);
 $last_id = mysql_result($result_last_id, 0);
 mysql_close($link) or die("MySQL切断に失敗しました。");
  ?>


<!--スレ立て(bbテーブルにinsert)-->
<?php
  $comment_count = 0;
  //$all_rows = $all_rows + 1;
  $next_id = $last_id + 1;
  $user_id = 154697;
  //$user_id = $_POST['cokkieからとってくる']
  $pdo = new PDO("mysql:dbname=$db", "root", "kappaebisen");
  $st = $pdo->prepare("INSERT INTO $table VALUES(?,?,?,?,?,?,?)");
  $st->execute(array($next_id, $user_id,$_POST['bb_name'],$_POST['category'], $comment_count, $time, $time));
?>

<!--pfテーブル作成-->
<?php
$host="localhost"; // ホスト名
$user="root"; // ユーザー名
$pass="kappaebisen"; // パスワード
$dbname="$db"; // DB名
$tbname="pf".$next_id; // テーブル名

// MYSQL接続
$db = mysql_connect($host,$user,$pass) or die("MYSQLへの接続に失敗しました");
// DB選択
mysql_select_db($dbname,$db) or die("DB選択に失敗しました");
// テーブル情報取得
$result=mysql_query("SHOW TABLES",$db) or die("テーブル取得に失敗しました");
// テーブル名チェック
while($row=mysql_fetch_assoc($result)) {
if($row["Tables_in_".$dbname]==$tbname) exit($tbname."は存在します。");
}
// テーブル作成
$sql="CREATE TABLE ".$tbname." (bb_id int not null, user_id int not null, comment_num int, posted_content text, posted_date datetime)";
mysql_query($sql,$db) or die("テーブル作成に失敗しました");

//コメントinsert(pfテーブルにinsert)
//コメント未入力の場合は掲示板のみ作成
$comment = $_POST['make_comment'];
if(empty($comment)){
  echo "コメント未入力で作成/ ";
}else{
  echo "コメント入力で作成(コメント内容：$comment)/ ";
  $comment_count=1;
  $st_com = $pdo->prepare("INSERT INTO $tbname VALUES(?,?,?,?,?)");
  $st_com->execute(array($next_id, $user_id, $comment_count, $comment, $time));
}

print("掲示板「".$_POST['bb_name']."」を作成しました");
?>

<a href="bulletin.php">掲示板一覧へ</a>


</body>

</html>
