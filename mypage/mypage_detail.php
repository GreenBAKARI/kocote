<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
	<link rel="stylesheet" href="style.css" 　type="text/css">
	<body topmargin="100" bottommargin="100">

		<div id="headerArea"></div>

		<form id="loginForm" name="loginForm" action="" method="POST">
			<!-- <?php echo $errorMessage ?> -->

			<!-- 機能選択ボタン -->
			<div id="box">
				<a href="../event/event.php"><img src="../img/ev_home.jpg"
					height="13%" width="16%"></a> <a href="../bulletin/bulletin.php"><img
					src="../img/bb_home.jpg" height="13%" width="16%"></a> <a
					href="../search/search.php"><img src="../img/se_home.jpg"
					height="13%" width="16%"></a> <a href="../mypage/mypage.php"><img
					src="../img/mp_home.jpg" height="13%" width="16%"></a>
			</div>
			<br>
		</form>

		<!-- 本体start -->

<?php
$user_id = $_GET ['user_id'];
if (empty ( $user_id )) {
	header ( "LOCATION: ./mypage.php" );
}

// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
if (! $link)
	die ( 'データベース接続失敗' . mysql_error () );

	// データベースgreenbakariを選択
$db_selected = mysql_select_db ( 'greenbakari', $link );
if (! $db_selected)
	die ( 'データベース選択失敗' . mysql_error () );

	// クエリの発行
if (! $sql_result_ua_select = mysql_query ( 'SELECT * FROM ua WHERE USER_ID=' . $user_id ))
	die ( '@uaテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_ur_select = mysql_query ( 'SELECT * FROM ur WHERE USER_ID=' . $user_id ))
	die ( '@urテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_ev_select = mysql_query ( 'SELECT * FROM ev WHERE USER_ID=' . $user_id ))
	die ( '@ｅｖテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_pev_select = mysql_query ( 'SELECT * FROM ev, pev WHERE ev.EVENT_ID=pev.EVENT_ID AND pev.USER_ID=' . $user_id . ' ORDER BY ev.EVENT_START ASC LIMIT 5' ))
	die ( '@ev, pevテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_fev_select = mysql_query ( 'SELECT * FROM ev, fev WHERE ev.EVENT_ID=fev.EVENT_ID AND fev.USER_ID=' . $user_id . ' ORDER BY ev.EVENT_START ASC LIMIT 5' ))
	die ( '@ev, fevテーブル SELECT失敗' . mysql_error () );

	/*
 * POST@out
 * header_img : ヘッダ画像
 * icon_img : アイコン画像
 * gakka : 学科
 * interest : 興味・関心のある分野
 * jikoshokai : 自己紹介
 */
echo '<form action="mypage_conf.php" method="post" enctype="multipart/form-data">';
// user_id をmypage_conf.phpに伝播
echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
// 画像
$ua = mysql_fetch_assoc ( $sql_result_ua_select );
// ヘッダ画像
echo '<p>';
echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=HEADER_IMAGE&img_table=ua">';
echo 'ヘッダ画像ファイル選択：<input type="file" name="header_img" size="50"><BR>';
echo '</p>';
// アイコン画像
echo '<p>';
echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=ICON_IMAGE&img_table=ua">';
echo 'アイコン画像ファイル選択:<input type="file" name="icon_img" size="50"><BR>';
echo '</p>';
// 「編集を確認する」ボタン
echo '<input type="submit" value="編集を確認する" name="upload" >';

/* ▽ 名前・性別 ▽ */
/* 名前 */
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
echo ("<p>" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
/* 性別 */
if ($ur ['SEX'] == "m")
	$sex = "男";
else if ($ur ['SEX'] == "f")
	$sex = "女";
echo ("　" . $sex);
echo "</p>";

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
switch ($ur ['GRADE']) {
	case 1 :
		$grade = '学部1年';
		break;
	case 2 :
		$grade = '学部2年';
		break;
	case 3 :
		$grade = '学部3年';
		break;
	case 4 :
		$grade = '学部4年';
		break;
	case 5 :
		$grade = '修士s1年';
		break;
	case 6 :
		$grade = '修士2年';
		break;
}
echo "<p>" . $ur ["COLLEGE_NAME"] . " " . $grade . " " . "学科: ";
echo '<input type="hidden" name="grade" value="' . $grade . '">';
$gakka_KU = array (
		// 高知大学
		"人文社会科学",
		"自然科学",
		"医療学",
		"総合化学"
);

$gakka_UK = array (
		// 高知県立大学
		"文化学",
		"看護学",
		"社会福祉学",
		"健康栄養学"
);

$gakka_KUT = array (
		// 高知工科大学
		"情報学",
		"環境理工学",
		"システム工学"
);
echo '<select name="gakka">';
if ($ur ["COLLEGE_NAME"] == "高知大学") {
	foreach ( $gakka_KU as $key => $value ) {
		echo '<option value="' . $value . '"';
		// 選択済み判定
		if ($ua ["DEPARTMENT_NAME"] == $value)
			echo " selected";
		echo '>' . $value . '</option>';
	}
} else if ($ur ["COLLEGE_NAME"] == "高知県立大学") {
	foreach ( $gakka_UK as $key => $value ) {
		echo '<option value="' . $value . '"';
		// 選択済み判定
		if ($ua ["DEPARTMENT_NAME"] == $value)
			echo " selected";
		echo '>' . $value . '</option>';
	}
} else if ($ur ["COLLEGE_NAME"] == "高知工科大学") {
	foreach ( $gakka_KUT as $key => $value ) {
		echo '<option value="' . $value . '"';
		// 選択済み判定
		if ($ua ["DEPARTMENT_NAME"] == $value)
			echo " selected";
		echo '>' . $value . '</option>';
	}
}
echo "</select></p>";

/* ▽ 興味・関心のある分野 ▽ */
echo ("<p>興味・関心のある分野" . "<br>");
$interest = array (
		"アニメ",
		"映画 ",
		"音楽 ",
		"カメラ",
		"グルメ",
		"ゲーム",
		"スポーツ",
		"釣り ",
		"天体観測",
		"動物 ",
		"読書 ",
		"乗り物",
		"ファッション",
		"漫画 ",
		"料理 ",
		"旅行 "
);

// 興味・関心に格納されている文字列の長さを取得
$interest_length = mb_strlen ( $ua ['INTEREST'] );

for($i = 0; $i < $interest_length; $i ++)
	$interest_trueORfalse [$i] = substr ( $ua ['INTEREST'], $i, 1 );

foreach ( $interest as $key => $value ) {
	echo '<input type="checkbox" name="interest[]" value="' . $key . '"';

	// 選択済み判定 チェック済⇒"ｔ" 未チェック⇒"f"
	if ($interest_length > $key)
		if ($interest_trueORfalse [$key] == "t")
			echo " checked";

	echo '>' . $value;
	// 4項目毎に改行
	if ($key % 4 == 3)
		echo "<br>";
}

echo '<input type="hidden" name="key" value="' . $key . '">';
echo ("</p>");

/* ▽ 自己紹介 ▽ */
echo "自己紹介" . "<br><p>";
echo '<textarea name="jikoshokai" cols="50" rows="6">' . $ua ['PROFILE'] . '</textarea></p>';

/* ▽ 立ち上げているイベント ▽ */
echo "立ち上げているイベント" . "<br><p>";
while ( $ev = mysql_fetch_assoc ( $sql_result_ev_select ) ) {
	// このページの利用者が立ち上げているイベントの参加人数
	$ev_count = event_count ( $ev ['EVENT_ID'] );

	$date = new DateTime ( $ev ['EVENT_START'] );
	echo $date->format ( 'Y年n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $ev ['EVENT_ID'] . '>' . $ev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:' . $ev_count . '人)', '<br>';
	echo '</p>';
}

/* ▽ 参加しているイベント ▽ */
echo "参加しているイベント" . "<br><p>";
while ( $pev = mysql_fetch_assoc ( $sql_result_pev_select ) ) {
	// このページの利用者が参加しているイベントの参加人数
	$pev_count = event_count ( $pev ['EVENT_ID'] );

	$date = new DateTime ( $pev ['EVENT_START'] );
	echo $date->format ( 'Y年n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $pev ['EVENT_ID'] . '>' . $pev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:', $pev_count, '人)', '<br>';
	echo '</p>';
}

/* ▽ お気に入り登録しているイベント ▽ */
echo "お気に入り登録しているイベント" . "<br><p>";
while ( $fev = mysql_fetch_assoc ( $sql_result_fev_select ) ) {
	// このページの利用者が参加しているイベントの参加人数
	$fev_count = event_count ( $fev ['EVENT_ID'] );

	$date = new DateTime ( $fev ['EVENT_START'] );
	echo $date->format ( 'Y年n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $fev ['EVENT_ID'] . '>' . $fev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:', $fev_count, '人)', '<br>';
	echo '</p>';
}

mysql_close ( $link );
echo '</form>';

// イベントの参加人数を数える関数(参加人数を数えたいイベントのイベントIDを引数とする)
function event_count($cnt_id) {
	mysql_set_charset ( 'utf8' );
	// 参加イベントテーブルから引数のイベントIDを持つレコード数をカウントする
	$sql_evcnt = "SELECT COUNT(PEV.EVENT_ID) AS CNT FROM pev WHERE pev.EVENT_ID = $cnt_id;";

	$result_evcnt = mysql_query ( $sql_evcnt );
	if (! $result_evcnt) {
		die ( 'クエリが失敗しました。' . mysql_error () );
	}

	while ( $row_evcnt = mysql_fetch_array ( $result_evcnt ) ) {
		$event_evcnt = $row_evcnt ['CNT'];
	}
	return $event_evcnt;
}
?>

	<!-- 本体end-->

		<div id="footerArea">
			<ul>
				<li><a href="">会社概要</a></li>
				<li><a href="">お問い合わせ</a></li>
				<li><a href="">個人情報保護方針</a></li>
				<li><a href="">採用情報</a></li>
				<li><a href="">サイトマップ</a></li>
			</ul>
		</div>

	</body>

</html>
