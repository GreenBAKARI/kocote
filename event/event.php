<?php
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

    //イベントの開始日時が現在時刻から近いイベント上位5件のイベントID、イベントタイトル、開始日時を取得
    $sql = "SELECT EVENT_ID, EVENT_TITLE, EVENT_START FROM EV WHERE EVENT_START > NOW() ORDER BY EVENT_START LIMIT 5";

    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }
    
    while ($row = mysql_fetch_array($result)) {
        $event_id[] = $row['EVENT_ID'];
        $event_title[] = $row['EVENT_TITLE'];
        $event_start[] = $row['EVENT_START'];
    }

    //$event_idの添字0から4にイベントIDが入っている
    //$event_titleの添字0から4にイベントタイトルが入っている
    //$event_startの添字0から4に開始日時が入っている
    //同じ添字の場合は同じイベントに対するもの
    
    mysql_close($link);
?>

<?php 
echo $event_id[0];
?>