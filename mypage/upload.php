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
					href="http://localhost/php/v0/mypage.php"><img
					src="img/mp_home.jpg" height="7%" width="16%"></a>
			</div>
			<br> <br> <br>
		</form>

		<!-- 本体start -->
<?php
$user_id = $_POST ['user_id'];
if (empty ( $user_id )) {
	header ( "LOCATION: ./mypage.php" );
}

// MySQLと接続
$link = mysql_connect ( 'localhost', 'root' );
// データベースを選択
$dbLink = mysql_select_db ( 'greenbakari', $link );

// データ更新
if (isset ( $_POST ['gakka'] ) && isset ( $_POST ['interest'] ) && isset ( $_POST ['jikoshokai'] )) {
	$sql = 'UPDATE ua SET DEPARTMENT_NAME="' . $_POST ['gakka'] . '", INTEREST="' . $_POST ['interest'] . '" , PROFILE="' . $_POST ['jikoshokai'] . '" WHERE USER_ID = ' . $user_id;
	$result = mysql_query ( $sql );
	if (! $result) {
		print ("SQLの実行に失敗しました<BR>") ;
		print (mysql_errno () . ": " . mysql_error () . "<BR>") ;
		exit ();
	}
}

$fp = fopen ( "uploaded_header" . $user_id . ".jpg", "rb" );
$imgdata = fread ( $fp, filesize ( "uploaded_header" . $user_id . ".jpg" ) );
fclose ( $fp );
$str = mb_convert_encoding ( $imgdata, "UTF-8" );
$header_imgdata = addslashes ( $imgdata );
$fp = fopen ( "uploaded_icon" . $user_id . ".jpg", "rb" );
$imgdata = fread ( $fp, filesize ( "uploaded_icon" . $user_id . ".jpg" ) );
fclose ( $fp );
$str = mb_convert_encoding ( $imgdata, "UTF-8" );
$icon_imgdata = addslashes ( $imgdata );
if (! $sql_result_ua_update = mysql_query ( 'UPDATE ua SET HEADER_IMAGE="' . $header_imgdata . '", ICON_IMAGE="' . $icon_imgdata . '" WHERE USER_ID = ' . $user_id ))
	die ( '@ua, HEADER_IMAGEテーブル UPDATE失敗' . mysql_error () );
unlink("uploaded_header" . $user_id . ".jpg");
unlink("uploaded_icon" . $user_id . ".jpg");

print ("登録が終了しました<BR>") ;
echo '<input type="button" value="個人ページ画面へ戻る" onclick="location.href=\'mypage.php\'">';
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
