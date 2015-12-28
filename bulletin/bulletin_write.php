<!-- コメント投稿処理 -->
<!-- insertがうまくいかないので頑張り中-->

<?php
 $bb_id = 1;
$table_name ="pf".$bb_id
 ?>


<!--コメント数取得-->
 <?php
 $pdo = new PDO("mysql:dbname=bulletin", "root", "kappaebisen");
 $st_all = $pdo->query("SELECT * FROM $table_name");
 $st_all -> execute();
 $all_comments = $st_all->rowCount();


//--投稿(pfテーブルにinsert)
   $user_id = 123;
   $posted_date = 20151227225530;

   $all_comments = $all_comments + 1;
   $pdo = new PDO("mysql:dbname=bulletin", "root", "kappaebisen");
   $st = $pdo->prepare("INSERT INTO $table_name VALUES(?,?,?,?,?)");
   $st->execute(array($bb_id, $user_id, $all_comments, $_POST['posted_content'], $posted_date));
   print("投稿しました。");
 ?>

<a href="bulletin_detail.php">掲示板へ</a>


<!--ただのめも
価格<br>
  <input type="text" name="price"><br>
  説明<br>
<textarea name = "comment" cols = 40 rows = 4>
</textarea>-->
