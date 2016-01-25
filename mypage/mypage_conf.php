<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
	<link rel="stylesheet" href="../css/style.css" 　type="text/css">
	<link rel="stylesheet" href="../css/my_style.css" 　type="text/css">
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
$user_id = $_POST ['user_id'];
if (empty ( $user_id )) {
	header ( "LOCATION: ./mypage.php" );
}
// MySQLと接続
$link = mysql_connect ( 'localhost', 'root','root' );
if (! $link)
	die ( 'データベース接続失敗' . mysql_error () );

	// データベースgreenbakariを選択
$db_selected = mysql_select_db ( 'greenbakari', $link );
if (! $db_selected)
	die ( 'データベース選択失敗' . mysql_error () );

	// クエリの発行
if (! $sql_result_ua_select = mysql_query ( 'SELECT * FROM UA WHERE USER_ID=' . $user_id ))
	die ( '@uaテーブル SELECT失敗' . mysql_error () );
if (! $sql_result_ur_select = mysql_query ( 'SELECT * FROM UR WHERE USER_ID=' . $user_id ))
	die ( '@urテーブル SELECT失敗' . mysql_error () );


echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
// user_id をmypage_conf.phpに伝播
echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
// 画像
$ua = mysql_fetch_assoc ( $sql_result_ua_select );
// ヘッダ画像
if (move_uploaded_file ( $_FILES ['header_img'] ['tmp_name'], 'uploaded_header' . $user_id . '.jpg' )) {
	echo '<img src="uploaded_header' . $user_id . '.jpg" class="header-img">';
} else {
	echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=HEADER_IMAGE&img_table=ua" class="header-img">';
}

// アイコン画像
if (move_uploaded_file ( $_FILES ['icon_img'] ['tmp_name'], 'uploaded_icon' . $user_id . '.jpg' )) {
	echo '<img src="uploaded_icon' . $user_id . '.jpg" class="icon-img" style="position:absolute;left:280px;top:465px;">';
} else {
	echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=ICON_IMAGE&img_table=ua" class="icon-img" style="position:absolute;left:280px;top:465px;">';
}

// 「確定する」ボタン
echo '<input id="title3" type="submit" value="確定する" name="upload">';
// 「編集する」ボタン
echo '<input id="title4" "type="button" value="編集する" name="edit" onClick="history.back()">';
echo '<div id="mypage_detail">';
/* ▽ 名前・性別 ▽ */
/* 名前 */
echo '<table class="mypage-table" style="position:absolute;left:500px;top:470px;">';
echo '<tr>';
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
echo ("<td class=\"user-size\">" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");

/* 性別 */
if($ur ['SEX'] == "m") {
	echo '<font color="#0000ff" size=5>　男性</font>';
}else {
	echo '<font color="#ff0000" size=5>　女性</font>';
}
echo "</td></tr><br>";

/* ▽ 大学・学年・学科 ▽ */
/* 大学・学年・学科 */
echo "<tr><td class=\"name-size\">" . $ur ["COLLEGE_NAME"] . " " . $_POST ['grade'] . " " . "学科:" . $_POST ['gakka'] . "</td></tr><br>";
echo '<input type="hidden" name="gakka" value="' . $_POST ['gakka'] . '">';
echo  '<td><hr class="style-line"></td>';
/* ▽ 興味・関心のある分野 ▽ */
echo ("<tr><td class=\"name-size\">興味・関心のある分野" . "</td></tr>");
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

echo '<tr><td class="space">';
if (isset ( $_POST ['interest'] )) {
	foreach ( $_POST ['interest'] as $key => $value ) {
		$tf [$value] = "t";
		echo "・",$interest [$value] . "　";
		// 4行ごとに改行
		if (! (($key + 1) % 4))
			echo '<br>';
	}
}

echo '<input type="hidden" name="interest" value="' . $tf . '">';
echo ("</td></tr>");

/* ▽ 自己紹介 ▽ */
echo '<tr><td class="name-size">' . "自己紹介" . "</td></tr>";
echo '<tr><td class="space">';
echo $_POST ['jikoshokai'] . '</p>';
echo '<input type="hidden" name="jikoshokai" value="' . $_POST ['jikoshokai'] . '">';
echo '</td></tr>';
echo '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
echo '</div>';
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
