<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    if (empty($user_id)) {
         header("LOCATION: ../login.php");
    }
?>

<?php
$event_id = $_POST["event_id"];
$join_id = $_POST["join_id"];

$link = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('greenbakari', $link);
mysql_set_charset('utf8');

switch ($join_id) {
    //このイベントに参加しますか？
    case 0:
        $sql = "INSERT INTO PEV VALUES($event_id, $user_id)";
        break;
    //このイベントへの参加をやめますか？
    case 1:
        $sql = "DELETE FROM PEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
        break;
    //このイベントをお気に入りに登録しますか？
    case 2:
        $sql = "INSERT INTO FEV VALUES($event_id, $user_id)";
        break;
    //このイベントをお気に入りから削除しますか？
    case 3:
        $sql = "DELETE FROM FEV WHERE EVENT_ID = $event_id AND USER_ID = $user_id";
        break;
    default:
        break;
}

$result = mysql_query($sql, $link);

mysql_close($link);
?>