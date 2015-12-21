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
    <a href="http://localhost/php/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
<br><br><br>

<a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" style="margin-left:-10%" height="8%" width="5%" align="bottom"><font size="6" color="#000000">利用者名</font></a>
<br><br><br>

<label for="event_title" style="margin-left:-10%">イベントタイトル*：</label>
<input type="text" id="event_title" name="event_title">
<br><br><br>

<label for="event_comment" style="margin-left:-2%">主催者コメント：</label>
<textarea name="event_comment" rows="3" cols="40"></textarea>
<br><br><br>

  <label for="month" style="margin-left:-9%">開催日*：</label>
  <?php
  echo '<select name="month">' . "\n";
  for ($i = 0; $i <= 12; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "月</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;";
  ?>
  <label for="date" style="margin-left:0%"></label>
  <?php
  echo '<select name="date">' . "\n";
  for ($i = 0; $i <= 31; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "日</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  <label for="start_hour" style="margin-left:-9%">開催時間*：</label>
  <?php
  echo '<select name="start_hour">' . "\n";
  for ($i = 0; $i <= 24; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
    echo "&nbsp;&nbsp;～&nbsp;&nbsp;"
  ?>
  <label for="finish_hour" style="margin-left:0%"></label>
  <?php
  echo '<select name="finish_hour">' . "\n";
  for ($i = 0; $i <= 24; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>


  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
  <input type="text" id="event_place" name="event_place">
  <br><br><br>



  <label for="limit_month" style="margin-left:-9%">参加応募締め切り*：</label>
  <?php
  echo '<select name="limit_month">' . "\n";
  for ($i = 0; $i <= 12; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "月</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_date" style="margin-left:0%"></label>
  <?php
  echo '<select name="limit_date">' . "\n";
  for ($i = 0; $i <= 31; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "日</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_hour" style="margin-left:1%"></label>
  <?php
  echo '<select name="limit_hour">' . "\n";
  for ($i = 0; $i <= 24; $i++){
      if($i == 0){echo "<OPTION value=0 >----</OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  
  <label for="time" style="margin-left:-7%">分類*：</label>
  <select name="time">
  <option value="全て">全て</option>
  <option value="グルメ/フェスティバル">グルメ/フェスティバル</option>
  <option value="芸術/エンタメ">芸術/エンタメ</option>
  <option value="交流/スポーツ">交流/スポーツ</option>
  <option value="地域復興/福祉">地域復興/福祉</option>
  <option value="就活/キャリア">就活/キャリア</option>
  </select><br><br><br>

  <label for="event_detail" style="margin-left:-1%">イベント詳細：</label>
  <textarea name="event_detail" rows="7" cols="40"></textarea>
  <br><br><br>


  <input type="reset" id="delete" name="delete" value="クリアする">
  <input type="submit" id="edit_conf" name="edit_conf" value="確認画面へ進む">

  </form>
  </body>
</html>
