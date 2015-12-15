<?php

function ev_image() {
    //配列の初期化
    $event_image = array();

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

    //テスト用SQL文
    //$sql = "SELECT EVENT_IMAGE FROM EV WHERE EVENT_ID = 1 OR EVENT_ID = 2";
    //AND EVENT_ID = 2 AND EVENT_ID = 3 AND EVENT_ID = 4";

    //参加者数の多いイベント上位4件のイベント画像の取得
    $sql = "SELECT a.EVENT_IMAGE, count(a.EVENT_ID) AS COUNT FROM EV a, PEV b WHERE a.EVENT_ID = b.EVENT_ID GROUP BY a.EVENT_ID ORDER BY COUNT DESC LIMIT 4";

    //クエリの実行
    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }

    header("Content-Type: image/jpeg");

    //抽出したデータを1件ずつ配列の最後に格納していく
    while ($row = mysql_fetch_array($result)) {
        array_push($event_image, $row['EVENT_IMAGE']);
    }
    //画像の表示
    //配列の添字0~3に参加者数の多いイベント画像順で格納されている
    echo $event_image[0];

    mysql_close($link);
}

function ev_all() {
    $event_id = array();
    $event_title = array();
    $event_start = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //$sql = "SELECT EVENT_ID FROM EV WHERE EVENT_ID = 1";
    $sql = "SELECT EVENT_ID, EVENT_TITLE, EVENT_START FROM EV WHERE EVENT_START > NOW() ORDER BY EVENT_START LIMIT 5";

    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }
    
    /*
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $event_id[] = $result['EVENT_ID'];
        array_push($event_id, $row['EVENT_ID']);
        array_push($event_title, $row['EVENT_TITLE']);
        array_push($event_start, $row['EVENT_START']);
    }
    */
    
    while ($row = mysql_fetch_array($result)) {
        $event_id[] = $row['EVENT_ID'];
        $event_title[] = $row['EVENT_TITLE'];
        $event_start[] = $row['EVENT_START'];
    }

    echo $event_id[0];
    echo $event_title[0];
    echo $event_start[0];

    mysql_close($link);
}

//ev_image();
//ev_all();
?>