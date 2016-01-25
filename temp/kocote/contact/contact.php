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
  $transfer_date=date("Y-m-d H:i:s");

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
<title>問い合わせ</title>
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
  
  <br>
  

<form id="contactform" name="contactForm" action="contact.php" method="POST">
      <table class="contact">
          <tr>
          <td class="left"><label for="category">問い合わせ内容*：</label></td>
            <td class="right"><select name="category">
            <option value="-">---------------------</option>
            <option value="掲示板の削除">掲示板の削除</option>
            <option value="不快なユーザ">不快なユーザ</option>
            <option value="不適切な発言">不適切な発言</option>
            <option value="利用停止について">利用停止について</option>
            <option value="その他">その他</option>
            </select></td>
      </tr>

      <tr>
      <td class="left"><label for="comment" align="left">作成者コメント*：</label></td>
<td class="right"><textarea name="contact_content" rows="7" cols="40"><?php echo $contact_content;?></textarea></td>
      </tr>
      <tr>
      <td></td>
      <td class="right"><p class="error"><?php echo $message; ?></p></td>
      </tr>
      </table>

<input type="reset" id="delete" name="delete" value="クリアする">
<input type="submit" id="edit_conf" name="edit_conf" value="送信">

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
