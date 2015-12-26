<?php

$user_id = 1;
$event_id = $_POST["event_id"];
$join_id = $_POST["join_id"];

$link = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('greenbakari', $link);
mysql_set_charset('utf8');

if ($join_id == 0) {
    //$st = "このイベントに参加しますか？";
    $sql = "INSERT INTO PEV VALUES($event_id, $user_id)";
} else if ($join_id == 1) {
    //$st = "このイベントへの参加をやめますか？";
    $sql = "DELETE FROM PEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
} else if ($join_id == 2) {
    //$st = "このイベントをお気に入りに登録しますか？";
    $sql = "INSERT INTO FEV VALUES($event_id, $user_id)";
} else if ($join_id == 3) {
    //$st = "このイベントをお気に入りから削除しますか？";
    $sql = "DELETE FROM FEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
}

$result = mysql_query($sql, $link);

mysql_close($link);
?>