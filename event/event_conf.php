<?php
  $event_id = $_POST['event_id'];
  $user_id = $_POST['user_id'];
  $user_name = $_POST["user_name"];
  $event_title= $_POST['event_title'];
  $host_comment = $_POST['host_comment'];
  $event_month = $_POST['event_month'];
  $event_day = $_POST['event_day'];
  $start_hour = $_POST['start_hour'];
  $finish_hour = $_POST['finish_hour'];
  $event_place = $_POST['event_place'];
  $limit_month = $_POST['limit_month'];
  $limit_day = $_POST['limit_day'];
  $limit_hour = $_POST['limit_hour'];
  $event_category = $_POST['category'];
  $event_detail = $_POST['event_detail'];

  if ($_POST["insert"] != NULL) {
    $event_id = $_POST['e_id'];
    $user_id = $_POST['u_id'];
    $event_title = $_POST['e_title'];
    $host_comment = $_POST['h_comment'];
    $event_month = $_POST['e_month'];
    $event_day = $_POST['e_day'];
    $start_hour = $_POST['s_hour'];
    $finish_hour = $_POST['f_hour'];
    $event_place = $_POST['e_place'];
    $limit_month = $_POST['l_month'];
    $limit_day = $_POST['l_day'];
    $limit_hour = $_POST['l_hour'];
    $event_category = $_POST['e_category'];
    switch ($event_category) {
      case '全て':
      $category = 1;
      break;
      case "グルメ/フェスティバル":
      $category = 2;
      break;
      case "芸術/エンタメ":
      $category = 3;
      break;
      case "交流/スポーツ":
      $category = 4;
      break;
      case "地域復興/福祉":
      $category = 5;
      break;
      case "就活/キャリア":
      $category = 6;
      break;
      default:
      $category = 1;
    }
    $event_detail = $_POST['e_detail'];
    $update_date = date("Y-m-d H:i:s",strtotime("now"));
    $event_year = date("Y");
    if (strtotime($update_date) >= strtotime(date("$event_year-$event_month-$event_day $start_hour:00:00"))) {
    ++$event_year;
    }
    $event_start = date("$event_year-$event_month-$event_day $start_hour:00:00");
    $event_finish = date("$event_year-$event_month-$event_day $finish_hour:00:00");
    $limit_year = date("Y");
    if (strtotime($update_date) >= strtotime(date("$limit_year-$limit_month-$limit_day $limit_hour:00:00"))) {
    ++$limit_year;
    }
    $participation_deadline = date("$limit_year-$limit_month-$limit_day $limit_hour:00:00");

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

    if ($event_id == NULL){
    //最後のイベントIDを取得
    $sql = "SELECT COUNT(*) FROM EV";
    $new = mysql_query($sql);
    while ($new_id = mysql_fetch_array($new)) {
      $evt_id = ++$new_id['COUNT(*)'];
    }
    //INSERT文発行
    $sql = "INSERT INTO EV(EVENT_ID, USER_ID, EVENT_TITLE, CATEGORY, EVENT_START, EVENT_FINISH, HOLDING_PLACE, PARTICIPATION_DEADLINE, HOLDING_COMMENT, EVENT_DETAIL, UPDATE_DATE) VALUES($evt_id, $user_id, '$event_title', $category, '$event_start', '$event_finish', '$event_place', '$participation_deadline', '$host_comment', '$event_detail', '$update_date')";
    } else {
    //UPDATE文発行
    $sql = "UPDATE EV 
    SET USER_ID = $user_id, 
    EVENT_TITLE = '$event_title', 
    CATEGORY =  $category, 
    EVENT_START = '$event_start', 
    EVENT_FINISH = '$event_finish', 
    HOLDING_PLACE = '$event_place', 
    PARTICIPATION_DEADLINE = '$participation_deadline',
    HOLDING_COMMENT = '$host_comment', 
    EVENT_DETAIL = '$event_detail', 
    UPDATE_DATE = '$update_date' 
    WHERE EVENT_ID = $event_id;";
    }


    $res = mysql_query($sql);

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

    //ページ遷移
    header( "Location: http://localhost/" );
  }
?>


<!--
↑制御
↓表示
-->



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


  <div id = "box">
    <a href="http://localhost/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br><br><br>

  <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" style="margin-left:-10%" height="8%" width="5%" align="bottom">

  <font size="6" color="#000000"><?php echo $user_name ?></font></a>
  <br><br><br>

  <label for="event_title" style="margin-left:-10%">イベントタイトル*：</label>
  <input type="text" id="event_title" name="event_title" disabled="disabled" value="<?php echo $event_title; ?>"></input>
  <br><br><br>

  <label for="host_comment" style="margin-left:-2%">主催者コメント：</label>
  <textarea disabled="disabled" rows="3" cols="40">
  <?php
  echo $host_comment;
  ?>
  </textarea>
  <br><br><br>

  <label for="time" style="margin-left:-9%">開催日*：</label>
  <?php
  echo "<SELECT>\n";
  echo "<OPTION value=" . $event_month . " >" . $event_month . "月</OPTION>\n";
  echo "</SELECT>";
  echo "&nbsp;&nbsp;";
  echo "<SELECT>\n";
  echo "<OPTION value=" . $event_day . " >" . $event_day . "日</OPTION>\n";
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="time" style="margin-left:-9%">開催時間*：</label>
  <?php
  echo "<SELECT>\n";
  echo "<OPTION value=". $start_hour ." >". $start_hour ."時</OPTION>\n";
  echo "</SELECT>";
  echo "&nbsp;&nbsp;～&nbsp;&nbsp;";
  echo "<SELECT>\n";
  echo "<OPTION value=" . $finish_hour . " >" . $finish_hour . "時</OPTION>\n";
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
  <input type="text" id="event_place" name="event_place" disabled="disabled" value="<?php echo $event_place ?>"></input>
    <br><br><br>

  <label for="time" style="margin-left:-10%">参加応募締め切り*：</label>
  <?php
  echo "<SELECT>\n";
  echo "<OPTION value=" . $limit_month . " >" . $limit_month . "月</OPTION>\n";
  echo "</SELECT>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<SELECT>\n";
  echo "<OPTION value=" . $limit_day . " >" . $limit_day . "日</OPTION>\n";
  echo "</SELECT>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<SELECT>\n";
  echo "<OPTION value=" . $limit_hour . " >" . $limit_hour . "時</OPTION>\n";
  echo "</SELECT>";
  ?>
  <br><br><br>

  <label for="category" style="margin-left:-7%">分類*：</label>
  <select name="event_category">
  <option>
  <?php
  echo $event_category;
  ?>
  </option>
  </select>
  <br><br><br>
  
  <label for="event_detail" style="margin-left:-1%">イベント詳細：</label>
  <textarea disabled="disabled" rows="3" cols="40">
  <?php
  echo $event_detail;
  ?>
  </textarea>
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
echo 'イベント画像：<input type="file" name="event_image"] size="100"><BR>';
//echo '<img src="'.$_FILES["event_image"]["tmp_name"].'">';
//move_uploaded_file($_FILES['event_image']['tmp_name'],'./img/'.$_FILES['event_image']['tmp_name']);
//print '<img src="./img/'.$_FILES['event_image']['name'].'">';
//echo $_FILES["event_image"]["name"];
echo '<img src="'.$_FILES['event_image']['tmp_name'].'">';
echo '</p>';
?>
-->

<?php
echo '<p>';
$img1tmp = $_FILES['event_image']['tmp_name'];
$img1type = $_FILES['event_image']['type'];
$filepass = "img/".$_FILES['event_image']['name'];
$kaku="";
if (is_uploaded_file($img1tmp)) {
    if ($img1type=="image/gif") {
        $kaku=".gif";    
    } else if ($img1type=="image_png" || $img1type=="image/x-png") {
        $kaku=".png";               
    } else if ($img1type=="image/jpeg" || $img1type=="image/pjpeg") {
        $kaku=".jpg";                
    } else if ($kaku=="") {
        $error="アップロード画像に誤りがあります";
    }         
    if ($kaku != ""){
        $boRtn = move_uploaded_file($img1tmp, $filepass);
        if ($boRtn){
            $error="アップロードに成功しました。";
        } else {
            $error="アップロードに失敗しました。";
        }
    } else {
        $error="ファイルの種類に誤りがあります。";
    }
}
 
echo '<img src="'.$filepass.'" size=10>';
echo '</p>';
?>
 
  <form id="loginForm" name="loginForm" action="" method="POST">
  <input type="hidden" name="e_id" value="<?php echo $event_id ?>">
  <input type="hidden" name="u_id" value="<?php echo $user_id ?>">
  <input type="hidden" name="e_title" value="<?php echo $event_title ?>">
  <input type="hidden" name="h_comment" value="<?php echo $host_comment ?>">
  <input type="hidden" name="e_month" value="<?php echo $event_month ?>">
  <input type="hidden" name="e_day" value="<?php echo $event_day ?>">
  <input type="hidden" name="s_hour" value="<?php echo $start_hour ?>">
  <input type="hidden" name="f_hour" value="<?php echo $finish_hour ?>">
  <input type="hidden" name="e_place" value="<?php echo $event_place ?>">
  <input type="hidden" name="l_month" value="<?php echo $limit_month ?>">
  <input type="hidden" name="l_day" value="<?php echo $limit_day ?>">
  <input type="hidden" name="l_hour" value="<?php echo $limit_hour ?>">
  <input type="hidden" name="e_category" value="<?php echo $event_category ?>">
  <input type="hidden" name="e_detail" value="<?php echo $event_detail ?>">
  <input type="submit" id="insert" name="insert" value="登録する">
  </form>


  </body>
</html>

