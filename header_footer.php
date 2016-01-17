<!-- 以下の処理のphpの処理を追加してください -->

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

<!-- <div id="headerArea>から</center>までを置き換えてください -->

<div id="headerArea">
    <table>
        <tr>
            <td><img class="login-image" src="../img/login.jpg"></td>
            <td><p class="login-name"><?php echo $name_login;?></p></td>
            <td><form id="logoutForm" name="logoutForm" action="../logout.php" method="POST">
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
</center>  


<!-- <div id="footerArea">から</div>までを置き換えてください -->

<div id="footerArea">
<ul>
<li><a href="">会社概要</a></li>
<li><a href="../contact/contact.php">お問い合わせ</a></li>
<li><a href="">個人情報保護方針</a></li>
<li><a href="">採用情報</a></li>
<li><a href="">サイトマップ</a></li>
</ul>
</div>



