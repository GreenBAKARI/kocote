<?php
   $event_id = 87;
   $user_id = 100;
   $user_name = "greenbakari";
   //$event_id = $_POST['event_id'];
   //$user_id = $_POST['user_id'];
   //$user_name = $_POST['user_name'];
    //データベース接続
    $conn = mysql_connect('localhost', 'root', 'root');
    if (!$conn) {
      die("データベース接続失敗");
    }
    //データベース選択
    mysql_select_db('greenbakari') or die("データベース選択失敗");
    //文字コード指定
    mysql_set_charset('utf8');

    //オートコミットを0に設定
    $sql = "SET AUTOCOMMIT = 0";
    mysql_query($sql);

    //トランザクション開始
    $sql = "BEGIN";
    mysql_query($sql);

    //最後のイベントIDを取得
    $sql = "SELECT * FROM EV WHERE EVENT_ID = $event_id";
    $res = mysql_query($sql);
    while ($new = mysql_fetch_array($res)) {
    $user_id = $new['USER_ID'];
    $event_title = $new['EVENT_TITLE'];
    $host_comment = $new['HOLDING_COMMENT'];
    $event_start = $new['EVENT_START'];
    $event_month = date('m', strtotime($event_start));
    $event_day = date('d', strtotime($event_start));
    $start_hour = date('H', strtotime($event_start));
    $event_finish = $new['EVENT_FINISH'];
    $finish_hour = date('H', strtotime($event_finish));
    $event_place = $new['HOLDING_PLACE'];
    $participation_deadline = $new['PARTICIPATION_DEADLINE'];
    $limit_month = date('m', strtotime($participation_deadline));
    $limit_day = date('d', strtotime($participation_deadline));
    $limit_hour = date('H', strtotime($participation_deadline));
    $event_category = $new['CATEGORY'];
    $event_detail = $new['EVENT_DETAIL'];
    }

    if ($res) {
    //成功時はコミットする
      $sql = "COMMIT";
      mysql_query($sql, $conn);
      //echo "コミットしました";
    } else {
      //失敗時はロールバックする
      $sql = "ROLLBACK";
      mysql_query($sql, $conn);
      //echo "ロールバックしました";
    }

    //mysql切断
    mysql_close($conn);
?>



<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="style.css" type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>

<form id="loginForm" name="loginForm" action="conf.php" method="POST">
  <!-- <?php echo $errorMessage ?> -->

<div id = "box">
    <a href="http://localhost/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
<br><br><br>

<a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" style="margin-left:-10%" height="8%" width="5%" align="bottom"><font size="6" color="#000000"><?php echo $user_name ?></font></a>
<br><br><br>

<label for="event_title" style="margin-left:-10%">イベントタイトル*：</label>
<input type="text" id="event_title" name="event_title" value="<?php echo $event_title ?>" required>
<br><br><br>

<label for="host_comment" style="margin-left:-2%">主催者コメント：</label>
<textarea name="host_comment" rows="3" cols="40"><?php echo $host_comment ?> </textarea>
<br><br><br>

  <label for="event_month" style="margin-left:-9%">開催日*：</label>
  <?php
  echo '<select required="required" name="event_month">' . "\n";
     for ($i = 1; $i <= 12; $i++){
	if($event_month == $i){$selected="selected";}
	else {$selected="";}
	echo "<OPTION value=". $i ." ". $selected .">".$i."月</OPTION>\n";}
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;";
  ?>
  <label for="event_day" style="margin-left:0%"></label>
  <?php
     echo '<select required="required" name="event_day">' . "\n";
  for ($i = 1; $i <= 31; $i++){
      if($event_day == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."日</OPTION>\n";}
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  <label for="start_hour" style="margin-left:-9%">開催時間*：</label>
  <?php
  echo '<select required="required" name="start_hour">' . "\n";
  for ($i = 0; $i <= 23; $i++){
      if($start_hour == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."時</OPTION>\n";}
  echo '</select>' . "\n";
    echo "&nbsp;&nbsp;～&nbsp;&nbsp;"
  ?>
  <label for="finish_hour" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="finish_hour">' . "\n";
  for ($i = 0; $i <= 23; $i++){
      if($finish_hour == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."時</OPTION>\n";}
  echo '</select>' . "\n";
  ?>
  <br><br><br>


  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
  <input type="text" id="event_place" name="event_place" value="<?php echo $event_place ?>" required>
  <br><br><br>



  <label for="limit_month" style="margin-left:-9%">参加応募締め切り*：</label>
  <?php
  echo '<select required="required" name="limit_month">' . "\n";
  for ($i = 1; $i <= 12; $i++){
      if($limit_month == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."月</OPTION>\n";}
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_day" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="limit_day">' . "\n";
       for ($i = 1; $i <= 31; $i++){
      if($limit_day == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."日</OPTION>\n";}
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_hour" style="margin-left:1%"></label>
  <?php
  echo '<select required="required" name="limit_hour">' . "\n";
  for ($i = 0; $i <= 23; $i++){
      if($limit_hour == $i){$selected="selected";}
      else {$selected="";}
      echo "<OPTION value=". $i ." ". $selected .">".$i."時</OPTION>\n";}
  echo '</select>' . "\n";
  ?>
  <br><br><br>

   
  <label for="category" style="margin-left:-7%">分類*：</label>
  <?php
  echo '<select name="category">' . "\n";	      
     if($event_category == 1) {
     echo '<option value="全て" selected>全て</option>\n';
     } else {
     echo '<option value="全て">全て</option>\n';
     }
     if($event_category == 2) {
     echo '<option value="グルメ/フェスティバル" selected>グルメ/フェスティバル</option>\n';
     } else {
     echo '<option value="グルメ/フェスティバル">グルメ/フェスティバル</option>\n';
     }
     if($event_category == 3) {
     echo '<option value="芸術/エンタメ" selected>芸術/エンタメ</option>\n';
     } else {
     echo '<option value="芸術/エンタメ">芸術/エンタメ</option>\n';
     }
     if($event_category == 4) {
     echo '<option value="交流/スポーツ" selected>交流/スポーツ</option>\n';
     } else {
     echo '<option value="交流/スポーツ">交流/スポーツ</option>\n';
     }
     if($event_category == 5) {
     echo '<option value="地域復興/福祉" selected>地域復興/福祉</option>\n';
     } else {
     echo '<option value="地域復興/福祉">地域復興/福祉</option>\n';
     }
     if($event_category == 6) {
     echo '<option value="就活/キャリア" selected>就活/キャリア</option>\n';
     } else {
     echo '<option value="就活/キャリア">就活/キャリア</option>\n';
     }
     echo '</select>' . "\n";
  ?>
  <br><br><br>
  
  <label for="event_detail" style="margin-left:-1%">イベント詳細：</label>
  <textarea name="event_detail" rows="7" cols="40"><?php echo $event_detail ?></textarea>
  <br><br><br>

  <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
  <input type="reset" id="delete" name="delete" value="クリアする">
  <input type="submit" id="move_conf" name="move_conf" value="確認画面へ進む">

  </form>
  </body>
</html>
