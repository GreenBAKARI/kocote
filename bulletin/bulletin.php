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
<form id="loginForm" name="loginForm" action="" method="POST">

<!--ヘッダ部分 -->
  <div id = "box">
    <a href="http:../event/event.php"><img src="../img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http:../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http:../search/search.php"><img src="../img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http:../dm/dm.php"><img src="../img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http:../mypage/mypage.php"><img src="../img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br>

<!--掲示板ジャンル選択ボタン -->
<div id = "box">
<form action="bulletin.php" method = "post">
  <input type="submit" name="all" value="" class="cate_all"/>
  <input type="submit" name="gourmet" value="" class="cate_gf"/>
  <input type="submit" name="art" value="" class="cate_ge"/>
  <input type="submit" name="sports" value="" class="cate_ks"/>
  <input type="submit" name="welfare" value="" class ="cate_ft"/>
  <input type="submit" name="carrier" value="" class="cate_sc"/>
  <input type="submit" name="etc" value="" class="cate_etc"/>
</form>
</div>
</center>
<br><br>

<?php
//表示する掲示板の順番番号(デフォルト)
$seq = 15;
 ?>

<!-- 並び替えボタン -->
<div id = "box">
<div align="left" style="margin-left:230px" class="left">
<form action="bulletin.php" method = "post">
 <input type="submit" name="new_post" value="" class="sort_newpost"/>
  <input type="submit" name="com_num" value="" class="sort_comnum"/>
  <input type="submit" name="make" value="" class="sort_make"/>
  </form>
</div>

<!-- 作成ボタン-->
<div align="right" style="margin-right:248px" class="right">
  <input type="button" onClick="location.href='http:../bulletin/bulletin_add.html'" class="bb_make" />
</div>
<!--float解除-->
<div class="clear"></div>
</div>

<!-- 押されたボタンに応じて並び替え番号を変更 -->
<?php
if(isset($_POST['new_post'])) {
   $seq = 2;
}
else if(isset($_POST['com_num'])) {
   $seq = 1;
}
else if(isset($_POST['make'])) {
   $seq = 3;
}
 ?>

<!--ページめくり(参考にしたサイト http://okky.way-nifty.com/tama_nikki/2010/06/php-e18e.html) -->
<?php
//1ページあたりの表示件数
$one_page = 15;
 ?>

<?php
//startパラメータ=このページの最初の行
//startパラメータがなければ、start=0をセット
if(isset($_GET['start'])==false){
  $start = 0;
}else{
  //そうでなければstartパラメータの値をstart変数にセット
  $start = $_GET['start'];
}
 ?>

<?php
//データベースでクエリする最初の行にstart値をセット
$first_rows = $start;
//データベースでクエリする最後の行に(start値 + 1ページ当たり表示数 -1) をセット
$last_rows = $start + $one_page - 1;
 ?>

<?php
//DB情報
$db = "test_bulletin";
$host = "localhost";
$user = "root";
$pass = "kappaebisen";

$table = "bb";
$category = "category";

if(isset($_POST['all'])) {
   $category = "category";
}
else if(isset($_POST['gourmet'])) {
   $category = "'グルメ/フェスティバル'";
}
else if(isset($_POST['art'])) {
   $category = "'芸術/エンタメ'";
}
else if(isset($_POST['sports'])) {
   $category = "'交流/スポーツ'";
}
else if(isset($_POST['welfare'])) {
   $category = "'地域振興/福祉'";
}
else if(isset($_POST['carrier'])) {
  $category = "'就活/キャリア'";
}
else if(isset($_POST['etc'])){
  $category = "'その他'";
}

//MySQLへ接続
$link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");

//データベースの選択
$sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");

//クエリの送信(作成が新しい順に$one_pageページずつ取得)
switch($seq){
case '1':
  $sql = "SELECT * FROM $table WHERE category = $category ORDER BY comment_count DESC LIMIT $start, $one_page";
  $seq_str="コメント数の多い順";
  //$table="sorted_table";
  break;

case '2':
  $sql = "SELECT * FROM $table WHERE category = $category ORDER BY last_posted_date DESC LIMIT $start, $one_page";
  $seq_str="最新コメント投稿順";
  break;

case '3':
  $sql = "SELECT * FROM $table WHERE category = $category ORDER BY created_date DESC LIMIT $start, $one_page";
  $seq_str="作成された順";
  break;

default:
  $sql = "SELECT * FROM $table ORDER BY bb_id DESC LIMIT $start, $one_page";
}
$result = mysql_query($sql) or die("クエリの送信に失敗しました。<br />SQL:".$sql);

//全ての行数を取得しall_rowsへ格納
$sql_all = "SELECT * FROM $table WHERE category = $category";
$result_all = mysql_query($sql_all, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql_all);
$all_rows = mysql_num_rows($result_all);

mysql_close($link) or die("MySQL切断に失敗しました。");
?>

<!--一覧の出力-->
<div align="center">
  全部で<?=$all_rows?>件の掲示板があります。<br>
  今の並び：<?php echo $seq_str?>
<br>
<table class="bb_view" rules="all">
    <th>分類</th>
<th>タイトル</th>
<th>コメント数</th>
<?php while (($row = mysql_fetch_array($result)) && ($first_rows <= $last_rows) && ($first_rows <= $all_rows)) { ?>
  <tr><td align="center" style="width:150px;"><?php echo ($row["category"]); ?></td>
  <td align="center" style="width:500px;"><a href="http:../bulletin/bulletin_detail.php?bb_id=<?php echo ($row["bb_id"]) ?>"><?php echo ($row["bb_name"]); ?></a></td>
  <td align="center" style="width:150px;"><?php echo ($row["comment_count"]); ?></td>
    </tr>
<?php
$first_rows++;
 }?>
</table>

<?php
//start値が0より大きい(=最初のページでない)ときは、前のページへのリンクを作成
if($start > 0){
  ?>
  <div id = "box">
  <a href="http:../bulletin/bulletin.php?start=<?php echo ($start-$one_page)?>"><br>[前のページ]</a>
  <?php
}else{
  //startが0なら最初のページなので、前のページへのリンクは無し
  ?>
  <br>
  <!--前のページ-->
  <?php
}
?>

  <?php
//last_row値がクエリした全行数-1より小さければ、まだ次のページがあるということなので次ページのリンクを作成
if($last_rows < ($all_rows-1)){
  ?>
  <a href="http:../bulletin/bulletin.php?start=<?php echo ($start + $one_page)?>">[次のページ]</a>
  <?php
}else{
  ?>
  <!--次のページ-->
  <?php
}
?>
</div>
</form>
</body>

</html>
