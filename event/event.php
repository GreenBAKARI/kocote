<!-- セッションの開始 -->
<?php
    session_start();
?>

<!-- イベント情報の取得 -->
<?php
    $event_id = array();
    $event_title = array();
    $event_start = array();
    $event_finish = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //イベントの開始日時が現在時刻から近いイベント上位5件のイベントID、イベントタイトル、開始日時を取得
    $sql = "SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_FINISH FROM EV WHERE EVENT_START > NOW() ORDER BY EVENT_START ASC LIMIT 5";

    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }
    
    while ($row = mysql_fetch_array($result)) {
        $event_id[] = $row['EVENT_ID'];
        $event_title[] = $row['EVENT_TITLE'];
        $event_start[] = $row['EVENT_START'];
        $event_finish[] = $row['EVENT_FINISH'];
    }

    //$event_idの添字0から4にイベントIDが入っている
    //$event_titleの添字0から4にイベントタイトルが入っている
    //$event_startの添字0から4に開始日時が入っている
    //同じ添字の場合は同じイベントに対するもの
    
    //データベース切断
    mysql_close($link);
?>

<!-- カレンダーの生成 -->
<?php
$start_year = 2015;
$end_year = 2016;
$holidays = array(
    "20151223" => "天皇誕生日",
    "20160101" => "元日",
    "20160111" => "成人の日",
    "20160211" => "建国記念の日",
    "20160320" => "春分の日",
    "20160321" => "振替休日",
    "20160429" => "昭和の日",
    "20160503" => "憲法記念日",
    "20160504" => "みどりの日",
    "20160505" => "こどもの日",
    "20160718" => "海の日",
    "20160811" => "山の日",
    "20160919" => "敬老の日",
    "20160922" => "秋分の日",
    "20161010" => "体育の日",
    "20161103" => "文化の日",
    "20161123" => "勤労感謝の日",
    "20161223" => "天皇誕生日",
);

//月あたりの表示日数
define("display", 42);
 
function ev_calendar() {
    global $holidays;
    global $start_year;
    global $end_year;
 
    if ($_SESSION["year"] == "") {
        $_SESSION["year"] = date(Y);
    }
    if ($_SESSION["month"] == "") {
        $_SESSION["month"] = date(n);
    }
    
    //今日の日付の取得
    $today = date(Ynj);
    $year = date(Y);
    $month = date(n);
 
    //今月の初めの曜日
    //date(N)は1が月曜日、7が日曜日
    $month_start_day = date("N", mktime(0, 0, 0, $month, 1, $year));
    //その月の終わりの日
    $month_end = date(t);
 
    //先月の処理
    if ($_POST['sengetu']) {
        if ($_SESSION["month"] == 1) {
            //1月の場合は、年を1減らして12月にする
            $_SESSION["year"] = $_SESSION["year"] - 1;
            $_SESSION["month"] = 12; 
        } else { 
            //1月以外の場合は、月を1減らす
            $_SESSION["month"] = $_SESSION["month"] - 1;
        }
        
        //データのない年は表示しない
        if ($_SESSION["year"] <= ($start_year - 1)) {  
            $_SESSION["year"] = $_SESSION["year"] + 1;
            $_SESSION["month"] = 1;
        }
        $month_start_day = date("N", mktime(0, 0, 0, $_SESSION["month"], 1, $_SESSION["year"]));
        $month_end = date("t", mktime(0, 0, 0, $_SESSION["month"], 1, $_SESSION["year"]));
    }
 
    //来月の処理
    if ($_POST['raigetu']) {
        //12月の場合は、1月にして年を1増やす
        if ($_SESSION["month"] == 12) {
            $_SESSION["year"] = $_SESSION["year"] + 1;
            $_SESSION["month"] = 1; 
        //12月以外の場合は、月を1増やす
        } else { 
            $_SESSION["month"] = $_SESSION["month"] + 1;
        }
        
        //データのない月は表示しない
        if ($_SESSION["year"] >= ($end_year + 1)) { 
            $_SESSION["year"] = $_SESSION["year"] - 1;
            $_SESSION["month"] = 12;
        }
        $month_start_day = date("N", mktime(0, 0, 0, $_SESSION["month"], 1, $_SESSION["year"]));
        $month_end = date("t", mktime(0, 0, 0, $_SESSION["month"], 1, $_SESSION["year"]));
    }
 
//フォーム部分
echo<<<EOT
    <p class="entry-title" align="center">日付から探す</p>
    <div class="calendar_box">
    <div style="text-align:center;">
    <div style="margin-left:auto; margin-right:auto;">
    <form action="" method="post">
    <input type="submit" name="sengetu" value="<<">
EOT;

    echo ' ';
    echo ' ';
    echo ' ';
    echo $_SESSION['year']. 年.$_SESSION['month']. 月;
    echo ' ';
    echo ' ';
    echo ' ';


echo<<<EOT
    <input type="submit" name="raigetu" value=">>">
    </form>
EOT;

echo<<<EOT
</div>
</div>
<table class="calendar">
<tr>
<th class="dayweek y_red">日</th>
<th class="dayweek y_black">月</th>
<th class="dayweek y_black">火</th>
<th class="dayweek y_black">水</th>
<th class="dayweek y_black">木</th>
<th class="dayweek y_black">金</th>
<th class="dayweek y_blue">土</th>
</tr>
<tr>
EOT;
 
    $y = $_SESSION["year"];
    $m = $_SESSION["month"];
    $lastmonth = 0;
    $thismonth = 0;
    $nextmonth = 0;
    $d = 1;
    $byreturn = 0;
    
    //日曜始まりでなければ空セルを追加
    if ($month_start_day != 7) {
        //前月の年、月を取得
        $zy = $y;
        $zm = $m - 1;
        if ($zm == 0) {
            $zm = 12;
            $zy = $zy - 1;
        }
        $zd = date("j", mktime(0, 0, 0, $m, 0, $y)) - $month_start_day + 1;
        for ($i = 1; $i <= $month_start_day; $i++) {
            echo '<td class="datablock bkgd_gray"><div class="txt_gray">'.$zd.'&nbsp;'.'</div>';
            echo '</td>';
            $zd++;
            $lastmonth++;
            $byreturn++;
        }
    }
    
    while ($d <= $month_end) {
        //データベースに接続
        $link = mysql_connect('localhost', 'root', 'root');
        $db_selected = mysql_select_db('greenbakari', $link);
        mysql_set_charset('utf8');
        
        //日ごとに開催イベント数を取得
        $sql_evcount = "SELECT COUNT(*) AS COUNT FROM EV WHERE EVENT_START > NOW() AND EVENT_START BETWEEN '$y-$m-$d 00:00:00' AND '$y-$m-$d 23:59:59'";
        $result_evcount = mysql_query($sql_evcount, $link);
        while ($row_evcount = mysql_fetch_array($result_evcount)) {
            $event_count = $row_evcount['COUNT'];
        }
        
        //日曜日または祝日の場合
        if (($byreturn == 0) or ($holidays[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
            $td = "bkgd_red";
            $td_txt = "txt_black";
        //土曜日の場合
        } else if ($byreturn == 6) {
            $td = "bkgd_blue";
            $td_txt = "txt_black";
        //平日の場合
        } else {
            $td = "bkgd_white";
            $td_txt = "txt_black";
        }
        //本日を示す場合
        if ($today == $_SESSION["year"].$_SESSION["month"].$d) {
            $td = "bkgd_today";
        }
        echo '<td class="date_block '.$td.'"><div class="'.$td_txt.'">'.'<a href=../search/search_event.php?month='.$m.'&day='.$d.'>',$d.'</a>'.'</div>'.'</br>'.'<div class="count">'.'('.$event_count.')'.'</div>';
        echo '</td>';
        $thismonth++;
        $d++;
        $byreturn++;
        //土曜日で折り返し
        if ($byreturn == 7) { 
            echo "</tr><tr>\n";
            //折り返しカウンタのリセット
            $byreturn = 0;
        }
        
        //データベース切断
        mysql_close($link);
    }
    
    $zk_days = $lastmonth + $thismonth;
    $e = display - $zk_days;
    //次月の年、月の取得
    $yy = $y;
    $ym = $m + 1;
    if ($ym == 13) {
        $ym = 1;
        $yy = $yy + 1;
    }
    $i = 0;
    $yd = date("j", mktime(0,0,0,$m,$d,$y)) + $i;
    while ($i < $e) {
        $nextmonth_ymd = date("Ymd", mktime(0, 0, 0, $ym, $yd, $yy));
        echo '<td class="datablock bkgd_gray"><div class="txt_gray">'.$yd; 
        echo '</td>';
        $yd++;
        $nextmonth++;
        $byreturn++;
        $i++;
        if ($byreturn == 7) {
            //土曜日で折り返し
            echo "</tr><tr>";
            //折り返しカウンタのリセット
            $byreturn = 0;
        }
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
?>

<!-- HTML本文 -->
<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/ev_calendar.css" type="text/css">
    <link rel="stylesheet" href="../css/ev_style.css" type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>

<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->

  <br><br><br><br><br><br><br>  
<!-- 機能選択ボタン -->
<div id="box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%" width="16%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%" width="16%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%" width="16%"></a>
  <a href="../dm/dm.php"><img src="../img/dm_home.jpg" height="13%" width="16%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%" width="16%"></a></div>
  <br>
</center>  

<!-- イベント作成ボタンの表示 -->
  <a href="event_add.php">
  <img src="../img/ev_mk.jpg" height="10%" width="13%" style="margin-left:82%"></a>
  
  <br><br><br>

<center>
<div id="stage">
    <input type="radio" id="back1" name="gal">
    <input type="radio" id="back2" name="gal">
    <input type="radio" id="back3" name="gal">
    <input type="radio" id="back4" name="gal">
    <input type="radio" id="back5" name="gal">
    <input type="radio" id="next1" name="gal">
    <input type="radio" id="next2" name="gal">
    <input type="radio" id="next3" name="gal">
    <input type="radio" id="next4" name="gal">
    <input type="radio" id="next5" name="gal">
   
  <!-- 各画像はSQLで人気のイベント画像を抽出-->
  <div id="photos">
      <div id="photo0" class="pic"><img src="event_image.php?image_id=tmp5" width="400%">
      </div>
      <div id="photo1" class="pic"><img src="event_image.php?image_id=tmp1" width="400%">
	    <label for="back1"><div id="left1" class="b_left"><span>＜</span></div></label>
	    <label for="next1"><div id="right1" class="b_right"><span>＞</span></div></label>
      </div>
      <div id="photo2" class="pic"><img src="event_image.php?image_id=tmp2" width="400%">
	    <label for="back2"><div id="left2" class="b_left"><span>＜</span></div></label>
    	<label for="next2"><div id="right2" class="b_right"><span>＞</span></div></label>
      </div>
      <div id="photo3" class="pic"><img src="event_image.php?image_id=tmp3" width="400%">
	    <label for="back3"><div id="left3" class="b_left"><span>＜</span></div></label>
    	<label for="next3"><div id="right3" class="b_right"><span>＞</span></div></label>
      </div>
      <div id="photo4" class="pic"><img src="event_image.php?image_id=tmp4" width="400%">
    	<label for="back4"><div id="left4" class="b_left"><span>＜</span></div></label>
    	<label for="next4"><div id="right4" class="b_right"><span>＞</span></div></label>
      </div>
      <div id="photo5" class="pic"><img src="event_image.php?image_id=tmp5" width="400%">
    	<label for="back5"><div id="left5" class="b_left"><span>＜</span></div></label>
    	<label for="next5"><div id="right5" class="b_right"><span>＞</span></div></label>
      </div>
      <div id="photo6" class="pic"><img src="event_image.php?image_id=tmp1" width="400%">
      </div>
    </div>
   <div style="padding:25%;"></div>
</div>
</form>

<br>

<!-- カテゴリ画像の表示 -->
<p>カテゴリから探す</p>
<div id = "box">
    <a href="../search/search_event.php?category=0"><img src="../img/ev_all.jpg" height="10%" width="13%"></a>
    <a href="../search/search_event.php?category=1"><img src="../img/ev_gf.jpg" height="10%" width="13%"></a>
    <a href="../search/search_event.php?category=2"><img src="../img/ev_ge.jpg" height="10%" width="13%"></a>
    <a href="../search/search_event.php?category=3"><img src="../img/ev_ks.jpg" height="10%" width="13%"></a>
    <a href="../search/search_event.php?category=4"><img src="../img/ev_ft.jpg" height="10%" width="13%"></a>
    <a href="../search/search_event.php?category=5"><img src="../img/ev_sc.jpg" height="10%" width="13%"></a>
</div>
<br><br>
</center>

<br><br><br>

<p class="event-size">最近追加されたイベント</p>

<div id="blocka">
<!-- イベント情報（イベントタイトル、開催日時）の表示 -->
<?php
$count = count($event_id);
//データベースに登録されているイベント情報が0件であった場合
if ($count == 0) {
    echo '<p>現在登録されているイベント情報はありません。<p>';
} else {
    //イベント情報が5件以上登録されている場合は5件分表示する
    if ($count > 5) { 
        $count = 5;
    }
    for ($i = 0; $i < $count; $i++) {
        echo '<img class="event-image" src="event_image.php?event_id='.$event_id[$i].'"width="20%">';
        echo '<a class="event-title" href="event_detail.php?event_id='.$event_id[$i].'">'.$event_title[$i].'</a>';
        echo '<br>';
        //年の表示
        echo substr($event_start[$i], 0, 4).'年';
        
        //月の表示（先頭の0は表示されない）
        if (substr($event_start[$i], 5, 1) == 0) {
            echo substr($event_start[$i], 6, 1).'月';
        } else {
            echo substr($event_start[$i], 5, 2).'月';
        }
        
        //日の表示（先頭の0は表示されない）
        if (substr($event_start[$i], 8, 1) == 0) {
            echo substr($event_start[$i], 9, 1).'日 ';
        } else {
            echo substr($event_start[$i], 8, 2).'日 ';
        }
        
        //イベント開始時刻の表示（先頭の0は表示されない）
        if (substr($event_start[$i], 11, 1) == 0) {
            echo substr($event_start[$i], 12, 1)."時 〜 ";
        } else {
            echo substr($event_start[$i], 11, 2)."時 〜 ";
        }
            
        //イベント終了時刻の表示（先頭の0は表示されない）
        if (substr($event_finish[$i], 11, 1) == 0) {
            echo substr($event_finish[$i], 12, 1)."時";
        } else {
            echo substr($event_finish[$i], 11, 2)."時";
        }
            
        echo '<br><br><br><br><br>';
    }
}
?>
</div>

<div id="blockb">
<!-- カレンダーの表示> -->
<?php ev_calendar(); ?>
</div>

<div id="clear"></div>

<div id="footerArea">
<ul>
<li><a href="https://www.evol-ni.com/company/">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="https://secure.evol-ni.com/common/policy/">個人情報保護方針</a></li>
<li><a href="https://www.evol-ni.com/recruit/">採用情報</a></li>
<li><a href="https://www.evol-ni.com/sitemap/">サイトマップ</a></li>
</ul>
</div>


</body>

</html>
