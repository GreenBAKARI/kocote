<?php
   $event_id = 86;
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

    //最後のイベントIDを取得
    $sql = "SELECT * FROM EV WHERE EVENT_ID = $event_id";
    $res = mysql_query($sql);
    while ($new = mysql_fetch_array($res)) {
    $user_id = $new['USER_ID'];
    $event_title = $new['EVENT_TITLE'];
    $host_comment = $new['HOLDING_COMMENT'];
    $event_start = $new['EVENT_START'];
    $event_year = date('Y', strtotime($event_start));
    $event_month = date('m', strtotime($event_start));
    $event_day = date('d', strtotime($event_start));
    $start_hour = date('H', strtotime($event_start));
    $event_finish = $new['EVENT_FINISH'];
    $finish_hour = date('H', strtotime($event_finish));
    $event_place = $new['HOLDING_PLACE'];
    $participation_deadline = $new['PARTICIPATION_DEADLINE'];
    $limit_year = date('Y', strtotime($participation_deadline));
    $limit_month = date('m', strtotime($participation_deadline));
    $limit_day = date('d', strtotime($participation_deadline));
    $limit_hour = date('H', strtotime($participation_deadline));
    $event_category = $new['CATEGORY'];
    $event_detail = $new['EVENT_DETAIL'];
    }

    //mysql切断
    mysql_close($conn);

    //指定したid_colを持つ画像を表示する関数
    function CallImg($event_id){
	echo '<img src="'.ImgSearchDB($event_id).'">';
    }

    //データベースから、指定したid_colを持つimageファイルを検索する関数。
    function ImgSearchDB($event_id){
		
	//データベースへ接続する
	$conn = mysql_connect('localhost', 'root', 'root');
	
	//指定したidのimgを検索
	$serch_query = mysqli_query($conn,"SELECT * FROM `EV` WHERE `EVENT_ID` ='".$event_id."'");
	$row = mysqli_fetch_array($serch_query);
	
	header( 'Content-Type: image/jpeg' );
	echo $row['EVENT_IMAGE'];
	
	$close_flag = mysqli_close($conn);
     }

  //イベント削除
  if ($_POST["delete"] != NULL) {
    $event_id = $_POST['event_id'];
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
    $sql =  "DELETE FROM EV WHERE EVENT_ID = $event_id";
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
    header( "Location: event.php" );
  }

?>



<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<link rel="stylesheet" href="../css/ev_style.css" type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>

<form id="loginForm" name="formDate" action="event_conf.php" method="POST" entype="multipart/form-data">
  <!-- <?php echo $errorMessage ?> -->

<div id = "box">
<a href="event.php"><img src="../img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="../search/search.php"><img src="../img/se_home.jpg" height="7%" width="16%"></a>
    <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="7%" width="16%"></a></div>
<br><br><br>

<a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" style="margin-left:-10%" height="8%" width="5%" align="bottom"><font size="6" color="#000000"><?php echo $user_name ?></font></a>

<table class="data">
<tr>
<td class="title">
<label for="event_title" style="margin-left:-10%">イベントタイトル*：</label>
</td>
<td class="context">
<input type="text" id="event_title" name="event_title" value="<?php echo $event_title ?>" required>
</td>
</tr>

<tr>
<td class="title">
<label for="host_comment" style="margin-left:-2%">主催者コメント：</label>
</td>
<td class="context">
<textarea name="host_comment" rows="3" cols="40"><?php echo $host_comment ?> </textarea>
</td>
</tr>

<tr>
<td class="title">
<label for="event_month" style="margin-left:-9%">開催日*:</label>
</td>
<td class="context">
  <select name="event_year" onchange="set_event_month()" required></select> 年
  <select name="event_month" onchange="set_event_day()" required></select> 月
  <select name="event_day" required></select> 日
</td>
</tr>

  <script type="text/javascript">
    var now = new Date();
    var now_year = now.getFullYear();
    var now_month = now.getMonth() + 1;
    var now_date = now.getDate();
    
    function uruu(Year) {
        var uruu = 
            (Year % 400 == 0) ? true :
            (Year % 100 == 0) ? false :
            (Year % 4 == 0) ? true : false;
        return uruu;
    }
    
    function set_event_year() {
        for (var y = now_year; y < now_year + 5; y++) {
            var select = document.formDate.event_year;
            var option = select.appendChild(document.createElement('option'));
            option.value = y;
            option.text = y;
            option.selected = (y == <?php echo $event_year; ?>) ? 'selected' : false;
        }
        set_event_month();
    }
    set_event_year();
  
    function set_event_month() {
        var Year =
            document.formDate.event_year.options[
            document.formDate.event_year.selectedIndex
            ].value;
        var select = document.formDate.event_month;
        while (select.options.length){
            select.removeChild(select.options[0]);
        }
        if (Year != 0) {
            for (var m = 1; m <= 12; m++){
                var option = select.appendChild(document.createElement('option'));
                option.value = m;
                option.text = m;
                option.selected =
                    (Year == now_year) ?
                    ((m == <?php echo $event_month; ?>) ? 'selected' : false ) :
                    ((m == <?php echo $event_month; ?>) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
        set_event_day();
    }

    function set_event_day() {
        var Year =
            document.formDate.event_year.options[
            document.formDate.event_year.selectedIndex
            ].value;
        var Month =
            document.formDate.event_month.options[
            document.formDate.event_month.selectedIndex
            ].value;
        var days =
            [31,(uruu(Year)?29:28),31,30,31,30,31,31,30,31,30,31];
        var select = document.formDate.event_day;
        while(select.options.length) {
            select.removeChild(select.options[0]);
        }
        
        if (Month != 0) {        
            for (var d = 1; d <= days[Month - 1]; d++) {
            var option = select.appendChild(document.createElement('option'));
            option.value = d;
            option.text = d;
            option.select =
	            (Year == now_year && Month == now_month) ?
                    ((d == <?php echo $event_day; ?>) ? 'selected' : false ) :
                    ((d == <?php echo $event_day; ?>) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
    }
    </script>

<tr>
<td class="title">
  <label for="start_hour" style="margin-left:-9%">開催時間*：</label>
</td>
<td class="context">
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
</td>
</tr>

<tr>
<td class="title">
  <label for="event_place" style="margin-left:-7%">開催場所*：</label>
</td>
<td class="context">
  <input type="text" id="event_place" name="event_place" value="<?php echo $event_place ?>" required>
</td>
</tr>

<tr>
<td class="title">
  <label for="limit_month" style="margin-left:-9%">参加応募締め切り*：</label>
</td>
<td class="context">
  <select required="required" name="limit_year" onchange="set_limit_month()"></select> 年
  <select required="required" name="limit_month" onchange="set_limit_day()"></select> 月
  <select required="required" name="limit_day"></select> 日
  <?php
  echo '<select required="required" name="limit_hour">' . "\n";
  for ($i = 0; $i <= 23; $i++){
      if($i == $limit_hour){echo "<OPTION value=" . $i . "selected >" . $i . "</OPTION>";}
      else{echo "<OPTION value=" . $i . " >" . $i . "</OPTION>";}
  }
  echo '</select>' . "時\n";
  ?>
</td>
</tr>

    <script type="text/javascript">
    var now = new Date();
    var now_year = now.getFullYear();
    var now_month = now.getMonth() + 1;
    var now_date = now.getDate();
    
    function uruu(Year) {
        var uruu = 
            (Year % 400 == 0) ? true :
            (Year % 100 == 0) ? false :
            (Year % 4 == 0) ? true : false;
        return uruu;
    }
    
    function set_limit_year() {
        for (var y = now_year; y < now_year + 5; y++) {
            var select = document.formDate.limit_year;
            var option = select.appendChild(document.createElement('option'));
            option.value = y;
            option.text = y;
            option.selected = (y == <?php echo $limit_year?>) ? 'selected' : false;
        }
        set_limit_month();
    }
    set_limit_year();
  
    function set_limit_month() {
        var Year =
            document.formDate.limit_year.options[
            document.formDate.limit_year.selectedIndex
            ].value;
        var select = document.formDate.limit_month;
        while (select.options.length){
            select.removeChild(select.options[0]);
        }
        if (Year != 0) {
            for (var m = 1; m <= 12; m++){
                var option = select.appendChild(document.createElement('option'));
                option.value = m;
                option.text = m;
                option.selected =
                    (Year == now_year) ?
                    ((m == now_month) ? 'selected' : false ) :
                    ((m == <?php echo $limit_month?>) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
        set_limit_day();
    }

    function set_limit_day() {
        var Year =
            document.formDate.limit_year.options[
            document.formDate.limit_year.selectedIndex
            ].value;
        var Month =
            document.formDate.limit_month.options[
            document.formDate.limit_month.selectedIndex
            ].value;
        var days =
            [31,(uruu(Year)?29:28),31,30,31,30,31,31,30,31,30,31];
        var select = document.formDate.limit_day;
        while(select.options.length) {
            select.removeChild(select.options[0]);
        }
        
        if (Month != 0) {        
            for (var d = 1; d <= days[Month - 1]; d++) {
            var option = select.appendChild(document.createElement('option'));
            option.value = d;
            option.text = d;
            option.select =
                (Year == now_year && Month == now_month) ?
                ((d == now_date) ? 'selected' : false ) : 
                ((d == <?php echo $limit_day?>) ? 'selected' : false ); 
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
    }
    </script>

<tr>
<td class="title">
  <label for="category" style="margin-left:-7%">分類*：</label>
</td>
<td class="context">
  <?php
  echo '<select name="category">' . "\n";	      
     if($event_category == 1) {
     echo '<option value="グルメ/フェスティバル" selected>グルメ/フェスティバル</option>\n';
     } else {
     echo '<option value="グルメ/フェスティバル">グルメ/フェスティバル</option>\n';
     }
     if($event_category == 2) {
     echo '<option value="芸術/エンタメ" selected>芸術/エンタメ</option>\n';
     } else {
     echo '<option value="芸術/エンタメ">芸術/エンタメ</option>\n';
     }
     if($event_category == 3) {
     echo '<option value="交流/スポーツ" selected>交流/スポーツ</option>\n';
     } else {
     echo '<option value="交流/スポーツ">交流/スポーツ</option>\n';
     }
     if($event_category == 4) {
     echo '<option value="地域復興/福祉" selected>地域復興/福祉</option>\n';
     } else {
     echo '<option value="地域復興/福祉">地域復興/福祉</option>\n';
     }
     if($event_category == 5) {
     echo '<option value="就活/キャリア" selected>就活/キャリア</option>\n';
     } else {
     echo '<option value="就活/キャリア">就活/キャリア</option>\n';
     }
     echo '</select>' . "\n";
  ?>
</td>
</tr>

<tr>
<td class="title">
  <label for="event_detail" style="margin-left:-1%">イベント詳細：</label>
</td>
<td class="context">
  <textarea name="event_detail" rows="7" cols="40"><?php echo $event_detail ?></textarea>
</td>
</tr>

<tr>
<td class="title">
  <label for="event_image" style="margin-left:-1%">イベント画像：</label>
</td>
<td class="context">
  <input type="file" name="event_image" size="100" accept="image/*">
  <!--img src="event_detail_image.php?event_id=<?php echo $event_id ?>&image_id=a"-->
  <?php
  CallImg($event_id);
  ?>
</td>
</tr>
</table>  
  <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
  <input type="submit" id="move_conf" name="move_conf" value="確認画面へ進む">
  </form>
    
  <form id="loginForm" name="loginForm" action="" method="POST">
  <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
  <input type="submit" id="delete" name="delete" value="削除する">
  </form>

  </body>
</html>
