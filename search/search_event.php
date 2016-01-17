<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    if (empty($user_id)) {
        header("LOCATION: ../login.php");
    }
?>

<html>
<head>
<meta charset = "utf-8">
<title>イベント検索</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/se_style.css"　type="text/css">
<body topmargin = "100" bottommargin = "100">

<div id = "headerArea"></div>
<div id = "footerArea"></div>
<br>

<div id = "box">
<a href = "../event/event.php">
<img src = "../img/ev_home.jpg" height = "13%" width = "16%"></a>
<a href = "../bulletin/bulletin.php">
<img src = "../img/bb_home.jpg" height = "13%" width = "16%"></a>
<a href = "../search/search.php">
<img src = "../img/se_home.jpg" height = "13%" width = "16%"></a>
<a href = "../dm/dm.php">
<img src = "../img/dm_home.jpg" height = "13%" width = "16%"></a>
<a href = "../mypage/mypage.php">
<img src = "../img/mp_home.jpg" height = "13%" width = "16%"></a>
</div><br><br><br>

<hr class="top">
<hr class="bottom">
<br>

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

<?php
$url = 'localhost';  //ローカル環境へのURL
$user = 'root';    //MySQLサーバの利用者ID
$pass = 'root';      //MySQLのパスワード
$db = 'greenbakari'; //MySQLのデータベース名

//mysql_close() - MySQLサーバへの接続をオープンにする
$link = mysql_connect($url, $user, $pass);

//mysql_error() - 直近に実行されたMySQL操作のエラーメッセージを返す
if (!$link) {
    die('接続失敗です。'.mysql_error());
}
//print('<p>接続に成功しました。</p>');

//mysql_select_db() - MySQLサーバへの接続後に利用したいデータベースを選択する
$db_select = mysql_select_db($db, $link);

if (!$db_select) {
    die('データベース選択失敗です。'.mysql_error());
}
//print('<p>データベースを選択しました。</p>');

//mysql_set_charset() - MySQLデータベースで使用する文字コードを指定する
mysql_set_charset('utf8');

//_POST[] - HTTP POSTメソッドからイベント検索に渡された変数の連想配列を定義する
$keyword = $_POST['ev_keyword'];   //キーワード
$category = $_POST['ev_category']; //分類
$year = $_POST['select_year'];
$month = $_POST['select_month'];   //開始月
$day = $_POST['select_date'];      //開始日

//イベント詳細ページから検索がかかったときは、GETで受け取る
if (isset($_GET['year']) && isset($_GET['month']) && isset($_GET['day'])) {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $day = $_GET['day'];
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

//月が1桁の場合は、先頭に0を追加
//月が空の場合は、00を代入
if (mb_strlen($month) == 1) {
    $month = '0'.$month;
} else if (mb_strlen($month) == 0) {
    $month = '00';
}

//日が1桁の場合は、先頭に0を追加
//日が空の場合は、00を代入
if (mb_strlen($day) == 1) {
    $day = '0'.$day;
} else if (mb_strlen($day) == 0) {
    $day = '00';
}

//日付のみが選択されている場合
if ($year != '0' && $month != '00' && $day != '00' && !$keyword && !$category) {
    $result = mysql_query("SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_DETAIL FROM EV 
        WHERE EVENT_START > NOW() AND MID(EVENT_START, 1, 4) = $year AND MID(EVENT_START, 6, 2) = $month AND MID(EVENT_START, 9, 2) = $day ORDER BY EVENT_START");
//日付とキーワードまたは分類が選択されている場合
} else if ($year != '0' && $month != '00' && $day != '00' && ($keyword || $category)) {
    $result = mysql_query("SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_DETAIL FROM EV 
        WHERE EVENT_START > NOW() AND MID(EVENT_START, 1, 4) = $year AND MID(EVENT_START, 6, 2) = $month AND MID(EVENT_START, 9, 2) = $day "
            . "AND (CATEGORY = $category OR EVENT_TITLE LIKE '%$keyword%')"
            . " ORDER BY EVENT_START ");
//分類で全てが選択された場合
} else if ($category == 0) {
    $result = mysql_query("SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_DETAIL FROM EV WHERE EVENT_START > NOW()");
//キーワード・分類が入力されていない場合、またはキーワードが入力されておらず、分類が入力されている場合の検索条件の生成
} else if (!$keyword && !$category || !$keyword && $category) {
    //mysql_query() - MySQLデータベースへクエリを発行する
    $result = mysql_query("SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_DETAIL FROM EV 
        WHERE EVENT_START > NOW() AND CATEGORY = $category ORDER BY EVENT_START");
//キーワード・分類が入力されている場合、またはキーワードが入力されており、分類が入力されていない場合の検索条件の生成
} else {
    $result = mysql_query("SELECT EVENT_ID, EVENT_TITLE, EVENT_START, EVENT_DETAIL FROM EV 
        WHERE EVENT_START > NOW() AND EVENT_TITLE LIKE '%$keyword%' OR CATEGORY = $category ORDER BY EVENT_START");
}

if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}
//print('<p>クエリが成功しました。</p>');

//抽出結果に表示番号を割り振る
$display_num = 1;

//mysql_num_rows() - クエリの実行結果から行の数を取得する
$rows = mysql_num_rows($result);

if ($rows) {
    //mysql_fetch_array() - クエリの実行結果を連想配列として取得する
    while ($row = mysql_fetch_array($result)) {
        $send = $row['EVENT_ID'];
        $date = $row['EVENT_START'];
        //イベント開始月の表示（先頭の0は表示されない）
        if (substr($date, 5, 1) == 0) {
            $date_month = substr($date, 6, 1);
        } else {
            $date_month = substr($date, 5, 2);
        }
        //イベント開始日の表示（先頭の0は表示されない）
        if (substr($date, 8, 1) == 0) {
            $date_day = substr($date, 9, 1);
        } else {
            $date_day = substr($date, 8, 2);
        }
        $temp = $temp."<tr>";
        $temp = $temp."<td class=e_num_main>".$display_num++."</td>";
        $temp = $temp."<td class=e_title_main><a href=../event/event_detail.php?event_id=$send>".$row['EVENT_TITLE']."</a></td>";
        $temp = $temp."<td class=e_date_main>".substr($date, 0, 4)."年".$date_month."月".$date_day."日"."</td>";
        $temp = $temp."<td class=e_detail_main>".mb_wordwrap($row['EVENT_DETAIL'], 30, "<br>\n", true)."</td>";
        $temp = $temp."</tr>";
    }
    $msg = "<p><h3>検索結果： 該当するイベントが".$rows."件表示されました。</h3></p><br>";
} else {
    $msg = "<p><h3>検索結果： 該当するイベントは存在しません。</h3></p>";
}

//mysql_close() - MySQLサーバへの接続をクローズにする
$close_flag = mysql_close($link);

if (!$close_flag) {
    die('切断に失敗しました。'.mysql_error());
}
//print('<p>切断に成功しました。</p>');
?>



<?= $msg ?>
<table class="result">
<tr class="title">
<td class="e_num">番号</td>
<td class="e_title">イベントタイトル</td>
<td class="e_date">開催日時</td>
<td class="e_detail">イベント詳細</td>
<?= $temp ?>
</table>

<br><br><br>

<hr class="top">
<hr class="bottom">
<br><br>

</body>
</html>
