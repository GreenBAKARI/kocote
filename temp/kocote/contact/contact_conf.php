<?php
  session_start();
  if(!(isset($_SESSION["user_id"]))){
    header("Location:login.php");
  }
  $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
          }
      //  データベーすの名前
  $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
          }
  mysql_set_charset('utf8');
  //関数定義
  $user_id=0;
  $category="";
  $contact_content="";
  $transfer_date="";
  $flg=true;
  $sql="";
  $user_id=$_SESSION["user_id"];
  $sql="SELECT CATEGORY FROM CF WHERE USER_ID = '$user_id'";
  $result = mysql_query($sql, $link);
  $sql1="SELECT CONTACT_CONTENT FROM CF WHERE USER_ID = '$user_id'";
  $result1 = mysql_query($sql1, $link);
  if(strpos($_SERVER['HTTP_REFERER'],'contact.php')===false)
  {
    echo "不正なアクセスです。";
  }
else{
while ($data = mysql_fetch_array($result)) {
   $category=$data['CATEGORY'];
}

while ($data1 = mysql_fetch_array($result1)) {
   $contact_content=$data1['CONTACT_CONTENT'];
}
}
?>

<?php
    //ログイン中の利用者の名前の取得
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');
    $sql_login = "SELECT USER_LAST_NAME, USER_FIRST_NAME FROM UR WHERE USER_ID = $user_id";
    $result_login = mysql_query($sql_login, $link);
    if (!$result_login) {
        die('クエリが失敗しました。'.mysql_error());
    }
    while ($row_login = mysql_fetch_array($result_login)) {
         $last_name_login = $row_login['USER_LAST_NAME'];
         $first_name_login = $row_login['USER_FIRST_NAME'];
    }
    $name_login = $last_name_login." ".$first_name_login;
    mysql_close($link);
?>

<html>
<head>
<meta charset="UTF-8">
<title>問い合わせ確認</title>
</head>
<center>
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/co_style.css"　type="text/css">

<body topmargin="100" bottommargin="100">

<div id="headerArea">
    <table>
        <tr>
            <td class="logo"><a href="http://localhost/kocote/index.php"><img class="logo-image" src="../img/kocote.png"></a></td>
            <td class="face"><img class="login-image" src="../img/login.jpg"></td>
            <td class="name"><p class="login-name"><?php echo $name_login;?></p></td>
            <td class="logout"><form id="logoutForm" name="logoutForm" action="../logout.php" method="POST">
            <input id="logout-botton" type="submit" id="logout" name="formname" value="ログアウト" >
            </form></td>
        </tr>
    </table>
</div>

<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->
 
<!-- 機能選択ボタン -->
<div id="box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a></div>
  <br>

  
<p class="transmission">以下の内容で問い合わせを送信しました。</p>
<form id="contactform" name="contactForm" action="contact_conf.php" method="POST">
<table class="contact">
    <tr><td class="left"><label for="time" style="margin-left:-11%">問い合わせ内容*：</label></td>
<td class="right"><select name="time">
<option value="-"><?php echo $category; ?></option>
    </select></td></tr>

    <tr><td class="left"><label for="event_comment" align="left" style="margin-left:-2%">作成者コメント*：</label></td>
        <td class="right"><textarea readonly name="event_comment" rows="7" cols="40"><?php echo $contact_content;?></textarea></td></tr>

</table>
    
    
<p>
<input type="button" onclick="location.href='../index.php'" value="トップに戻る" />
</p>

<div id="footerArea">
<ul>
<li><a href="">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="">個人情報保護方針</a></li>
<li><a href="">採用情報</a></li>
<li><a href="">サイトマップ</a></li>
</ul>
</div>

</body>
</center>
</html>
