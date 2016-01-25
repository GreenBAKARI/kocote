<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    if (empty($user_id)) {
        header("LOCATION: ../login.php");
    }
?>

<?php
    //ログイン中の利用者の名前の取得
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');
    $sql_login = "SELECT USER_LAST_NAME, USER_FIRST_NAME FROM UR WHERE USER_ID = $user_id";
    $result_login = mysql_query($sql_login, $link);
    if (!$result_login) {
        die('クエリが失敗しました。'.mysql_error());
    }
    while ($row_login = mysql_fetch_array($result_login)) {
         $last_name_login = $row_login['USER_LAST_NAME'];
         $first_name_login = $row_login['USER_FIRST_NAME'];
    }
    $name_login = $last_name_login." ".$first_name_login;
    mysql_close($link);
?>

<html>
<head>
<meta charset = "utf-8">
<title>掲示板検索</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/se_style.css"　type="text/css">
<body topmargin = "100" bottommargin = "100">

<div id="headerArea">
    <table>
        <tr>
            <td class="logo"><a href="http://localhost/kocote/index.php"><img class="logo-image" src="../img/kocote.png"></a></td>
            <td class="face"><img class="login-image" src="../img/login.jpg"></td>
            <td class="name"><p class="login-name"><?php echo $name_login;?></p></td>
            <td class="logout"><form id="logoutForm" name="logoutForm" action="../logout.php" method="POST">
            <input id="logout-botton" type="submit" id="logout" name="formname" value="ログアウト" >
            </form></td>
        </tr>
    </table>
</div>

 
<!-- 機能選択ボタン -->
<div id="box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a>
</div>

<br><br>

<hr class="top">
<hr class="bottom">
<br>

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

//_POST[] - HTTP POSTメソッドから掲示板検索に渡された変数の連想配列を定義する
$keyword = $_POST['bb_keyword'];   //キーワード
$category = $_POST['bb_category']; //分類

//掲示板一覧ページから検索がかかったときは、GETで受け取る
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

//分類の変換
switch ($category) {
    case 1:
        $category = 'グルメ/フェスティバル';
        break;
    case 2:
        $category = '芸術/エンタメ';
        break;
    case 3:
        $category = '交流/スポーツ';
        break;
    case 4:
        $category = '地域振興/福祉';
        break;
    case 5:
        $category = '就活/キャリア';
        break;
    case 6:
        $category = 'その他';
        break;
    default:
        break;
}
   
//キーワードが入力されておらず、分類が入力されている場合の検索条件の生成
if (!$keyword && $category) {
    //mysql_query() - MySQLデータベースへクエリを発行する
    $result = mysql_query("SELECT BB_ID, BB_NAME, LAST_POSTED_DATE, COMMENT_COUNT FROM BB 
        WHERE BB_NAME LIKE '%$keyword%' AND CATEGORY = '$category'");
//キーワード・分類が入力されている場合、またはキーワードが入力されており、分類が入力されていない場合の検索条件の生成
} else if ($keyword && $category || $keyword && !$category) {
    $result = mysql_query("SELECT BB_ID, BB_NAME, LAST_POSTED_DATE, COMMENT_COUNT FROM BB 
        WHERE BB_NAME LIKE '%$keyword%' OR CATEGORY = '$category'");
//分類が「全て」の場合
} else {
    $result = mysql_query("SELECT BB_ID, BB_NAME, LAST_POSTED_DATE, COMMENT_COUNT FROM BB");
}

if (!$result) {
    die('クエリが失敗しました。'.mysql_error());
}
//print('<p>クエリが成功しました。</p>');

//抽出結果に表示番号を割り振る
$display_num = 1;

//mysql_num_rows() - クエリの実行結果から行の数を取得する
$rows = mysql_num_rows($result);

if ($rows) {
	//mysql_fetch_array() - クエリの実行結果を連想配列として取得する
	while ($row = mysql_fetch_array($result)) {
        $send = $row['BB_ID'];
        $date = $row['LAST_POSTED_DATE'];
		$temp = $temp."<tr>";
        $temp = $temp."<td class=b_num_main>".$display_num++."</td>";
        $temp = $temp."<td class=b_title_main><a href=../bulletin/bulletin_datail.php?bb_id=$send>".$row['BB_NAME']."</a></td>";
        $temp = $temp."<td class=b_date_main>".substr($date, 0, 4)."年".substr($date, 5, 2)."月".substr($date, 8, 2)."日"."</td>";
        $temp = $temp."<td class=b_comment_main>".$row['COMMENT_COUNT']."</td>";
        $temp = $temp."</tr>";
    }
    $msg = "<p><h3>検索結果： 該当する掲示板が".$rows."件表示されました。</h3></p><br>";
} else {
    $msg = "<p><h3>検索結果： 該当する掲示板は存在しません。</h3></p>";
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
<td class="b_num">番号</td>
<td class="b_title">掲示板タイトル</td>
<td class="b_date">最終投稿日時</td>
<td class="b_comment">コメント数</td>
<?= $temp ?>
</table>

<br><br><br>

<hr class="top">
<hr class="bottom">

<br><br>

<div id="footerArea">
<ul>
<li><a href="">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="">個人情報保護方針</a></li>
<li><a href="">採用情報</a></li>
<li><a href="">サイトマップ</a></li>
</ul>
</div>

</center>

</body>
</html>
