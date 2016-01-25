<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    if (empty($user_id)) {
         header("LOCATION: ../login.php");
    }
    
    //ログイン中の利用者の名前の取得
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');
    $sql_login = "SELECT USER_LAST_NAME, USER_FIRST_NAME FROM UR WHERE USER_ID = $user_id";
    $result_login = mysql_query($sql_login, $link);
    if (!$result_login) {
        die('クエリが失敗しました。'.mysql_error());
    }
    while ($row_login = mysql_fetch_array($result_login)) {
         $last_name_login = $row_login['USER_LAST_NAME'];
         $first_name_login = $row_login['USER_FIRST_NAME'];
    }
    $name_login = $last_name_login." ".$first_name_login;
    mysql_close($link);

 //データベース接続
    $conn0 = mysql_connect('localhost', 'root', 'root');
    if (!$conn0) {
      die("データベース接続失敗");
    }
    //データベース選択
    mysql_select_db('greenbakari') or die("データベース選択失敗");
    //文字コード指定
    mysql_set_charset('utf8');

    //mysql切断
    mysql_close($conn0);


  $event_id = $_POST["event_id"];
  $event_title= $_POST['event_title'];
  $host_comment = $_POST['host_comment'];
  $event_year = $_POST['event_year'];
  $event_month = $_POST['event_month'];
  $event_day = $_POST['event_day'];
  $start_hour = $_POST['start_hour'];
  $finish_hour = $_POST['finish_hour'];
  $event_place = $_POST['event_place'];
  $limit_year = $_POST['limit_year'];
  $limit_month = $_POST['limit_month'];
  $limit_day = $_POST['limit_day'];
  $limit_hour = $_POST['limit_hour'];
  $event_category = $_POST['category'];
  $event_detail = $_POST['event_detail'];
  $imgtmp = $_FILES['event_image']['tmp_name'];
  $imgtype = $_FILES['event_image']['type'];
  $filepass = "../img/".$_FILES['event_image']['name'];
  $kaku="";
  if (is_uploaded_file($imgtmp)) {
    if ($imgtype=="image/gif") {
        $kaku=".gif";    
    } else if ($imgtype=="image_png" || $imgtype=="image/x-png") {
        $kaku=".png";               
    } else if ($imgtype=="image/jpeg" || $imgtype=="image/pjpeg") {
        $kaku=".jpg";                
    } else if ($kaku=="") {
        $error="アップロード画像に誤りがあります";
    }         
    if ($kaku != ""){
        $boRtn = move_uploaded_file($imgtmp, $filepass);
        if ($boRtn){
            $error="アップロードに成功しました。";
        } else {
            $error="アップロードに失敗しました。";
        }
    } else {
        $error="ファイルの種類に誤りがあります。";
    }
  }

//登録 
  if ($_POST["insert"] != NULL) {
    $event_id = $_POST['e_id'];
    $user_id = $_POST['u_id'];
    $event_title = $_POST['e_title'];
    $host_comment = $_POST['h_comment'];
    $event_year = $_POST['e_year'];
    $event_month = $_POST['e_month'];
    $event_day = $_POST['e_day'];
    $start_hour = $_POST['s_hour'];
    $finish_hour = $_POST['f_hour'];
    $event_place = $_POST['e_place'];
    $limit_year = $_POST['l_year'];
    $limit_month = $_POST['l_month'];
    $limit_day = $_POST['l_day'];
    $limit_hour = $_POST['l_hour'];
    $event_category = $_POST['e_category'];
    switch ($event_category) {
      case "グルメ/フェスティバル":
      $category = 1;
      break;
      case "芸術/エンタメ":
      $category = 2;
      break;
      case "交流/スポーツ":
      $category = 3;
      break;
      case "地域復興/福祉":
      $category = 4;
      break;
      case "就活/キャリア":
      $category = 5;
      break;
    }
    $event_detail = $_POST['e_detail'];
    $imgtemp = $_POST['imgtemp'];
    $imgtype = $_POST['imgtype'];
    $filepass = $_POST['filepass'];
    $update_date = date("Y-m-d H:i:s",strtotime("now"));
    $event_start = date("$event_year-$event_month-$event_day $start_hour:00:00");
    $event_finish = date("$event_year-$event_month-$event_day $finish_hour:00:00");
    $participation_deadline = date("$limit_year-$limit_month-$limit_day $limit_hour:00:00");

    //データベース接続
    $conn = mysql_connect('localhost', 'root', 'root');
    if (!$conn) {
      die("データベース接続失敗");
    }
    
    //データベース選択
    mysql_select_db('greenbakari') or die("データベース選択失敗");
   
    // 画像の取得
    if ($filepass) {
      $fp = fopen($filepass,'rb');
      $size = filesize($filepass);
      $img_file = fread($fp, $size);
      fclose($fp);
    //画像をバイナリに変換
    //$str = mb_convert_encoding ( $imgdata, "UTF-8" );
    //$img_binary = mysqli_real_escape_string($conn , $img_file);//addslashes($img_file);
    $img_binary = addslashes($img_file);
   } 

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
    $sql = "SELECT MAX(EVENT_ID) FROM EV";
    $new = mysql_query($sql);
    while ($new_id = mysql_fetch_array($new)) {
      $evt_id = ++$new_id['MAX(EVENT_ID)'];
    }
    //INSERT文発行
    $sql = "INSERT INTO EV(EVENT_ID, USER_ID, EVENT_TITLE, CATEGORY, EVENT_START, EVENT_FINISH, HOLDING_PLACE, PARTICIPATION_DEADLINE, HOLDING_COMMENT, EVENT_DETAIL, EVENT_IMAGE, UPDATE_DATE) VALUES($evt_id, $user_id, '$event_title', $category, '$event_start', '$event_finish', '$event_place', '$participation_deadline', '$host_comment', '$event_detail', '$img_binary', '$update_date')";
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

    if ($img_binary) {
    $sql_img = "UPDATE EV SET EVENT_IMAGE = '$img_binary' WHERE EVENT_ID = $event_id;";
    $res = mysql_query($sql_img);

    if ($res) {
    //成功時はコミットする
      $sql = "COMMIT";
      mysql_query($sql, $conn);
      //echo "コミットしました";
    } else {
      //失敗時はロールバックする
      $sql = "ROLLBACK";
      mysql_query($sql, $conn);
      echo "登録失敗しました";
    }
    }
    
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
      echo "登録失敗しました";
    }

    //mysql切断
    mysql_close($conn);

    //ページ遷移
    header("Location:event.php");
  }
?>

<html>
<head>
<meta charset="UTF-8">
<title>イベント登録確認</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<link rel="stylesheet" href="../css/ev_style.css" type="text/css">
  <body topmargin="100" bottommargin="100">
<div id="headerArea">
    <table>
        <tr>
            <td class="logo"><a href="http://localhost/kocote/index.php"><img class="logo-image" src="../img/kocote.png"></a></td>
            <td class="face"><img class="login-image" src="../img/login.jpg"></td>
            <td class="name"><p class="login-name"><?php echo $name_login;?></p></td>
            <td class="logout"><form id="logoutForm" name="logoutForm" action="../logout.php" method="POST">
            <input id="logout-botton" type="submit" id="logout" name="formname" value="ログアウト" >
            </form></td>
        </tr>
    </table>
</div>

  <form id="loginForm"  action="event_conf.php" method="POST" enctype="multipart/form-data" name="formDate">
  <!-- <?php echo $errorMessage ?> -->
 
<!-- 機能選択ボタン -->
<div id="box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a></div>
  <br>

  <p>以下の内容でイベントを登録します。よろしければ「登録する」をクリックしてください。</P>
<table class="data">
<tr>
<td class="title">
  <p>イベントタイトル*：</p>
</td>
<td class="context">
  <input type="text" id="event_title" name="event_title" disabled="disabled" value="<?php echo $event_title; ?>" required="required"></input>
</td>
</tr>

<tr>
<td class="title">
  <p>主催者コメント：</p>
</td>
<td class="context">
  <textarea disabled="disabled" rows="3" cols="40">
  <?php
  echo $host_comment;
  ?>
  </textarea>
</td>
</tr>

<tr>
<td class="title">
  <p>開催日*：</p>
</td>
<td class="context">
  <select name="event_year" required>
  <?php echo "<OPTION value=" . $event_year . " >" . $event_year . "</OPTION>\n";?>
  </select> 年
  <select name="event_month" onchange="set_event_day()" required>
  <?php echo "<OPTION value=" . $event_month . " >" . $event_month . "</OPTION>\n";?>
  </select> 月
  <select name="event_day" required>
  <?php echo "<OPTION value=" . $event_day . " >" . $event_day . "</OPTION>\n";?>
  </select> 日
</td>
</tr>


<tr>
<td class="title">
  <p>開催時間*：</p>
</td>
<td class="context">
  <?php
  echo '<select required="required" name="start_hour">' . "\n";
  echo "<OPTION value=" . $start_hour . " >" . $start_hour . "</OPTION>\n";
  echo '</select>' . " 時\n";
    echo "&nbsp;&nbsp;～&nbsp;&nbsp;"
  ?>
  <label for="finish_hour" style="margin-left:0%"></label>
  <?php
  echo '<select required="required" name="finish_hour">' . "\n";
  echo "<OPTION value=" . $finish_hour . " >" . $finish_hour . "</OPTION>\n";
  echo '</select>' . " 時\n";
  ?>
</td>
</tr>


<tr>
<td class="title">
  <p>開催場所*：</p>
</td>
<td class="context">
  <input type="text" id="event_place" name="event_place" disabled="disabled" value="<?php echo $event_place ?>" required></input>
</td>
</tr>

<tr>
<td class="title">
  <p>参加応募締め切り*：</p>
</td>
<td class="context">
  <select name="limit_year" required>
  <?php echo "<OPTION value=" . $limit_year . " >" . $limit_year . "</OPTION>\n";?>
  </select> 年
  <select name="limit_month" onchange="set_event_day()" required>
  <?php echo "<OPTION value=" . $limit_month . " >" . $limit_month . "</OPTION>\n";?>
  </select> 月
  <select name="limit_day" required>
  <?php echo "<OPTION value=" . $limit_day . " >" . $limit_day . "</OPTION>\n";?>
  </select> 日
  <select name="limit_hour" required>
  <?php echo "<OPTION value=" . $limit_hour . " >" . $limit_hour . "</OPTION>\n";?>
  </select> 時
</td>
</tr>

<tr>
<td class="title">
  <p>分類*：</p>
</td>
<td class="context">
  <select name="event_category" required="required">
  <option>
  <?php
  echo $event_category;
  ?>
  </option>
  </select>
</td>
</tr>

<tr>
<td class="title">
  <p>イベント詳細：</p>
</td>
<td class="context">
  <textarea disabled="disabled" rows="3" cols="40">
  <?php
  echo $event_detail;
  ?>
  </textarea>
</td>
</tr>
</table>  
  <?php
  if($imgtmp) {
  echo '<p>';
  echo '<img class="event-conf-image" src="'.$filepass.'" size=10>';
  echo '</p>';
  } else {
  echo '<img class="event-conf-image" src="event_detail_image.php?event_id='.$event_id.'&image_id=a">';
  }
  ?>
  
  <form id="loginForm" name="loginForm" action="" method="POST" entype="multipart/form-data">
  <input type="hidden" name="e_id" value="<?php echo $event_id ?>">
  <input type="hidden" name="u_id" value="<?php echo $user_id ?>">
  <input type="hidden" name="e_title" value="<?php echo $event_title ?>">
  <input type="hidden" name="h_comment" value="<?php echo $host_comment ?>">
  <input type="hidden" name="e_year" value="<?php echo $event_year ?>">
  <input type="hidden" name="e_month" value="<?php echo $event_month ?>">
  <input type="hidden" name="e_day" value="<?php echo $event_day ?>">
  <input type="hidden" name="s_hour" value="<?php echo $start_hour ?>">
  <input type="hidden" name="f_hour" value="<?php echo $finish_hour ?>">
  <input type="hidden" name="e_place" value="<?php echo $event_place ?>">
  <input type="hidden" name="l_year" value="<?php echo $limit_year ?>">
  <input type="hidden" name="l_month" value="<?php echo $limit_month ?>">
  <input type="hidden" name="l_day" value="<?php echo $limit_day ?>">
  <input type="hidden" name="l_hour" value="<?php echo $limit_hour ?>">
  <input type="hidden" name="e_category" value="<?php echo $event_category ?>">
  <input type="hidden" name="e_detail" value="<?php echo $event_detail ?>">
  <input type="hidden" name="imgtemp" value="<?php echo $imgtemp ?>">
  <input type="hidden" name="imgtype" value="<?php echo $imgtype ?>">
  <input type="hidden" name="filepass" value="<?php echo $filepass ?>">
  <input type="submit" id="insert" name="insert" value="登録する">
  </form>


  <div id="footerArea">
<ul>
<li><a href="">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="">個人情報保護方針</a></li>
<li><a href="">採用情報</a></li>
<li><a href="">サイトマップ</a></li>
</ul>
</div>
</center>
  </body>
</html>

