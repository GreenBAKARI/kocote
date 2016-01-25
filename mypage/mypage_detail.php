<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
<style>
.file {
	position: relative;
}

.file .header-button {
	width: 100%;
	height: 175px;
	margin: -19px;
}

.file .header-upload {
	top: 0;
	left: 18%;
	width: 64%;
	height: 175px;
	opacity: 0;
	position: absolute;
	cursor: pointer;
}

.file .icon-button {
	width: 180px;
	height: 180px;
}

.file .icon-upload {
	top: 0;
	left: 0;
	width: 180px;
	height: 180px;
	opacity: 0;
	position: absolute;
	cursor: pointer;
}
</style>
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
$user_id = $_GET ['user_id'];
//$user_id = 1;
if (empty ( $user_id )) {
	header ( "LOCATION: ./mypage.php" );
}

// MySQLと接続
$link = mysql_connect ( 'localhost', 'root','root' );
//$link = mysql_connect ( 'localhost', 'root' );
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

echo '<form action="mypage_conf.php" method="post" enctype="multipart/form-data">';
// user_id をmypage_conf.phpに伝播
echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
// 画像
$ua = mysql_fetch_assoc ( $sql_result_ua_select );
// // ヘッダ画像
echo <<< EOM
<div class="file">
    <div class="header-button">
    <img src="./img_get.php?user_id=$user_id&img_type=HEADER_IMAGE&img_table=ua" class="header-img">
    </div>
    <input type="file" class="header-upload" name="header_img"/>
</div>
EOM;
// // アイコン画像
echo <<< EOM
<div class="file" style="position:absolute;left:280px;top:450px;">
    <div class="icon-button">
    <img src="./img_get.php?user_id=$user_id&img_type=ICON_IMAGE&img_table=ua" class="icon-img">
    </div>
    <input type="file" class="icon-upload" name="icon_img"/>
</div>
EOM;
// 「編集を確認する」ボタン
echo '<input id="title2" type="submit" value="編集を確認する" name="upload">';

/* ▽ 名前・性別 ▽ */
/* 名前 */
echo '<div id="mypage_detail">';
echo '<table class="mypage-table" style="position:absolute;left:500px;top:450px;">';
echo '<tr>';
$ur = mysql_fetch_assoc ( $sql_result_ur_select );
echo ("<td class=\"name-size\">" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");
/* 性別 */
if ($ur ['SEX'] == "m")
	$sex = "男性";
else
	$sex = "女性";
echo ("　" . $sex);
echo "</td></tr><br>";

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
		$grade = '修士1年';
		break;
	case 6 :
		$grade = '修士2年';
		break;
}
echo "<tr><td class=\"name-size\">" . $ur ["COLLEGE_NAME"] . " " . "学科: ";
echo '<input type="hidden" name="grade" value="' . $grade . '">';
$gakka_KU = array (
		// 高知大学
		"人文学部",
		"教育学部",
		"理学部",
		"医学部",
		"農学部",
		"地域協働学部"
);

$gakka_UK = array (
		// 高知県立大学
		"文化学部",
		"看護学部",
		"社会福祉学部",
		"健康栄養学部"
);

$gakka_KUT = array (
		// 高知工科大学
		"情報学群",
		"環境理工学群",
		"システム工学群",
		"経済・マネジメント学群"
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
echo "</select>";
echo " " . $grade;
echo "</td></tr>";

/* ▽ 興味・関心のある分野 ▽ */
echo ("<tr><td class=\"name-size\">興味・関心のある分野" . "</td>");
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

echo '<tr><td class="space">';
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
echo ("</td></tr><br>");

/* ▽ 自己紹介 ▽ */
echo '<tr><td class="name-size">' . "自己紹介" . "</td></tr>";
echo '<tr><td class="space">';
echo '<textarea name="jikoshokai" cols="50" rows="6">' . $ua ['PROFILE'] . '</textarea>';
echo '</td></tr>';
echo '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
echo '</div>';
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
