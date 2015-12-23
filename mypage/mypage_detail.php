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

			<!-- 本体start -->
			<!-- 利用者未識別注意 -->
<?php

// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
if (! $link)
	die ( 'DB接続失敗です。' . mysql_error () );

	// データベースgreenbakariを選択
$db_selected = mysql_select_db ( 'greenbakari', $link );
if (! $db_selected)
	die ( 'データベース選択失敗です。' . mysql_error () );

	// クエリの発行
if (! $sql_result_ua = mysql_query ( 'SELECT * FROM ua' ))
	die ( 'クエリ失敗。' . mysql_error () );
if (! $sql_result_ur = mysql_query ( 'SELECT * FROM ur' ))
	die ( 'クエリ失敗。' . mysql_error () );
if (! $sql_result_ev = mysql_query ( 'SELECT * FROM ev' ))
	die ( 'クエリ失敗。' . mysql_error () );
if (! $sql_result_pev = mysql_query ( 'SELECT * FROM ev, pev WHERE ev.EVENT_ID=pev.EVENT_ID' ))
	die ( 'クエリ失敗。' . mysql_error () );
if (! $sql_result_fev = mysql_query ( 'SELECT * FROM ev, fev WHERE ev.EVENT_ID=fev.EVENT_ID' ))
	die ( 'クエリ失敗。' . mysql_error () );

echo ('
<FORM method="POST" enctype="multipart/form-data" action="upload.php">
	</FORM>
');
echo '<form action="mypage_conf.php" method="post">';
// ヘッダ画像
$ua = mysql_fetch_assoc ( $sql_result_ua );
echo '<p>';
echo '<img src="./img_get.php?id=' . $ua ['USER_ID'] . '&img=' . 'HEADER_IMAGE' . '"/>';
echo 'ヘッダ画像パス：<INPUT type="file" name="upfile" size="50"><BR>';
echo '</p>';
// アイコン画像
echo '<p>';
echo '<img src="./img_get.php?id=' . $ua ['USER_ID'] . '&img=' . 'ICON_IMAGE' . '"/>';
echo 'アイコン画像パス：<INPUT type="file" name="upfile" size="50"><BR>';
echo '</p>';
// 「編集を確認する」ボタン
echo '<input type="button" value="編集を確認する" name="conf" ></button>';

/* ▽ 名前・性別・名前の表記 ▽ */
/* 名前 */
$ur = mysql_fetch_assoc ( $sql_result_ur );
echo ("<p>" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
/* 性別 */
echo ("　" . $ur ['SEX'] . "	");
/* 名前の表記-ラジオボタン */
$hyoki = array (
		"日本語",
		"アルファベット"
);
echo '　名前の表記 : ';
foreach ( $hyoki as $key0 => $value ) {
	echo '<input type="radio" name="hyoki" value="' . $value . '"';
	// 選択済み判定(日本語を選択していると仮定)
	if ($key0 == 0)
		echo " checked";
	echo '>' . $value;
}
echo "</p>";
/* △ 名前・性別・名前の表記 △ */

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
echo "<p>" . $ur ["COLLEGE_NAME"] . "大学" . " " . $ur ["GRADE"] . "年" . " " . "学科: ";
$gakka = array (
		"情報",
		"環境",
		"シス"
);
echo '<select>';
foreach ( $gakka as $key => $value ) {
	echo '<option name="gakka" value="' . $value . '"';
	// 選択済み判定
	if ($ua ["DEPARTMENT_NAME"] == $value)
		echo " selected";
	echo '>' . $value . '</option>';
}
echo "</select></p>";
/* △ 大学・学年・学科 △ */

/* ▽ 興味・関心のある分野 ▽ */
echo ("<p>興味・関心のある分野" . "<br>");
$interest = array (
		"アニメ",
		"映画	",
		"音楽	",
		"カメラ",
		"グルメ",
		"ゲーム",
		"スポーツ",
		"釣り	",
		"天体観測",
		"動物	",
		"読書	",
		"乗り物",
		"ファッション",
		"漫画	",
		"料理	",
		"旅行	"
);
foreach ( $interest as $key => $value ) {
	echo '<input type="checkbox" name="interest" value="' . $value . '"';
	// 選択済み判定(音楽を選択していると仮定)
	if ($key == 2)
		echo " checked";
	echo '>' . $value;
	// ４つ毎に改行
	if ($key % 4 == 3)
		echo "<br>";
}
echo ("</p>");
/* △ 興味・関心のある分野 △ */

/* ▽ 自己紹介 ▽ */
echo "自己紹介" . "<br><p>";
echo '<textarea name="jikoshokai" cols="50" rows="6" disable>' . $ua ['PROFILE'] . '</textarea></p>';
/* △ 自己紹介 △ */

/* ▽ 立ち上げているイベント ▽ */
echo "立ち上げているイベント" . "<br><p>";
while ( $ev = mysql_fetch_assoc ( $sql_result_ev ) )
	echo $ev ['EVENT_START'] . " " . $ev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ 立ち上げているイベント △ */

/* ▽ 参加しているイベント ▽ */
echo "参加しているイベント" . "<br><p>";
while ( $pev = mysql_fetch_assoc ( $sql_result_pev ) )
	echo $pev ['EVENT_START'] . " " . $pev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ 参加しているイベント △ */

/* ▽ お気に入り登録しているイベント ▽ */
echo "お気に入り登録しているイベント" . "<br><p>";
while ( $fev = mysql_fetch_assoc ( $sql_result_fev ) )
	echo $fev ['EVENT_START'] . " " . $fev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ お気に入り登録しているイベント △ */
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
