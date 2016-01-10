<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>画像表示</title>
</HEAD>
<BODY>
<FORM method="POST" action="display.php">
	<P>画像の表示</P>
	ID：<INPUT type="text" name="id">
	<INPUT type="submit" name="submit" value="送信">
	<BR><BR>
</FORM>

<?php
if (count($_POST) > 0 && isset($_POST["submit"])){
	$id = $_POST["id"];
	if ($id==""){
		print("IDが入力されていません。<BR>\n");
	} else {
		print("<img src=\"./img_get.php?id=" . $id . "\">");
	}
}
?>
</BODY>
</HTML>