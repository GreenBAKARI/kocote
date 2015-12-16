<!--掲示板詳細 -->
<?php
//変数に各種設定を代入(ここを書き換えると他のデータベースにも接続できる)
$url = "localhost";
$user = "root";
$pass = "kappaebisen";
$db = "bulletin";
//掲示板の選択(とりあえず)
$bbs_id = 1;

//MySQLへ接続
//成功したら接続IDが、失敗したらfalse(0)が返る。
$link = mysql_connect($url, $user, $pass) or die("MySQLへの接続に失敗しました。");

//データベースの選択
$sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");

//クエリの送信
if($bbs_id == 1){
$sql = "SELECT * FROM pf";
  $result = mysql_query($sql, $link);
}else if($bbs_id == 2){
  $sql = "SELECT * FROM pf2";
    $result = mysql_query($sql, $link);
}else{
    die("クエリの送信に失敗しました。<br />SQL:".$sql);
}
//結果セットの行数を取得する
$rows = mysql_num_rows($result);

//pfテーブルデータを表示
$temp_html = "";//初期化(undefined variableエラーを非表示にするため)
if($rows){
  while($row = mysql_fetch_array($result)){
    $temp_html .="<tr>";
    $temp_html .= "<td>".$row["bb_id"]."</td><td>".$row["user_id"]."</td><td>".$row["comment_num"]."</td><td>".$row["posted_content"]."</td><td>".$row["posted_date"]."</td>";
    $temp_html .="</tr>\n";
  }
  $msg = $rows."件の書き込みがあります。";
}else{
  $msg = "書き込みはありません。";
}


//結果保持用メモリを解放する
mysql_free_result($result);

//MySQLへの接続を切断する
mysql_close($link) or die("MySQL切断に失敗しました。");
 ?>


<html>
<head>
  <title>掲示板詳細</title>
</head>
<body>
  投稿フォームテーブルに接続...掲示板ID<?=$bbs_id?><br />
  この投稿フォームテーブルの行数:<?=$rows?><br />

  <h3>書き込み表示</h3>
  <?=$msg?>
  <table width = "600" border = "0">
    <tr bgcolor = "##cae12e">
      <td>掲示板ID</td> <td>ユーザID</td> <td>コメント番号</td> <td>投稿内容</td> <td>投稿日時</td>
     </tr>
    <?=$temp_html?>
  </table>
</body>
</html>
