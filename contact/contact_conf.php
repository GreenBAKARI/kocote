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

<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="style.css"　type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>


  <!-- <?php echo $errorMessage ?> -->

  <div id = "box">
    <a href="http://localhost/php/v0event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br><br><br>
<p>問い合わせ内容確認</p>
<form id="contactform" name="contactForm" action="contact_conf.php" method="POST">
<label for="time" style="margin-left:-11%">問い合わせ内容*：</label>
<select name="time">
<option value="-"><?php echo $category; ?></option>
</select><br><br><br>

<label for="event_comment" align="left" style="margin-left:-2%">作成者コメント*：</label>
<textarea readonly name="event_comment" rows="7" cols="40"><?php echo $contact_content;?></textarea>
<br><br><br>


</body>
</center>
</html>
