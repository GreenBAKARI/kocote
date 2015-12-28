<?php
//$user_id = $_POST["user_id"];
  $user_id = 7;
//ユーザidの取得
//$user_name = $_POST["user_name"];
  $user_name = "gereenbakari"
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

  <form id="loginForm" na	me="loginForm" action="conf.php" method="POST" enctype="multipart/form-data">
  <!-- 登録・編集確認画面に遷移 : action="conf.php" -->

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
  <input type="text" id="event_title" name="event_title" required>
  <br><br><br>

  <label for="host_comment" style="margin-left:-2%">主催者コメント：</label>
  <textarea name="host_comment" rows="3" cols="40"></textarea>
  <br><br><br>

  <label for="event_month" style="margin-left:-9%">開催日*：</label>
  <?php
  echo '<select required="required" name="event_month">' . "\n";
  for ($i = 0; $i <= 12; $i++){
      if($i == 0){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "月</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;";
  ?>
  <label for="event_day" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="event_day">' . "\n";
  for ($i = 0; $i <= 31; $i++){
      if($i == 0){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "日</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  <label for="start_hour" style="margin-left:-9%">開催時間*：</label>
  <?php
  echo '<select required="required" name="start_hour">' . "\n";
  for ($i = -1; $i <= 23; $i++){
      if($i == -1){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
    echo "&nbsp;&nbsp;～&nbsp;&nbsp;"
  ?>
  <label for="finish_hour" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="finish_hour">' . "\n";
  for ($i = -1; $i <= 23; $i++){
      if($i == -1){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
  <input type="text" id="event_place" name="event_place" required>
  <br><br><br>

  <label for="limit_month" style="margin-left:-9%">参加応募締め切り*：</label>
  <?php
  echo '<select required="required" name="limit_month">' . "\n";
  for ($i = 0; $i <= 12; $i++){
      if($i == 0){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "月</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_day" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="limit_day">' . "\n";
  for ($i = 0; $i <= 31; $i++){
      if($i == 0){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "日</OPTION>\n";}
  }
  echo '</select>' . "\n";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  ?>
  <label for="limit_hour" style="margin-left:1%"></label>
  <?php
  echo '<select required="required" name="limit_hour">' . "\n";
  for ($i = -1; $i <= 23; $i++){
      if($i == -1){echo "<OPTION></OPTION>\n";}
      else{echo "<OPTION value=" . $i . " >" . $i . "時</OPTION>\n";}
  }
  echo '</select>' . "\n";
  ?>
  <br><br><br>

  
  <label for="category" style="margin-left:-7%">分類*：</label>
  <select name="category">
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

<!--
<?php
//echo '<form action="conf.php" method="post">';
//echo '<input type="submit">';
//echo '</form>';
// ヘッダ画像
//$ua = mysql_fetch_assoc ( $sql_result_ua );
echo '<p>';
//echo '<img src="./img_get.php?img=HEADER_IMAGE"/>';
echo 'イベント画像：<input type="file" name="event_image" size="50"><BR>';
echo '</p>';
?>
-->
  <label for="event_image" style="margin-left:-1%">イベント画像：</label>
  <input type="file" name="event_image" size="100" accept="image/*">
  <img src="./$event_image">
  <br><br><br>


  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
  <input type="reset" id="delete" name="delete" value="クリアする">
  <input type="submit" id="move_conf" name="move_conf" value="確認画面へ進む">

  </form>
  </body>
</html>


