<!-- テーブルがないときの処理・書き込みが1件もないときの処理未記述(テーブルがないときの処理は不要かも)-->

<!--コメント投稿フォーム-->
<html>
<body>
  <center>
<form action="bulletin_write.php" method="post">
コメント<br>
<textarea name = "posted_content" cols = 40 rows = 4>
</textarea>
<input type="submit" id="makebulletin" name="makebulletin" value="投稿する">
</form>
</body>
<br><br><br>

<!-- 投稿コメント一覧の取得&表示-->
<!-- クリックに応じた一覧の取得がまだできてないので今は1番目の掲示板のみ表示可(bb_id=1)-->
<h2>掲示板タイトル</h2>
<?php
$bb_id = 1;
$table_name ="pf".$bb_id
 ?>
<table border="1">
<tr><th>掲示板ID</th><th>ユーザID</th><th>コメント番号</th><th>投稿内容</th><th>投稿日時</th></tr>
<?php
  $pdo = new PDO("mysql:dbname=bulletin", "root", "kappaebisen");
  $st = $pdo->query("SELECT * FROM $table_name");
  while ($row = $st->fetch()) {
    $bb_id = htmlspecialchars($row['bb_id']);
    $user_id = htmlspecialchars($row['user_id']);
    $comment_num = htmlspecialchars($row['comment_num']);
    $posted_content = htmlspecialchars($row['posted_content']);
    $posted_date = htmlspecialchars($row['posted_date']);
    echo "<tr><td>$bb_id</td><td>$user_id</td><td>$comment_num</td><td>$posted_content</td><td>$posted_date</td></tr>";
  }?>
</table>
</center>
<br><br><br>


</html>
