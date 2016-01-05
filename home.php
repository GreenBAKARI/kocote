<?php
session_start();
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
       die('接続失敗です。' .mysql_error());
   }
  //  データベーすの名前
$db_selected = mysql_select_db('greenbakari', $link);
if (!$db_selected) {
       die('データベース選択失敗です。'.mysql_error());
}
$mode="";
$user_id=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {//ログアウト処理
  //unset($_SESSION["user_id"]);
  if (isset($_COOKIE["user_id"])){
       setcookie("user_id", $_SESSION["user_id"], time() - 259200);
 }
  session_destroy();
  header("Location: login.php");
}
else{//ただのユーザID取得処
if (isset($_SESSION["user_id"])){
echo "セッションのユーザID:";
echo $_SESSION["user_id"];
}
if (isset($_COOKIE["user_id"])){
echo "クッキーのユーザID:";
echo $_COOKIE["user_id"];
}
}
?>

<html>
<head><title>PHP TEST</title></head>
<body>
<p>ログイン中</p>
<form id="logoutForm" name="logoutForm" action="home.php" method="POST">
<input type="submit" id="logout" name="formname" value="ログアウト" >
</form>
</body>
</html>
