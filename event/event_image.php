<?php
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
    //htmlからの呼び出し方 <img src="event_image.php?id=1">
    //id=1の1の部分の数字を変えると出力が変わる
    
    switch ($_GET['image_id']) {
        case tmp1:
            echo $event_image[0];
            break;
        case tmp2:
            echo $event_image[1];
            break;
        case tmp3:
            echo $event_image[2];
            break;
        case tmp4:
            echo $event_image[3];
            break;
        default:
            break;
    }
    
    mysql_close($link);
?>