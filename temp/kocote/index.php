<?php
session_start();
$user_id = $_SESSION['user_id'];
if (empty($user_id)) {
    header("LOCATION: ../login.php");
}

//ログイン中の利用者の名前の取得
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
    die('接続失敗です。' . mysql_error());
}
$db_selected = mysql_select_db('greenbakari', $link);
if (!$db_selected) {
    die('データベース選択失敗です。' . mysql_error());
}
mysql_set_charset('utf8');
$sql_login = "SELECT USER_LAST_NAME, USER_FIRST_NAME FROM UR WHERE USER_ID = $user_id";
$result_login = mysql_query($sql_login, $link);
if (!$result_login) {
    die('クエリが失敗しました。' . mysql_error());
}
while ($row_login = mysql_fetch_array($result_login)) {
    $last_name_login = $row_login['USER_LAST_NAME'];
    $first_name_login = $row_login['USER_FIRST_NAME'];
}
$name_login = $last_name_login . " " . $first_name_login;
mysql_close($link);
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>ホーム画面</title>
    </head>
    <center>
        <link rel="stylesheet" href="css/index_style.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <body>

            <div id="headerArea">
                <table>
                    <tr>
                        <td class="logo"><a href="index.php"><img class="logo-image" src="img/kocote.png"></a></td>
                        <td class="face"><img class="login-image" src="img/login.jpg"></td>
                        <td class="name"><p class="login-name"><?php echo $name_login; ?></p></td>
                        <td class="logout"><form id="logoutForm" name="logoutForm" action="logout.php" method="POST">
                                <input id="logout-botton" type="submit" id="logout" name="formname" value="ログアウト" >
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

            <table>
                <tr>
                    <td>
                        <figure>
                            <div class="figure-ev">
                                <div class="image"><a href="event/event.php"><img src="img/event.jpg" /></a></div>
                                <figcaptionev>
                                    <center>
                                        <p class="index-title">イベント</p><br>
                                        <p class="index-content">イベント一覧の表示</p>
                                    </center>
                                </figcaptionev>
                            </div>
                        </figure>
                    </td>

                    <td>
                        <figure>
                            <div class="figure-bb">
                                <div class="image"><a href="bulletin/bulletin.php"><img src="img/bulletin.jpg" /></a></div>
                                <figcaptionbb>
                                    <center>
                                        <p class="index-title">掲示板</p><br>
                                        <p class="index-content">掲示板一覧の表示</p>
                                    </center>
                                </figcaptionbb>
                            </div>
                        </figure>
                    </td>
                </tr>
            </table>


            <table>
                <tr>
                    <td>
                        <figure>
                            <div class="figure-se">
                                <div class="image"><a href="search/search.php"><img src="img/search.jpg" /></a></div>
                                <figcaptionse>
                                    <center>
                                        <p class="index-title">検索</p><br>
                                        <p class="index-content">イベント / 掲示板 / 利用者の検索</p>
                                    </center>
                                </figcaptionse>
                            </div>
                        </figure>
                    </td>

                    <td>
                        <figure>
                            <div class="figure-mp">
                                <div class="image"><a href="mypage/mypage.php"><img src="img/mypage.jpg" /></a></div>
                                <figcaptionmp>
                                    <center>
                                        <p class="index-title">マイページ</p><br>
                                        <p class="index-content">マイページの表示</p>
                                    </center>
                                </figcaptionmp>
                            </div>
                        </figure>
                    </td>
                </tr>
            </table>

            <div id="footerArea">
                <ul>
                    <li><a href="">会社概要</a></li>
                    <li><a href="contact/contact.php">お問い合わせ</a></li>
                    <li><a href="">個人情報保護方針</a></li>
                    <li><a href="">採用情報</a></li>
                    <li><a href="">サイトマップ</a></li>
                </ul>
            </div>

        </body>
    </center>
</html>
