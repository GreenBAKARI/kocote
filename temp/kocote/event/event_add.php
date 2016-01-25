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
?>


<html>
<head>
<meta charset="UTF-8">
<title>イベント作成</title>
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

<table class="data">
    <tr>
        <td></td>
        <td><p class="required">* 印は必須項目です。</p></td>
    </tr>
<tr>
<td class="title">
  <p>イベントタイトル*：</p>
</td>
<td class="context">
  <input type="text" id="event_title" name="event_title" required>
</td>
<tr>

<tr>
<td class="title">
  <p>主催者コメント：</p>
</td>
<td class="context">
  <textarea name="host_comment" rows="3" cols="40"></textarea>
</td>
</tr>

<tr>
<td class="title">
  <p>開催日*：</p>
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
        var select = document.formDate.event_year;
        var option = select.appendChild(document.createElement('option'));
        option.value = '';
        option.text = '';
        for (var y = now_year; y < now_year + 5; y++) {
            var select = document.formDate.event_year;
            var option = select.appendChild(document.createElement('option'));
            option.value = y;
            option.text = y;
            option.selected = (y == 0) ? 'selected' : false;
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
                    ((m == now_month) ? 'selected' : false ) :
                    ((m == 0) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = '';
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
                ((d == now_date) ? 'selected' : false ) : 
                ((d == 1) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = '';
            option.text = '';
        }
    }
    </script>

<tr>
<td class="title">
  <p>開催時間*：</p>
</td>
<td class="context">
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
</td>
</tr>

<tr>
<td class="title">
  <p>開催場所*：</p>
</td>
<td class="context">
  <input type="text" id="event_place" name="event_place" required>
</td>
</tr>

<tr>
<td class="title">
  <p>参加応募締め切り*：</p>
</td>
<td class="context">
  <select required="required" name="limit_year" onchange="set_limit_month()"></select> 年
  <select required="required" name="limit_month" onchange="set_limit_day()"></select> 月
  <select required="required" name="limit_day"></select> 日
   <?php
  echo '<select required="required" name="limit_hour">' . "\n";
  for ($i = -1; $i <= 23; $i++){
      if($i == -1){echo "<OPTION></OPTION>\n";}
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
        var select = document.formDate.limit_year;
        var option = select.appendChild(document.createElement('option'));
        option.value = '';
        option.text = '';
        for (var y = now_year; y < now_year + 5; y++) {
            var select = document.formDate.limit_year;
            var option = select.appendChild(document.createElement('option'));
            option.value = y;
            option.text = y;
            option.selected = (y == 0) ? 'selected' : false;
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
                    ((m == 0) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            //option.value = 0;
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
                ((d == 1) ? 'selected' : false ); 
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            //option.value = 0;
            option.text = '';
        }
    }
    </script>

 <tr>
 <td class="title">
  <p>分類*：</p>
</td>
<td class="context">
<select name="category" required>
  <option></option>
  <option value="グルメ/フェスティバル">グルメ/フェスティバル</option>
  <option value="芸術/エンタメ">芸術/エンタメ</option>
  <option value="交流/スポーツ">交流/スポーツ</option>
  <option value="地域復興/福祉">地域復興/福祉</option>
  <option value="就活/キャリア">就活/キャリア</option>
  </select>
  </td>
  </tr>
<tr>
<td class="title">
  <p>イベント詳細：</p>
</td>
<td class="context">
  <textarea name="event_detail" rows="7" cols="40"></textarea>
</td>
</tr>

<tr>
<td class="title">
  <p>イベント画像：</p>
</td>
<td class="context">
<input type="file" name="event_image" size="100" accept="image/*">
</td>
</tr>
 </table>

<br>

  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
  <input type="reset" id="delete" name="delete" value="クリアする">
  <input type="submit" id="move_conf" name="move_conf" value="確認画面へ進む">


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