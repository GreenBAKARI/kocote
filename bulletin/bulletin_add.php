<!--作成されている掲示板の総数の取得 -->
<?php
$pdo = new PDO("mysql:dbname=bulletin", "root", "kappaebisen");
$st_all = $pdo->query("SELECT * FROM bb_pre");
$st_all -> execute();
$all_rows = $st_all->rowCount();
 ?>

<!--スレ立て(bbテーブルにinsert)-->
<?php
  $comment_count = 0;
  $all_rows = $all_rows + 1;
  $user_id = 123;
  $pdo = new PDO("mysql:dbname=bulletin", "root", "kappaebisen");
  $st = $pdo->prepare("INSERT INTO bb_pre VALUES(?,?,?,?,?)");
  $st->execute(array($all_rows, $user_id,$_POST['bb_name'],$_POST['category'], $comment_count));
?>

<!--pfテーブル作成-->
<?php
$host="localhost"; // ホスト名
$user="root"; // ユーザー名
$pass="kappaebisen"; // パスワード

$dbname="bulletin"; // DB名
$tbname="pf".$all_rows; // テーブル名

// MYSQL接続
$db = mysql_connect($host,$user,$pass) or die("MYSQLへの接続に失敗しました");
// DB選択
mysql_select_db($dbname,$db) or die("DB選択に失敗しました");
// テーブル情報取得
$result=mysql_query("SHOW TABLES",$db) or die("テーブル取得に失敗しました");
// テーブル名チェック
while($row=mysql_fetch_assoc($result)) {
if($row["Tables_in_".$dbname]==$tbname) exit($tbname."は存在します");
}
// テーブル作成
$sql="create table ".$tbname." (bb_id int, user_id int, comment_num int, posted_content text, posted_date datetime)";
mysql_query($sql,$db) or die("テーブル作成に失敗しました");
print("掲示板「".$_POST['bb_name']."」を作成しました")
?>


<a href="bulletin.php">掲示板一覧へ</a>
