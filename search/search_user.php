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
<title>利用者検索</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/se_style.css"　type="text/css">
<body topmargin = "100" bottommargin = "100">

<div id = "headerArea"></div>
<div id = "footerArea"></div>
<br><br><br>

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

//_POST[] - HTTP POSTメソッドから利用者検索に渡された変数の連想配列を定義する
//利用者の氏名
$first_name = $_POST['first_name']; //名
$last_name = $_POST['last_name'];   //姓
//利用者の属性
$college = $_POST['college'];       //大学
$grade = $_POST['grade'];           //学年
//興味・関心タグ
$tag1 = $_POST['tag1'];             //アニメ
$tag2 = $_POST['tag2'];             //映画
$tag3 = $_POST['tag3'];             //音楽
$tag4 = $_POST['tag4'];             //カメラ
$tag5 = $_POST['tag5'];             //グルメ
$tag6 = $_POST['tag6'];             //ゲーム
$tag7 = $_POST['tag7'];             //スポーツ
$tag8 = $_POST['tag8'];             //釣り
$tag9 = $_POST['tag9'];             //天体観測
$tag10 = $_POST['tag10'];           //動物
$tag11 = $_POST['tag11'];           //読書
$tag12 = $_POST['tag12'];           //乗り物
$tag13 = $_POST['tag13'];           //ファッション
$tag14 = $_POST['tag14'];           //漫画
$tag15 = $_POST['tag15'];           //料理
$tag16 = $_POST['tag16'];           //旅行

//文字列(タグ)の連結
$tag = $tag1.$tag2.$tag3.$tag4.$tag5.$tag6.$tag7.$tag8.$tag9.$tag10.$tag11.$tag12.$tag13.$tag14.$tag15.$tag16;

//strlen() - 与えられた文字列の長さを返す
$count = strlen($tag);

//大学名を数字から文字に変換
switch ($college) {
    case 1:
        $college = '高知大学';
        break;
    case 2:
        $college = '高知県立大学';
        break;
    case 3:
        $college = '高知工科大学';
        break;
    default:
        break;
}

//タグが選択されていない場合の検索条件の生成
if (!$count) {
	//名・姓・大学・学年のすべてが入力されている場合の検索条件の生成
	if ($first_name && $last_name && $college && $grade) {
		//mysql_query() - MySQLデータベースへクエリを発行する
		$result = mysql_query("SELECT UR.USER_ID, UR.USER_FIRST_NAME, UR.USER_LAST_NAME, UA.PROFILE 
			FROM UR LEFT JOIN UA ON (UR.USER_ID = UA.USER_ID) 
			WHERE (UR.USER_FIRST_NAME = '$first_name' OR UR.USER_LAST_NAME = '$last_name')  
			AND (UR.COLLEGE_NAME = '$college' OR UR.GRADE = $grade)");
	//名・姓・大学・学年のいずれかが入力されている場合の検索条件の生成
	} else { 
		$result = mysql_query("SELECT UR.USER_ID, UR.USER_FIRST_NAME, UR.USER_LAST_NAME, UA.PROFILE 
			FROM UR LEFT JOIN UA ON (UR.USER_ID = UA.USER_ID) 
			WHERE (UR.USER_FIRST_NAME = '$first_name' OR UR.USER_LAST_NAME = '$last_name')  
			OR (UR.COLLEGE_NAME = '$college' OR UR.GRADE = $grade)");
	}
//タグが選択されている場合の検索条件の生成と文字列分解
} else {
        for ($i = 1; $i <= $count; $i++) {
            $interest = $interest."MID(UA.INTEREST, ".$tag[$i-1].", 1) = 't'"; 
            if ($i != $count) {
                $interest = $interest." OR ";
            }
        }
        
        $result = mysql_query("SELECT UR.USER_ID, UR.USER_FIRST_NAME, UR.USER_LAST_NAME, UA.PROFILE 
			FROM UR LEFT JOIN UA ON (UR.USER_ID = UA.USER_ID) 
			WHERE (UR.USER_FIRST_NAME = '$first_name' OR UR.USER_LAST_NAME = '$last_name')  
			AND (UR.COLLEGE_NAME = '$college' OR UR.GRADE = $grade) OR $interest");
	//名が入力されており、姓・大学・学年が入力されていない場合と
	//姓が入力されており、名・大学・学年が入力されていない場合と
	//名・姓が入力されており、大学・学園が入力されていない場合の検索条件の生成
	if ($first_name && !$last_name && !$college && !$grade && $count 
		|| !$first_name && $last_name && !$college && !$grade && $count
		|| $first_name && $last_name && !$college && !$grade && $count ) {
		$result = mysql_query("SELECT UR.USER_ID, UR.USER_FIRST_NAME, UR.USER_LAST_NAME, UA.PROFILE 
			FROM UR LEFT JOIN UA ON (UR.USER_ID = UA.USER_ID) 
			WHERE (UR.USER_FIRST_NAME = '$first_name' OR UR.USER_LAST_NAME = '$last_name')  
			OR $interest");	
    }
}

//抽出結果に表示番号を割り振る
$display_num = 1;

//mysql_num_rows() - クエリの実行結果から行の数を取得する
$rows = mysql_num_rows($result);

if ($rows) {
	//mysql_fetch_array() - クエリの実行結果を連想配列として取得する
	while ($row = mysql_fetch_array($result)) {
		$send = $row['USER_ID'];
		$name = $row['USER_LAST_NAME'].$row['USER_FIRST_NAME'];
		$temp = $temp."<tr>";
		$temp = $temp."<td class=u_num_main>".$display_num++."</td>";
                //ログイン中のユーザが表示される場合はmypage.phpへのリンクを生成
                if ($send == $user_id) {
                    $temp = $temp."<td class=u_name_main><a href=../mypage/mypage.php>".$name."</a></td>";
                } else {
                    $temp = $temp."<td class=u_name_main><a href=../mypage/personalpage.php?user_id=$send>".$name."</a></td>";
                }
		$temp = $temp."<td class=u_prof_main>".mb_wordwrap($row['PROFILE'], 45, "<br>\n", true)."</td>";
		$temp = $temp."</tr>";
	}
	$msg = "<p><h3>検索結果： 該当する利用者が".$rows."名表示されました。</h3></p><br>";
} else {
	$msg = "<p><h3>検索結果： 該当する利用者は存在しません。</h3></p>";
}

//mysql_close() - MySQLサーバへの接続をクローズにする
$close_flag = mysql_close($link);

if (!$close_flag) {
    die('切断に失敗しました。'.mysql_error());
}
//print('<p>切断に成功しました。</p>');
?>

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

<?= $msg ?>
<table class="result">
<tr class="title">
<td class="u_num">番号</td>
<td class="u_name">利用者名</td>
<td class="u_prof">プロフィール</td>
</tr>
<?= $temp ?>
</table>

<br><br><br>

<hr class="top">
<hr class="bottom">
<br><br></form>

</body>
</html>
