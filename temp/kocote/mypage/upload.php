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
        <title>マイページ編集確認</title>
    </head>
    <center>
        <link rel="stylesheet" href="../css/style.css" 　type="text/css">
        <link rel="stylesheet" href="../css/mp_style.css" 　type="text/css">
        <body topmargin="100" bottommargin="100">

            <div id="headerArea">
                <table>
                    <tr>
                        <td class="logo"><a href="http://localhost/kocote/index.php"><img class="logo-image" src="../img/kocote.png"></a></td>
                        <td class="face"><img class="login-image" src="../img/login.jpg"></td>
                        <td class="name"><p class="login-name"><?php echo $name_login; ?></p></td>
                        <td class="logout"><form id="logoutForm" name="logoutForm" action="../logout.php" method="POST">
                                <input id="logout-botton" type="submit" id="logout" name="formname" value="ログアウト" >
                            </form></td>
                    </tr>
                </table>
            </div>

            <form id="loginForm" name="loginForm" action="" method="POST">
                <!-- <?php echo $errorMessage ?> -->

                <br>
            </form>

            <!-- 本体start -->
            <?php
            $user_id = $_POST ['user_id'];
            if (empty($user_id)) {
                header("LOCATION: ./mypage.php");
            }

            // MySQLと接続
            $link = mysql_connect('localhost', 'root', 'root');
            // データベースを選択
            $dbLink = mysql_select_db('greenbakari', $link);

            mysql_set_charset('utf8');

            // データ更新
            if (isset($_POST ['gakka']) && isset($_POST ['interest']) && isset($_POST ['jikoshokai'])) {
                $sql = 'UPDATE UA SET DEPARTMENT_NAME="' . $_POST ['gakka'] . '", INTEREST="' . $_POST ['interest'] . '" , PROFILE="' . $_POST ['jikoshokai'] . '" WHERE USER_ID = ' . $user_id;
                $result = mysql_query($sql);
                if (!$result) {
                    print ("SQLの実行に失敗しました<BR>");
                    print (mysql_errno() . ": " . mysql_error() . "<BR>");
                    exit();
                }
            }

            if (file_exists('uploaded_header' . $user_id . '.jpg')) {
                $fp = fopen("uploaded_header" . $user_id . ".jpg", "rb");
                $imgdata = fread($fp, filesize("uploaded_header" . $user_id . ".jpg"));
                fclose($fp);
                $str = mb_convert_encoding($imgdata, "UTF-8");
                $header_imgdata = addslashes($imgdata);
                if (!$sql_result_ua_update_header = mysql_query('UPDATE UA SET HEADER_IMAGE="' . $header_imgdata . '" WHERE USER_ID = ' . $user_id))
                    die('@ua, HEADER_IMAGEテーブル UPDATE失敗' . mysql_error());
                unlink("uploaded_header" . $user_id . ".jpg");
            }

            if (file_exists('uploaded_icon' . $user_id . '.jpg')) {
                $fp = fopen("uploaded_icon" . $user_id . ".jpg", "rb");
                $imgdata = fread($fp, filesize("uploaded_icon" . $user_id . ".jpg"));
                fclose($fp);
                $str = mb_convert_encoding($imgdata, "UTF-8");
                $icon_imgdata = addslashes($imgdata);
                if ($icon_imgdata != "" && !$sql_result_ua_update_icon = mysql_query('UPDATE UA SET ICON_IMAGE="' . $icon_imgdata . '" WHERE USER_ID = ' . $user_id))
                    die('@ua, ICON_IMAGEテーブル UPDATE失敗' . mysql_error());
                unlink("uploaded_icon" . $user_id . ".jpg");
            }

            print ("登録が完了しました。");
            echo '<br><a href="mypage.php">マイページへ</a>';
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
