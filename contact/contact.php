<?php
  session_start();
  if(!(isset($_SESSION["user_id"]))){
    header("Location:login.php");
  }
  $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
          }
  //  データベースの名前
  $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
          }
  mysql_set_charset('utf8');
  date_default_timezone_set('Asia/Tokyo');
  //関数定義
  $user_id=0;
  $category="-";
  $contact_content="";
  $transfer_date="";
  $flg=true;
  $sql="";
  $message="";
  $transfer_date=date("Y-m-d");

  $user_id=$_SESSION["user_id"];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["category"]) && (htmlspecialchars($_POST["category"], ENT_QUOTES) != "-") ){
      $category = htmlspecialchars($_POST["category"], ENT_QUOTES);
    }else{
      $flg=false;
    }
    if(isset($_POST["contact_content"]) && !(htmlspecialchars($_POST["contact_content"], ENT_QUOTES) == "") ){
      $contact_content = htmlspecialchars($_POST["contact_content"], ENT_QUOTES);
    }else{
      $flg=false;
    }

  if($flg==false){
    $message ="未入力項目があります。";
  }
  else{
  $sql="INSERT INTO CF (USER_ID,CATEGORY,CONTACT_CONTENT,TRANSFER_DATE) VALUES('$user_id','$category','$contact_content','$transfer_date')";
  mysql_query($sql, $link);
  header("Location:contact_conf.php");
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
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br><br><br>
<p><?php echo $message; ?></p>
<form id="contactform" name="contactForm" action="contact.php" method="POST">
<label for="category" style="margin-left:-11%">問い合わせ内容*：</label>
<select name="category">
<option value="-">------------------------------</option>
<option value="掲示板の削除">掲示板の削除</option>
<option value="不快なユーザ">不快なユーザ</option>
<option value="不適切な発言">不適切な発言</option>
<option value="利用停止について">利用停止について</option>
<option value="その他">その他</option>
</select><br><br><br>

<label for="comment" align="left" style="margin-left:-2%">作成者コメント*：</label>
<textarea name="contact_content" rows="7" cols="40"><?php echo $contact_content;?></textarea>
<br><br><br>

<input type="reset" id="delete" name="delete" value="クリアする">
<input type="submit" id="edit_conf" name="edit_conf" value="確認画面へ進む">

</body>
</center>
</html>
