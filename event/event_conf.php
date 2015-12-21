<?php
  $user_id = 0;
  $event_title = $_POST['event_title'];
  echo $_POST['event_title'];
  echo $event_title;
  $date = date("Y-m-d H:i:s",strtotime("now"));

  if (isset($_POST["insert"]) == true) {
  $event_title = $_POST['event_title'];
  echo "$date<br />";
  echo $event_title;
  if($event_title === NULL){
        echo "ない<br />";
    }
  echo $_POST['$event_title'];
  echo "8<br />";
  
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
  $sql = "SELECT COUNT(*) FROM EV";
  $new = mysql_query($sql);
  while ($new_id = mysql_fetch_array($new)) {
  $id = ++$new_id['COUNT(*)'];
  }
  //INSERT文発行
  $sql = "INSERT INTO EV(EVENT_ID, USER_ID, EVENT_TITLE) VALUES($id, $user_id, '$event_title')";
  $res = mysql_query($sql);

  if ($res) {
  //成功時はコミットする
  $sql = "COMMIT";
  mysql_query($sql, $conn);
  echo "コミットしました";
  } else {
  //失敗時はロールバックする
  $sql = "ROLLBACK";
  mysql_query($sql, $conn);
  echo "ロールバックしました";
  }

  //mysql切断
  mysql_close($conn);
  } 
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

<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->

<div id = "box">
    <a href="http://localhost/php/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
<br><br><br>



<a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" style="margin-left:-10%" height="8%" width="5%" align="bottom">

<font size="6" color="#000000">利用者名</font></a>
<br><br><br>

<label for="event_title" style="margin-left:-10%">イベントタイトル*：</label>
<input type="text" id="event_title" name="event_title" disabled="disabled" value="<?php echo $event_title ?>"></input>
<br><br><br>

<label for="event_comment" style="margin-left:-2%">主催者コメント：</label>
<textarea disabled="disabled" rows="3" cols="40">
<?php
echo $_POST["event_comment"];
?>
</textarea>
<!--textarea name="event_comment" rows="3" cols="40"></textarea-->
<br><br><br>

  <label for="month" style="margin-left:-9%">開催日*：</label>
  <?php
  echo "<SELECT>\n";
  if($_POST['month'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
  else{echo "<OPTION value=" . $_POST["month"] . " >" . $_POST["month"] . "月</OPTION>\n";}
  echo "</SELECT>";
  echo "&nbsp;&nbsp;";
  echo "<SELECT>\n";
  if($_POST['date'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
  else{echo "<OPTION value=" . $_POST["date"] . " >" . $_POST["date"] . "日</OPTION>\n";}
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="start_hour" style="margin-left:-9%">開催時間*：</label>
  <?php
  echo "<SELECT>\n";
  if($_POST['start_hour'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
  else{echo "<OPTION value=" . $_POST["start_hour"] . " >" . $_POST["start_hour"] . "時</OPTION>\n";}
  echo "</SELECT>";
  echo "&nbsp;&nbsp;～&nbsp;&nbsp;";
  echo "<SELECT>\n";
  if($_POST['finish_hour'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
  else{echo "<OPTION value=" . $_POST["finish_hour"] . " >" . $_POST["finish_hour"] . "時</OPTION>\n";}
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
  <input type="text" id="event_place" name="event_place" disabled="disabled" value="<?php echo $_POST["event_place"]?>"></input>
    <br><br><br>

  <label for="time" style="margin-left:-10%">参加応募締め切り*：</label>
  <?php
  echo "<SELECT>\n";
      if($_POST['limit_month'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $_POST["limit_month"] . " >" . $_POST["limit_month"] . "月</OPTION>\n";}
  echo "</SELECT>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<SELECT>\n";
      if($_POST['limit_date'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $_POST["limit_date"] . " >" . $_POST["limit_date"] . "日</OPTION>\n";}
  echo "</SELECT>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<SELECT>\n";
      if($_POST['limit_hour'] == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $_POST["limit_hour"] . " >" . $_POST["limit_hour"] . "時</OPTION>\n";}
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="time" style="margin-left:-7%">分類*：</label>
  <select name="time">
  <option><?php echo $_POST["time"]?></option>
  
  <!--option value="全て">全て</option>
  <option value="グルメ/フェスティバル">グルメ/フェスティバル</option>
  <option value="芸術/エンタメ">芸術/エンタメ</option>
  <option value="交流/スポーツ">交流/スポーツ</option>
  <option value="地域復興/福祉">地域復興/福祉</option>
  <option value="就活/キャリア">就活/キャリア</option-->
  </select><br><br><br>

  <label for="event_detail" style="margin-left:-1%">イベント詳細：</label>
  <textarea disabled="disabled" rows="3" cols="40">
<?php
echo $_POST["event_detail"];
?>
</textarea>
  <!--textarea name="event_comment" rows="7" cols="40"></textarea-->
  <br><br><br>

  <!--input type="reset" id="delete" name="delete" value="クリアする"-->
  <input type="submit" id="insert" name="insert" value="登録する">

  </form>


  </body>
</html>

