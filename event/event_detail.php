<!-- ログイン中の利用者の取得 -->
<?php
    $user_id = 1;
?>

<!-- イベント情報の取得 -->
<?php 
    $event_id = $_GET['event_id'];
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
    $sql4 = "SELECT UR.USER_ID, USER_LAST_NAME, USER_FIRST_NAME FROM UR,PEV WHERE UR.USER_ID = PEV.USER_ID AND PEV.EVENT_ID = $event_id ORDER BY PEV.USER_ID";
    
    //イベント主催者の取得
    $sql5 = "SELECT USER_LAST_NAME, USER_FIRST_NAME FROM UR, EV WHERE UR.USER_ID = EV.USER_ID AND EV.EVENT_ID = $event_id";
    
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
        $holding_place = $row['HOLDING_PLACE'];
        $deadline = $row['PARTICIPATION_DEADLINE'];
        $comment = $row['HOLDING_COMMENT'];
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
            $organizer_last_name = $row5['USER_LAST_NAME'];
            $organizer_first_name = $row5['USER_FIRST_NAME'];
    }
        
    //データベース切断
    mysql_close($link);

?>

<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<center>

<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>

<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->

<!-- 機能選択ボタン -->
<div id = "box">
  <a href="http://localhost/php/v0/event.php"><img src="img/ev_home.jpg" height="13%" width="16%"></a>
  <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="13%" width="16%"></a>
  <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="13%" width="16%"></a>
  <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="13%" width="16%"></a>
  <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="13%" width="16%"></a></div>
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
<img src="img/ev_all.jpg" height="10%" width="13%">
<img src="img/ev_gf.jpg" height="10%" width="13%">
<img src="img/ev_ge.jpg" height="10%" width="13%">
<img src="img/ev_ks.jpg" height="10%" width="13%">
<img src="img/ev_ft.jpg" height="10%" width="13%">
<img src="img/ev_sc.jpg" height="10%" width="13%">
</div>
<br><br>
</center>

<!-- イベント画像の表示 -->
<center><img src="event_detail_image.php?event_id=<?php echo $event_id ?>&image_id=a"></center>

<!-- イベントタイトルの表示 -->
<h1 align="center"><?php echo $event_title ?></h1>

<!-- イベント主催者名の表示 -->
<p align="center">主催者：<a href="http://localhost/kocote/mypage/personalpage.php"><?php echo $organizer_last_name." ".$organizer_first_name ?></a></p>

<!-- 主催者からのコメントの表示 -->
<p align="center">主催者からのコメント：<?php echo $comment ?></p>

<!-- イベント参加者のアイコン画像の表示 -->
<p align="center">参加者：</p>
<center>
<?php 
    for ($i = 0; $i < count($event_user_id); $i++) {
        echo '<a href=personalpage?user_id='.$event_user_id[$i].'><img src=event_detail_image.php?event_id='.$event_id.'&image_id='.$i.' width=50 height=50></a>';
    }  
?>
<br><br>

    <!-- イベント参加ボタンの表示 -->
    <?php
        echo '<center>';
        echo '<form>';
        if ($event_par == 0) {
            echo '<a onclick="participation(); return false;"><img src="ev_img/participation.jpg"></a>';
            $par_id = 0;
            $par_st = "このイベントに参加しますか？";
        } else if ($event_par == 1) {
            echo '<a onclick="participation(); return false;"><img src="ev_img/nonparticipation.jpg"></a>';
            $par_id = 1;
            $par_st = "このイベントの参加をやめますか？";
        }
    ?>
    
    <!-- イベントお気に入り登録ボタンの表示 -->
    <?php
        if ($event_fav == 0) {
            echo '<a onclick="favorite(); return false;"><img src="ev_img/favorite_add.jpg"></a>';
            $fav_id = 2;
            $fav_st = "このイベントをお気に入りに登録しますか？";
        } else if ($event_fav == 1) {
            echo '<a onclick="favorite(); return false;"><img src="ev_img/favorite_del.jpg"></a>';
            $fav_id = 3;
            $fav_st = "このイベントをお気に入りから削除しますか？";
        }
        echo '</form>';
        echo '</center>';
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
    
    <!-- イベントの開催日時の表示 -->
    <p align="center">開催日時：<?php echo substr($event_start, 0, 4)."年".substr($event_start, 5, 2)."月".substr($event_start, 8, 2)."日 ".substr($event_start, 11, 2)."時 〜 ".substr($event_finish, 11, 2)."時" ?></p>
    
    <!-- イベントの開催場所の表示 -->
    <p align="center">開催場所：<?php echo $holding_place ?></p>
    
    <!-- イベント分類の表示 -->
    <?php
    if ($category == 2) {
        echo '<p align="center">分類：グルメ / フェスティバル</p>';
    } else if ($category == 3) {
        echo '<p align="center">分類：芸術 / エンタメ</p>';
    } else if ($category == 4) {
        echo '<p align="center">分類：交流 / スポーツ</p>';
    } else if ($category == 5) {
        echo '<p align="center">分類：福祉 / 地域振興</p>';
    } else if ($category == 6) {
        echo '<p align="center">分類：就活 / キャリア</p>';
    }
    ?>
    
    <!-- イベント詳細の表示 -->
    <p align="center">イベント詳細：<?php echo $event_detail ?></p>

    
<div id="footerArea">
<ul>
<li><a href="https://www.evol-ni.com/company/">会社概要</a></li>
<li><a href="http://localhost/php/v0/contact.php">お問い合わせ</a></li>
<li><a href="https://secure.evol-ni.com/common/policy/">個人情報保護方針</a></li>
<li><a href="https://www.evol-ni.com/recruit/">採用情報</a></li>
<li><a href="https://www.evol-ni.com/sitemap/">サイトマップ</a></li>
</ul></div>

</body>
</html>


