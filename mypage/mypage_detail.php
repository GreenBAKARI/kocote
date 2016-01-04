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
if (! $sql_result_ev_select = mysql_query ( 'SELECT * FROM ev' ))
	die ( '@ｅｖテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_pev_select = mysql_query ( 'SELECT * FROM ev, pev WHERE ev.EVENT_ID=pev.EVENT_ID' ))
	die ( '@ev, pevテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_fev_select = mysql_query ( 'SELECT * FROM ev, fev WHERE ev.EVENT_ID=fev.EVENT_ID' ))
	die ( '@ev, fevテーブル SELECT失敗' . mysql_error () );

	/*
 * POST@out
 * header_img : ヘッダ画像
 * icon_img : アイコン画像
 * submit : 「編集を確認する」ボタン
 * hyoki : 名前の表記
 * gakka : 学科
 * interest : 興味・関心のある分野
 * jikoshokai : 自己紹介
 */
echo '<form action="mypage_conf.php" method="post">';
// ヘッダ画像
$ua = mysql_fetch_assoc ( $sql_result_ua_select );
echo '<p>';
echo '<img src="./img_get.php?img_type=HEADER_IMAGE&img_table=ua"/>';
echo 'ヘッダ画像パス：<input type="file" name="header_img" size="50"><BR>';
echo '</p>';
// アイコン画像
echo '<p>';
echo '<img src="./img_get.php?img_type=ICON_IMAGE&img_table=ua"/>';
echo 'アイコン画像パス：<input type="file" name="icon_img" size="50"><BR>';
echo '</p>';
// 「編集を確認する」ボタン
echo '<input type="submit" value="編集を確認する" name="upload" >';

/* ▽ 名前・性別・名前の表記 ▽ */
/* 名前 */
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
echo ("<p>" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
/* 性別 */
echo ("　" . $ur ['SEX'] . "	");
/* 名前の表記-ラジオボタン */
$hyoki = array (
		"日本語",
		"アルファベット"
);
$JP = 0; // 日本語
$RO = 1; // ローマ字
echo '　名前の表記 : ';
foreach ( $hyoki as $key0 => $value ) {
	echo '<input type="radio" name="hyoki" value="' . $value . '"';
	// 選択済み判定(日本語を選択していると仮定)
	if ($key0 == 0)
		echo " checked";
	echo '>' . $value;
}
echo "</p>";

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
echo "<p>" . $ur ["COLLEGE_NAME"] . "大学" . " " . $ur ["GRADE"] . "年" . " " . "学科: ";
$gakka = array (
		// 高知大学
		"人文社会科学",
		"自然科学",
		"医療学",
		"総合化学",

		// 高知県立大学
		"文化学",
		"看護学",
		"社会福祉学",
		"健康栄養学",

		// 高知工科大学
		"情報",
		"環境理工",
		"システム工学"
);
echo '<select name="gakka">';
foreach ( $gakka as $key => $value ) {
	echo '<option value="' . $value . '"';
	// 選択済み判定
	if ($ua ["DEPARTMENT_NAME"] == $value)
		echo " selected";
	echo '>' . $value . '</option>';
}
echo "</select></p>";

/* ▽ 興味・関心のある分野 ▽ */

echo ("<p>興味・関心のある分野" . "<br>");
// foreach ( $interest as $i => $value ) {
// echo '<input type="checkbox" name="interest[]" value="' . $value . '"';
// if ($ua ['INTEREST'] == true)
// echo "checked";
// echo '>' . $value;
// }
// echo '<input type="checkbox" name="interest[]" value="映画">映画';
// echo '<input type="checkbox" name="interest[]" value="音楽" checked>音楽';
// echo '<input type="checkbox" name="interest[]" value="カメラ">カメラ';
// echo '<br>';
// echo '<input type="checkbox" name="interest[]" value="グルメ">グルメ';
// echo '<input type="checkbox" name="interest[]" value="ゲーム">ゲーム';
// echo '<input type="checkbox" name="interest[]" value="スポーツ">スポーツ';
// echo '<input type="checkbox" name="interest[]" value="釣り">釣り';
// echo '<br>';
// echo '<input type="checkbox" name="interest[]" value="天体観測">天体観測';
// echo '<input type="checkbox" name="interest[]" value="動物">動物';
// echo '<input type="checkbox" name="interest[]" value="読書">読書';
// echo '<input type="checkbox" name="interest[]" value="乗り物">乗り物';
// echo '<br>';
// echo '<input type="checkbox" name="interest[]" value="ファッション">ファッション';
// echo '<input type="checkbox" name="interest[]" value="漫画">漫画';
// echo '<input type="checkbox" name="interest[]" value="料理">料理';
// echo '<input type="checkbox" name="interest[]" value="旅行">旅行';
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
// 興味・関心に格納されている文字の長さを取得
// INTERESTは文字列型とする．（チェック⇒"ｔ" 未チェック⇒"f"）
$len = mb_strlen ( $ua ['INTEREST'] );
for($i = 0; $i < $len; $i ++)
	$interest_trueORforce [$i] = substr ( $ua ['INTEREST'], $i, 1 );
foreach ( $interest as $key => $value ) {
	echo $key;
	echo '<input type="checkbox" name="interest[]" value="' . $value . '"';
	// 選択済み判定
	if ($len > $key)
		if ($interest_trueORforce [$key] == t)
			echo " checked";

	echo '>' . $value;
	// ４つ毎に改行
	if ($key % 4 == 3)
		echo "<br>";
}
echo ("</p>");

/* ▽ 自己紹介 ▽ */
echo "自己紹介" . "<br><p>";
echo '<textarea name="jikoshokai" cols="50" rows="6">' . $ua ['PROFILE'] . '</textarea></p>';

/* ▽ 立ち上げているイベント ▽ */
echo "立ち上げているイベント" . "<br><p>";
while ( $ev = mysql_fetch_assoc ( $sql_result_ev_select ) )
	echo $ev ['EVENT_START'] . " " . $ev ['EVENT_TITLE'] . '<br>';
echo '</p>';

/* ▽ 参加しているイベント ▽ */
echo "参加しているイベント" . "<br><p>";
while ( $pev = mysql_fetch_assoc ( $sql_result_pev_select ) )
	echo $pev ['EVENT_START'] . " " . $pev ['EVENT_TITLE'] . '<br>';
echo '</p>';

/* ▽ お気に入り登録しているイベント ▽ */
echo "お気に入り登録しているイベント" . "<br><p>";
while ( $fev = mysql_fetch_assoc ( $sql_result_fev_select ) )
	echo $fev ['EVENT_START'] . " " . $fev ['EVENT_TITLE'] . '<br>';
echo '</p>';

mysql_close ( $link );
echo '</form>';
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
