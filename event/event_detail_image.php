<?php
    $event_detail_image = array();
    $event_icon_image = array();
    $event_id = $_GET['event_id'];
    $image_id = $_GET['image_id'];
    
    //データベースへの接続
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    
    //データベースの選択
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }

    //文字コード設定
    mysql_set_charset('utf8');
    
    //イベントIDに一致するイベント画像の取得
    $sql = "SELECT EVENT_IMAGE FROM EV WHERE EVENT_ID = $event_id";
    
    //イベント参加者のアイコン画像の取得
    $sql2 = "SELECT ICON_IMAGE FROM UA, PEV WHERE UA.USER_ID = PEV.USER_ID AND PEV.EVENT_ID = $event_id ORDER BY PEV.USER_ID";
    
    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }

    $result2 = mysql_query($sql2, $link);
    if (!$result2) {
        die('クエリが失敗しました。'.mysql_error());
    }
    
    header("Content-Type: image/jpeg");
    
    while ($row = mysql_fetch_array($result)) {
        array_push($event_detail_image, $row['EVENT_IMAGE']);
    }
    
    while ($row2 = mysql_fetch_array($result2)) {
        array_push($event_icon_image, $row2['ICON_IMAGE']);
    }
    
    //イベント画像を取得するとき
    if ($image_id == a) {
        echo $event_detail_image[0];
    //参加者のアイコン画像を取得するとき
    } else {
        echo $event_icon_image[$image_id];
    }
    
    mysql_close($link);
?>