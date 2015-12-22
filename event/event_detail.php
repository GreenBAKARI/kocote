<!-- ログイン中の利用者の取得 -->
<?php
    $user_id = 1;
?>

<!-- イベント情報の取得 -->
<?php 
    $event_id = $_GET['event_id'];
    
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
    
    $result = mysql_query($sql, $link);
    $result2 = mysql_query($sql2, $link);
    $result3 = mysql_query($sql3, $link);
    
    if (!$result or !$result2 or !$result3) {
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
        
    //データベース切断
    mysql_close($link);

?>


<html>
<head>
<title>イベント詳細</title>
<!-- <script type="text/javascript" src="./ev_js/event_join.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
</head>
<body>
    <meta charset="UTF-8">
    
    <!-- <img src="event_detail_image.php?image_id=2"> -->
    
    <!-- イベント参加ボタンの表示 -->
    <?php
        echo '<form>';
        if ($event_par == 0) {
            echo '<a onclick="participation(); return false;"><img src="ev_img/participation.jpg"></a>';
            $par_id = 0;
            $par_st = "このイベントに参加しますか？";
        } else if ($event_par == 1) {
            echo '<a onclick="participation(); return false;"><img src="ev_img/nonparticipation.jpg"></a>';
            $par_id = 1;
            $par_st = "このイベントの参加をやめますか？";
            //echo '<input type="image" src="./ev_img/nonparticipation.jpg" onClick="nonparticipation('', '');">';
        }
        echo '</form>'
    ?>
    
    <!-- イベントお気に入り登録ボタンの表示 -->
    <?php
        echo '<form>';
        if ($event_fav == 0) {
            echo '<a onclick="favorite(); return false;"><img src="ev_img/favorite_add.jpg"></a>';
            $fav_id = 2;
            $fav_st = "このイベントをお気に入りに登録しますか？";
        } else if ($event_fav == 1) {
            echo '<a onclick="favorite(); return false;"><img src="ev_img/favorite_del.jpg"></a>';
            $fav_id = 3;
            $fav_st = "このイベントをお気に入りから削除しますか？";
            //echo '<input type="image" src="./ev_img/nonparticipation.jpg" onClick="nonparticipation('', '');">';
        }
        echo '</form>'
    ?>
    
    <script type="text/javascript">
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
        
        function favorite() {
            if (window.confirm("<?php echo $fav_st ?>")) {
                $.ajax({
                    type: 'POST',
                    url: 'event_join.php',
                    data: {event_id: <?php echo $event_id ?>,
                           join_id: <?php echo $fav_id?>
                       },
                    success: function(data) {
                       location.href = "event_detail.php?event_id=<?php echo $event_id ?>"; 
                    }
                });
            }               
        }
    </script>
</body>
</html>

