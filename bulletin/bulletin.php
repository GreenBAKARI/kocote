<?php
//参考サイト：http://php5.seesaa.net/category/4095138-1.html
//変数に各種設定を代入(ここを書き換えると他のデータベースにも接続できる)
$url = "localhost";
$user = "root";
$pass = "kappaebisen";
$db = "bulletin";

//MySQLへ接続
//成功したら接続IDが、失敗したらfalse(0)が返る。
$link = mysql_connect($url, $user, $pass) or die("MySQLへの接続に失敗しました。");

//データベースの選択
$sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");

//クエリの送信
$sql = "SELECT * FROM bb";
$result = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);

//結果セットの行数を取得する
$rows = mysql_num_rows($result);

//pfテーブルデータを表示
$temp_html = "";//初期化(undefined variableエラーを非表示にするため)
if($rows){
  while($row = mysql_fetch_array($result)){
    $temp_html .="<tr>";
    $temp_html .= "<td>".$row["bb_id"]."</td><td>".$row["user_id"]."</td><td>".$row["bb_name"]."</td><td>".$row["category"]."</td><td>".$row["created_date"]."</td>";
    $temp_html .="</tr>\n";
  }
  $msg = $rows."件の掲示板があります。";
}else{
  $msg = "掲示板はありません。";
}


//結果保持用メモリを解放する
mysql_free_result($result);

//MySQLへの接続を切断する
mysql_close($link) or die("MySQL切断に失敗しました。");


 ?>

<html>
<head>
  <title>掲示板一覧</title>
</head>
<body>
  bbテーブルに接続(掲示板ID=1)<br />
  bbテーブルの行数:<?=$rows?><br />

  <h3>書き込み表示</h3>
  <?=$msg?>
  <table width = "600" border = "0">
    <tr bgcolor = "##cae12e">
      <td>掲示板ID</td> <td>利用者ID(立てた人)</td> <td>掲示板タイトル</td> <td>分類</td> <td>作成日時</td>
     </tr>
    <?=$temp_html?>
  </table>
</body>
</html>


<?php
//件数の確認
$kensuu = 3;
if($rows >= $kensuu){
  echo $kensuu."件以上あるか判定。" .$kensuu."件以上です。<br />";
}else{
  echo $kensuu."件以上あるか判定。".$kensuu."件未満です。<br />";
}
 ?>
