<?php
    //イベントIDの取得
    //引数が空のときは自動的にevent.phpに遷移
    $event_id = $_GET['event_id'];
    if (empty($event_id)) {
        header("LOCATION: ../event/event.php");
    }
    
    //ログイン中の利用者の取得
    $user_id = 1;
    
    //イベント情報の取得
    $event_user_id = array();
    $user_last_name = array();
    $user_first_name = array();
    
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //イベント情報の取得
    $sql = "SELECT EVENT_TITLE, CATEGORY, EVENT_START, EVENT_FINISH, HOLDING_PLACE, PARTICIPATION_DEADLINE, HOLDING_COMMENT, EVENT_DETAIL, UPDATE_DATE FROM EV WHERE EVENT_ID = $event_id";
    
    //イベントに参加しているか 返り値が 0:参加していない 1:参加している
    $sql2 = "SELECT COUNT(*) AS COUNT FROM PEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
    
    //イベントをお気に入りに登録しているか 返り値が 0:登録していない 1:登録している
    $sql3 = "SELECT COUNT(*) AS COUNT FROM FEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
    
    //イベント参加者の名前を取得
    $sql4 = "SELECT UR.USER_ID, USER_LAST_NAME, USER_FIRST_NAME FROM UR, PEV WHERE UR.USER_ID = PEV.USER_ID AND PEV.EVENT_ID = $event_id ORDER BY PEV.USER_ID";
    
    //イベント主催者の取得
    $sql5 = "SELECT UR.USER_ID, UR.USER_LAST_NAME, UR.USER_FIRST_NAME FROM UR, EV WHERE UR.USER_ID = EV.USER_ID AND EV.EVENT_ID = $event_id";
    
    $result = mysql_query($sql, $link);
    $result2 = mysql_query($sql2, $link);
    $result3 = mysql_query($sql3, $link);
    $result4 = mysql_query($sql4, $link);
    $result5 = mysql_query($sql5, $link);
    
    
    if (!$result or !$result2 or !$result3 or !$result4 or !$result5) {
        die('クエリが失敗しました。'.mysql_error());
    }
    
    while ($row = mysql_fetch_array($result)) {
        $event_title = $row['EVENT_TITLE'];
        $category = $row['CATEGORY'];
        $event_start = $row['EVENT_START'];
        $event_finish = $row['EVENT_FINISH'];
        $event_place = $row['HOLDING_PLACE'];
        $deadline = $row['PARTICIPATION_DEADLINE'];
        $host_comment = $row['HOLDING_COMMENT'];
        $event_detail = $row['EVENT_DETAIL'];
        $update = $row['UPDATE_DATE'];
    }
    
    while ($row2 = mysql_fetch_array($result2)) {
            $event_par = $row2['COUNT'];
    }
    
    while ($row3 = mysql_fetch_array($result3)) {
            $event_fav = $row3['COUNT'];
    }
    
    while ($row4 = mysql_fetch_array($result4)) {
            $event_user_id[] = $row4['USER_ID'];
            $user_last_name[] = $row4['USER_LAST_NAME'];
            $user_first_name[] = $row4['USER_FIRST_NAME'];
    }
    
    while ($row5 = mysql_fetch_array($result5)) {
            $organizer_user_id = $row5['USER_ID'];
            $organizer_last_name = $row5['USER_LAST_NAME'];
            $organizer_first_name = $row5['USER_FIRST_NAME'];
    }
    
    //イベント詳細情報を文字ごとに改行
    $host_comment = mb_wordwrap($host_comment, 25, "<br>\n", true);
    $event_detail = mb_wordwrap($event_detail, 25, "<br>\n", true);
    //$event_detail = nl2br($event_detail);
        
    //データベース切断
    mysql_close($link);

?>

<!-- マルチバイト対応のwordwrap -->
<?php
function mb_wordwrap($string, $width=75, $break="\n", $cut = false) {
    if (!$cut) {
        $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.',}\b#U';
    } else {
        $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.'}#';
    }
    $string_length = mb_strlen($string,'UTF-8');
    $cut_length = ceil($string_length / $width);
    $i = 1;
    $return = '';
    while ($i < $cut_length) {
        preg_match($regexp, $string, $matches);
        $new_string = $matches[0];
        $return .= $new_string.$break;
        $string = substr($string, strlen($new_string));
        $i++;
    }
    return $return.$string;
}
?>

<!-- 現在時刻の取得 -->
<?php
    $dt = new DateTime();
    $current_time = $dt->format('Y-m-d H:i:s');
?>

<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<link rel="stylesheet" href="../css/ev_style.css" type="text/css">
</head>
<center>

<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>

<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->

<!-- 機能選択ボタン -->
<div id = "box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%" width="16%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%" width="16%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%" width="16%"></a>
  <a href="../dm/dm.php"><img src="../img/dm_home.jpg" height="13%" width="16%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%" width="16%"></a></div>
  <br>

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
</div>
</form>

<!-- イベント分類ボタンの表示 -->
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

<!-- イベント画像の表示 -->
<center><img src="event_detail_image.php?event_id=<?php echo $event_id ?>&image_id=a"></center>

<!-- イベントタイトルの表示 -->
<h1 align="center"><?php echo $event_title ?></h1>


<table class="event-table">
<!-- イベント主催者名の表示 -->
<tr>
    <td class="title"><p>主催者：</p></td>
    <td class="content"><p><a href="../mypage/personalpage.php?user_id=<?php echo $organizer_user_id ?>"><?php echo $organizer_last_name." ".$organizer_first_name ?></a></p></td>
</tr>


<!-- 主催者からのコメントの表示 -->
<tr>
    <td class="title"><p>主催者からのコメント：</p></td>
    <td class="content"><p><?php echo $host_comment ?></p></td>
</tr>

<!-- イベントの開催日時の表示 -->
<tr>
    <td class="title"><p>開催日時：</p></td>
    <td class="content"><p>
        <?php 
            //イベント開始年の表示
            echo substr($event_start, 0, 4).'年';
        
            //イベント開始月の表示（先頭の0は表示されない）
            if (substr($event_start, 5, 1) == 0) {
                echo substr($event_start, 6, 1).'月';
            } else {
                echo substr($event_start, 5, 2).'月';
            }
        
            //イベント開始日の表示（先頭の0は表示されない）
            if (substr($event_start, 8, 1) == 0) {
                echo substr($event_start, 9, 1).'日 ';
            } else {
                echo substr($event_start, 8, 2).'日 ';
            }
        
            //イベント開始時刻の表示（先頭の0は表示されない）
            if (substr($event_start, 11, 1) == 0) {
                echo substr($event_start, 12, 1)."時 〜 ";
            } else {
                echo substr($event_start, 11, 2)."時 〜 ";
            }
            
            //イベント終了時刻の表示（先頭の0は表示されない）
            if (substr($event_finish, 11, 1) == 0) {
                echo substr($event_finish, 12, 1)."時";
            } else {
                echo substr($event_finish, 11, 2)."時";
            }
        ?>
    </p></td>
<tr>
        
<!-- イベントの開催場所の表示 -->
<tr>
    <td class="title"><p>開催場所：</p></td>
    <td class="content"><p><?php echo $event_place ?></p></td>
</tr>
    
<!-- イベント分類の表示 -->
<tr>
    <?php
    switch($category) {
        case 2:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>グルメ / フェスティバル</p>';
            echo '</td>';
            break;
        case 3:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>芸術 / エンタメ</p>';
            echo '</td>';
            break;
        case 4:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>交流 / スポーツ</p>';
            echo '</td>';
            break;
        case 5:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>福祉 / 地域振興</p>';
            echo '</td>';
            break;
        case 6:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>就活 / キャリア</p>';
            echo '</td>';
            break;
        default:
            echo '<td class="title">';
            echo '<p>分類：</p>';
            echo '</td>';
            echo '<td class="content">';
            echo '<p>分類なし</p>';
            echo '</td>';
            break;
    }
    ?>
</tr>
    
<!-- イベント詳細の表示 -->
<tr>
    <td class="title"><p>イベント詳細：</p>
    <td class="content"><p><?php echo $event_detail ?></p>
</tr>
    
</table>

<br>

<!-- 区切り線 -->
<hr>

<!-- イベント参加者のアイコン画像の表示 -->
<div id="reg">
    
<p align="center">イベント参加者</p>

<center>
<?php 
    if (count($event_user_id) == 0) {
        echo '<p align="center">現在このイベントの参加者はいません。</p>';
    } else {
        for ($i = 0; $i < count($event_user_id); $i++) {
            //ログイン中の利用者のアイコン画像を選択した場合はmypage.phpへのリンクを生成
            if ($event_user_id[$i] == $user_id) {
                echo '<a href=../mypage/mypage.php><img class="user-image" src=event_detail_image.php?event_id='.$event_id.'&image_id='.$i.' width=50 height=50></a>';
            //それ以外はpersonalpage.phpへのリンクを生成 
            } else {
                echo '<a href=../mypage/personalpage.php?user_id='.$event_user_id[$i].'><img class="user-image" src=event_detail_image.php?event_id='.$event_id.'&image_id='.$i.' width=50 height=50></a>';
            }
        }  
    }
?>
<br><br>

    <!-- イベント参加ボタンの表示 -->
    <?php
        echo '<center>';
        echo '<form>';
        //参加締切を過ぎている場合
        if (strtotime($deadline) < strtotime($current_time)) {
            echo '<p align="center">※このイベントは参加登録の締切を過ぎています。</p>';
        } else if ($event_par == 0) {
            echo '<a onclick="participation(); return false;"><img class="button" src="../img/participation.jpg"></a>';
            $par_id = 0;
            $par_st = "このイベントに参加しますか？";
        } else if ($event_par == 1) {
            echo '<a onclick="participation(); return false;"><img class="button" src="../img/nonparticipation.jpg"></a>';
            $par_id = 1;
            $par_st = "このイベントの参加をやめますか？";
        }
    ?>
    
    <!-- イベントお気に入り登録ボタンの表示 -->
    <!-- 参加締切が過ぎていない場合のみ表示 -->
    <?php
        if (strtotime($deadline) >= strtotime($current_time)) {
            if ($event_fav == 0) {
                echo '<a onclick="favorite(); return false;"><img class="button" src="../img/favorite_add.jpg"></a>';
                $fav_id = 2;
                $fav_st = "このイベントをお気に入りに登録しますか？";
            } else if ($event_fav == 1) {
                echo '<a onclick="favorite(); return false;"><img class="button" src="../img/favorite_del.jpg"></a>';
                $fav_id = 3;
                $fav_st = "このイベントをお気に入りから削除しますか？";
            }
            echo '</form>';
            echo '</center>';
        }
    ?>
    
    
    <script type="text/javascript">
        //「イベント参加ボタン」か「イベント参加取り消しボタン」が押されたときに呼び出される
        //event_join.phpを呼び出し、データベースに接続し、データベースを更新し、イベント詳細画面に遷移する
        function participation() {
            if (window.confirm("<?php echo $par_st ?>")) {
                $.ajax({
                    type: 'POST',
                    url: 'event_join.php',
                    data: {event_id: <?php echo $event_id ?>,
                           join_id: <?php echo $par_id?>
                       },
                    success: function() {
                        location.href = "event_detail.php?event_id=<?php echo $event_id ?>";
                    }
                });
            }               
        }
        
        //「イベントお気に入り登録ボタン」か「イベントお気に入り登録取り消し」が押されたときに呼び出される
        //event_join.phpを呼び出し、データベースに接続し、データベースを更新し、イベント詳細画面に遷移する
        function favorite() {
            if (window.confirm("<?php echo $fav_st ?>")) {
                $.ajax({
                    type: 'POST',
                    url: 'event_join.php',
                    data: {event_id: <?php echo $event_id ?>,
                           join_id: <?php echo $fav_id?>
                       },
                    success: function() {
                       location.href = "event_detail.php?event_id=<?php echo $event_id ?>"; 
                    }
                });
            }               
        }
    </script>
    
</div>

    

    
<div id="footerArea">
<ul>
<li><a href="https://www.evol-ni.com/company/">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="https://secure.evol-ni.com/common/policy/">個人情報保護方針</a></li>
<li><a href="https://www.evol-ni.com/recruit/">採用情報</a></li>
<li><a href="https://www.evol-ni.com/sitemap/">サイトマップ</a></li>
</ul></div>

</body>
</html>


