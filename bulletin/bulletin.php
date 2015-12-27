<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="style.css"　type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>

<form id="loginForm" name="loginForm" action="" method="POST">

<!--ヘッダ部分 -->
  <div id = "box">
    <a href="http://localhost/php/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br><br><br>

<!--掲示板ジャンル選択ボタン -->
<div id = "box">
  <img src="img/bb_all.jpg" height="8%" width="13%">
  <img src="img/bb_gf.jpg" height="8%" width="13%">
  <img src="img/bb_ge.jpg" height="8%" width="13%">
  <img src="img/bb_ks.jpg" height="8%" width="13%">
  <img src="img/bb_ft.jpg" height="8%" width="13%">
  <img src="img/bb_sc.jpg" height="8%" width="13%">
</div>
<br><br>
</center>


<!--作成ボタン & 並び替え順と思われるボタン -->
<div id = "box">
  <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="6%" width="13%" style="margin-left:33%"></a>
  <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="6%" width="13%"></a>
  <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="6%" width="13%"></a>
  <a href="http://localhost/php/v0/bulletin_add.html"><img src="img/bb_mk.jpg" height="6%" width="13%"></a>
</div>



<!--参考にしたサイト http://okky.way-nifty.com/tama_nikki/2010/06/php-e18e.html -->
<?php
//1ページあたりの表示件数
$one_page = 5;
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
$now_rows = $start;
//データベースでクエリする最後の行に(start値 + 1ページ当たり表示数 -1) をセット
$last_rows = $start + $one_page - 1;
 ?>

<?php
$url = "localhost";
$user = "root";
$pass = "kappaebisen";
$db = "bulletin";

//MySQLへ接続
$link = mysql_connect($url, $user, $pass) or die("MySQLへの接続に失敗しました。");

//データベースの選択
$sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");

//クエリの送信(作成が新しい順に$one_pageページずつ取得)
$seq = 3;
switch($seq){
  //コメント数の多い順
case '1':
  $sql = "SELECT * FROM bb_pre ORDER BY comment_count DESC LIMIT $start, $one_page";
  break;
  //コメントの最終投稿日時の新しい順
case '2':
  $sql = "SELECT * FROM bb_pre ORDER BY last_posted_date DESC LIMIT $start, $one_page";
  break;
//作成順
case '3':
  $sql = "SELECT * FROM bb_pre ORDER BY bb_id DESC LIMIT $start, $one_page";
  break;

default:
  $sql = "SELECT * FROM bb_pre ORDER BY bb_id DESC LIMIT $start, $one_page";
}

$result = mysql_query($sql) or die("クエリの送信に失敗しました。<br />SQL:".$sql);


//全ての行数を取得しall_rowsへ格納
$sql_all = "SELECT * FROM bb_pre";
$result_all = mysql_query($sql_all, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql_all);
$all_rows = mysql_num_rows($result_all);


mysql_close($link) or die("MySQL切断に失敗しました。");
?>

<!--一覧の出力-->
<div align="center">
  全部で<?=$all_rows?>件の掲示板があります。<br />

<table>
  <tbody>
    <th>分類</th>
<th>タイトル</th>
<th>コメント数</th>
<?php while (($row = mysql_fetch_array($result)) && ($now_rows <= $last_rows) && ($now_rows <= $all_rows)) { ?>
  <tr><td align="center" style="width:150px;"><?php echo ($row["category"]); ?></td>
  <td align="center" style="width:500px;"><a href="http://localhost/php/v0/bulletin_detail.php?bb_id=<?php echo ($row["bb_id"]) ?>"><?php echo ($row["bb_name"]); ?></a></td>
  <td align="center" style="width:150px;"><?php echo ($row["comment_count"]); ?></td>
    </tr>


<?php
$now_rows++;
 }?>
</tbody>
</table>


<?php
//start値が0より大きい(=最初のページでない)ときは、前のページへのリンクを作成
if($start > 0){
  ?>
  <a href="http://localhost/php/v0/bulletin.php?start=<?php echo ($start-$one_page)?>">前のページ</a>
  <?php
}else{
  //startが0なら最初のページなので、前のページへのリンクは無し
  ?>
  前のページ
  <?php
}
?>

  <?php
//last_row値がクエリした全行数-1より小さければ、まだ次のページがあるということなので次ページのリンクを作成
if($last_rows < ($all_rows-1)){
  ?>
  <a href="http://localhost/php/v0/bulletin.php?start=<?php echo ($start + $one_page)?>">次のページ</a>
  <?php
}else{
  ?>
  次のページ
  <?php
}
?>
</div>

</form>
</body>

</html>
