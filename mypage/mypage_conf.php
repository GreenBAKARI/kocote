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

			<div id="box">
				<a href="http://localhost/php/v0/event.php"><img
					src="img/ev_home.jpg" height="7%" width="16%"></a> <a
					href="http://localhost/php/v0/bulletin.php"><img
					src="img/bb_home.jpg" height="7%" width="16%"></a> <a
					href="http://localhost/php/v0/search.php"><img
					src="img/se_home.jpg" height="7%" width="16%"></a> <a
					href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg"
					height="7%" width="16%"></a> <a
					href="http://localhost/php/v0/mypage.php"><img
					src="img/mp_home.jpg" height="7%" width="16%"></a>
			</div>
			<br> <br> <br>
		</form>

		<!-- 本体start -->
<?php
/*
 * POST@in
 * header_img : ヘッダ画像
 * icon_img : アイコン画像
 * hyoki : 名前の表記
 * gakka : 学科
 * interest : 興味・関心のある分野
 * jikoshokai : 自己紹介
 */
// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
if (! $link)
	die ( 'データベース接続失敗' . mysql_error () );

	// データベースgreenbakariを選択
$db_selected = mysql_select_db ( 'greenbakari', $link );
if (! $db_selected)
	die ( 'データベース選択失敗' . mysql_error () );

	// クエリの発行
if (! $sql_result_ua_select = mysql_query ( 'SELECT * FROM ua' ))
	die ( '@uaテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_ur_select = mysql_query ( 'SELECT * FROM ur' ))
	die ( '@urテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_ev_select = mysql_query ( 'SELECT * FROM ev LIMIT 5' ))
	die ( '@ｅｖテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_pev_select = mysql_query ( 'SELECT * FROM ev, pev WHERE ev.EVENT_ID=pev.EVENT_ID LIMIT 5' ))
	die ( '@ev, pevテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_fev_select = mysql_query ( 'SELECT * FROM ev, fev WHERE ev.EVENT_ID=fev.EVENT_ID LIMIT 5' ))
	die ( '@ev, fevテーブル SELECT失敗' . mysql_error () );

echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
// 画像
$ua = mysql_fetch_assoc ( $sql_result_ua_select );
echo '<p>';
$header_imgdata = NULL;
$icon_imgdata = NULL;
if (! $sql_result_tmp_create = mysql_query ( 'CREATE TABLE IF NOT EXISTS tmp (HEADER_IMAGE BLOB, ICON_IMAGE BLOB, USER_ID INTEGER)' ))
	die ( '@tmp, CREATE失敗' . mysql_error () );
//if (! $sql_result_tmp_insert = mysql_query ( 'INSERT INTO TMP VALUES(NULL, NULL, 1)' ))
//	die ( '@tmp, INSERT失敗' . mysql_error () );
if (is_uploaded_file ( $_FILES ["header_img"]["tmp_name"])) {
	$fp = fopen ( $_FILES ["header_img"] ["tmp_name"], "rb" );
	$imgdata = fread ( $fp, filesize ( $_FILES ["header_img"] ["tmp_name"] ) );
	fclose ( $fp );
	$str = mb_convert_encoding ( $imgdata, "UTF-8" );
	$header_imgdata = addslashes ( $imgdata );
	//echo '<input type="hidden" name="header_imgdata" value="' . $header_imgdata . '"/>';
	if (! $sql_result_tmp_update = mysql_query ( 'UPDATE tmp SET HEADER_IMAGE="' . $header_imgdata . '"' ))
		die ( '@tmp, HEADER_IMAGE UPDATE失敗' . mysql_error () );
} else {
	echo "ファイルをアップロードできません。";
}

if (!isset ( $_FILES ["icon_img"] )) {
	$fp = fopen ( $_FILES ["icon_img"] ["tmp_name"], "rb" );
	$imgdata = fread ( $fp, filesize ( $_FILES ["icon_img"] ["tmp_name"] ) );
	fclose ( $fp );
	$str = mb_convert_encoding ( $imgdata, "UTF-8" );
	$icon_imgdata = addslashes ( $imgdata );
	echo '<input type="hidden" name="icon_imgdata" value="' . $icon_imgdata . '"/>';
	if (! $sql_result_tmp_update = mysql_query ( 'UPDATE tmp SET ICON_IMAGE="' . $icon_imgdata . '"' ))
		die ( '@tmp, ICON_IMAGEUPDATE失敗' . mysql_error () );
}

// ヘッダ画像
echo '<img src="./img_get.php?img_type=HEADER_IMAGE&img_table=ua"/>';
echo '<img src="./img_get.php?img_type=HEADER_IMAGE&img_table=tmp"/>';
echo '<img src="./img_get.php?raw_img='.$header_imgdata.'"/>';
echo '</p>';
// アイコン画像
echo '<p>';
echo '<img src="./img_get.php?img_type=ICON_IMAGE&img_table=ua"/>';
echo '<img src="./img_get.php?img_type=ICON_IMAGE&img_table=tmp"/>';
echo '<img src="'.$icon_imgdata.'"/>';
echo '</p>';

// 「確定する」ボタン
echo '<input type="submit" value="確定する" name="upload" >';
// 「編集する」ボタン
echo '<input type="button" value="編集する" name="upload" onClick="history.back()">';

/* ▽ 名前・性別・名前の表記 ▽ */
/* 名前 */
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
/*
 * 名前の表記
 * 0 ⇒ 日本語
 * 1 ⇒ ローマ字
 */

if ($_POST ['hyoki'] == 0) {
	echo ("<p>" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
} else {
	echo ("<p>" . $ur ['USER_LAST_ROMA'] . " " . $ur ['USER_FIRST_ROMA'] . "	");
}
echo '<input type="hidden" name="hyoki" value="' . $_POST ['hyoki'] . '">';

/* 性別 */
echo ("　" . $ur ['SEX'] . "	");

/* 名前の表記 */
$hyoki = array (
		"日本語",
		"アルファベット"
);
echo ' 名前の表記 : ' . $hyoki [$_POST ['hyoki']];

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
echo "<p>" . $ur ["COLLEGE_NAME"] . "大学" . " " . $ur ["GRADE"] . "年" . " " . "学科:" . $_POST ['gakka'];
echo '<input type="hidden" name="gakka" value="' . $_POST ['gakka'] . '">';

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

$tf = "";
for($i = 0; $i < $_POST ['key']; $i ++) {
	$tf = $tf . "f";
}

if (isset ( $_POST ['interest'] )) {
	foreach ( $_POST ['interest'] as $key => $value ) {
		$tf [$value] = "t";
		echo $interest [$value];
		// 4行ごとに改行
		if (! (($key + 1) % 4))
			echo '<br>';
	}
}

echo '<input type="hidden" name="interest" value="' . $tf . '">';
echo ("</p>");

/* ▽ 自己紹介 ▽ */
echo "自己紹介" . "<br><p>";
echo $_POST ['jikoshokai'] . '</p>';
echo '<input type="hidden" name="jikoshokai" value="' . $_POST ['jikoshokai'] . '">';

/* ▽ 立ち上げているイベント ▽ */
echo "立ち上げているイベント" . "<br><p>";
while ( $ev = mysql_fetch_assoc ( $sql_result_ev_select ) ) {
	// このページの利用者が立ち上げているイベントの参加人数
	$ev_count = event_count ( $ev ['EVENT_ID'] );

	$date = new DateTime ( $ev ['EVENT_START'] );
	echo $date->format ( 'n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $ev ['EVENT_ID'] . '>' . $ev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:' . $ev_count . '人)', '<br>';
	echo '</p>';
}

/* ▽ 参加しているイベント ▽ */
echo "参加しているイベント" . "<br><p>";
while ( $pev = mysql_fetch_assoc ( $sql_result_pev_select ) ) {
	// このページの利用者が参加しているイベントの参加人数
	$pev_count = event_count ( $pev ['EVENT_ID'] );

	$date = new DateTime ( $pev ['EVENT_START'] );
	echo $date->format ( 'n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $pev ['EVENT_ID'] . '>' . $pev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:', $pev_count, '人)', '<br>';
	echo '</p>';
}

/* ▽ お気に入り登録しているイベント ▽ */
echo "お気に入り登録しているイベント" . "<br><p>";
while ( $fev = mysql_fetch_assoc ( $sql_result_fev_select ) ) {
	// このページの利用者が参加しているイベントの参加人数
	$fev_count = event_count ( $fev ['EVENT_ID'] );

	$date = new DateTime ( $fev ['EVENT_START'] );
	echo $date->format ( 'n月j日' ) . '<a href=http://localhost/kocote/event/event_detail.php?event_id=' . $fev ['EVENT_ID'] . '>' . $fev ['EVENT_TITLE'] . '</a>', '(', '現在の参加人数:', $fev_count, '人)', '<br>';
	echo '</p>';
}

// if (! $sql_result_tmp_select = mysql_query ( 'DROP TABLE tmp' ))
// die ( '@tmpテーブル DROP失敗' . mysql_error () );
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

	<!-- 本体end -->

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
