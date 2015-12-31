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
/* POST@in
 * header_img	: ヘッダ画像
 * icon_img		: アイコン画像
 * hyoki		: 名前の表記
 * gakka		: 学科
 * interest		: 興味・関心のある分野
 * jikoshokai	: 自己紹介
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
if (! $sql_result_ev_select = mysql_query ( 'SELECT * FROM ev' ))
	die ( '@ｅｖテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_pev_select = mysql_query ( 'SELECT * FROM ev, pev WHERE ev.EVENT_ID=pev.EVENT_ID' ))
	die ( '@ev, pevテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_fev_select = mysql_query ( 'SELECT * FROM ev, fev WHERE ev.EVENT_ID=fev.EVENT_ID' ))
	die ( '@ev, fevテーブル SELECT失敗' . mysql_error () );

echo '<form action="upload.php" method="post">';
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
// 「確定する」ボタン
echo '<input type="submit" value="確定する" name="upload" >';
// 「編集する」ボタン
echo '<input type="button" value="編集する" name="upload" onClick="history.back()">';

/* ▽ 名前・性別・名前の表記 ▽ */
/* 名前 */
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
/* 名前の表記
 * true  ⇒ 日本語
 * false ⇒ ローマ字
 */
if ($_POST['hyoki']) {
	echo ("<p>" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
} else {
	echo ("<p>" . $ur ['USER_LAST_ROMA'] . " " . $ur ['USER_FIRST_ROMA'] . "	");
}

/* 性別 */
echo ("　" . $ur ['SEX'] . "	");

/* 名前の表記 */
echo '　名前の表記 : '.$_POST['hyoki'];
/* △ 名前・性別・名前の表記 △ */

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
echo "<p>" . $ur ["COLLEGE_NAME"] . "大学" . " " . $ur ["GRADE"] . "年" . " " . "学科:". $_POST['gakka'];
/* △ 大学・学年・学科 △ */

/* ▽ 興味・関心のある分野 ▽ */
echo ("<p>興味・関心のある分野" . "<br>");
$num=0;
foreach ( $_POST['interest'] as $value) {
	echo $value;
	// 4行ごとに改行
	if (!(++$num%4))
		echo '<br>';
}
echo ("</p>");
/* △ 興味・関心のある分野 △ */

/* ▽ 自己紹介 ▽ */
echo "自己紹介" . "<br><p>";
echo $_POST['jikoshokai'] .'</p>';
/* △ 自己紹介 △ */

/* ▽ 立ち上げているイベント ▽ */
echo "立ち上げているイベント" . "<br><p>";
while ( $ev = mysql_fetch_assoc ( $sql_result_ev_select ) )
	echo $ev ['EVENT_START'] . " " . $ev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ 立ち上げているイベント △ */

/* ▽ 参加しているイベント ▽ */
echo "参加しているイベント" . "<br><p>";
while ( $pev = mysql_fetch_assoc ( $sql_result_pev_select ) )
	echo $pev ['EVENT_START'] . " " . $pev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ 参加しているイベント △ */

/* ▽ お気に入り登録しているイベント ▽ */
echo "お気に入り登録しているイベント" . "<br><p>";
while ( $fev = mysql_fetch_assoc ( $sql_result_fev_select ) )
	echo $fev ['EVENT_START'] . " " . $fev ['EVENT_TITLE'] . '<br>';
echo '</p>';
/* △ お気に入り登録しているイベント △ */
if (! $sql_result_tmp_select = mysql_query ( 'DROP TABLE tmp' ))
	die ( '@tmpテーブル DROP失敗' . mysql_error () );
mysql_close ( $link );
echo '</form>';
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
