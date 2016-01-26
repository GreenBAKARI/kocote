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

                <!-- 機能選択ボタン -->
                <div id="box">
                    <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
                    <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
                    <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
                    <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a></div>
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
            if (!$link)
                die('データベース接続失敗' . mysql_error());

            // データベースgreenbakariを選択
            $db_selected = mysql_select_db('greenbakari', $link);
            if (!$db_selected)
                die('データベース選択失敗' . mysql_error());

            // クエリの発行
            mysql_set_charset('utf8');
            if (!$sql_result_ua_select = mysql_query('SELECT * FROM UA WHERE USER_ID=' . $user_id))
                die('@uaテーブル SELECT失敗' . mysql_error());
            if (!$sql_result_ur_select = mysql_query('SELECT * FROM UR WHERE USER_ID=' . $user_id))
                die('@urテーブル SELECT失敗' . mysql_error());


            echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
            // user_id をmypage_conf.phpに伝播
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            // 画像
            $ua = mysql_fetch_assoc($sql_result_ua_select);
            // ヘッダ画像
            if (move_uploaded_file($_FILES ['header_img'] ['tmp_name'], 'uploaded_header' . $user_id . '.jpg')) {
                echo '<img src="uploaded_header' . $user_id . '.jpg" class="header-img">';
            } else {
                echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=HEADER_IMAGE&img_table=ua" class="header-img">';
            }

            // アイコン画像
            if (move_uploaded_file($_FILES ['icon_img'] ['tmp_name'], 'uploaded_icon' . $user_id . '.jpg')) {
                echo '<img src="uploaded_icon' . $user_id . '.jpg" class="icon-img" style="position:absolute;left:280px;top:400px;">';
            } else {
                echo '<img src="./img_get.php?user_id=' . $user_id . '&img_type=ICON_IMAGE&img_table=ua" class="icon-img" style="position:absolute;left:280px;top:400px;">';
            }

            // 「確定する」ボタン
            echo '<input id="title3" type="submit" value="確定する" name="upload">';
            // 「編集する」ボタン
            echo '<input id="title4" "type="button" value="編集する" name="edit" onClick="history.back()">';

            /* ▽ 名前・性別 ▽ */
            /* 名前 */
            echo '<table class="conf-table">';
            echo '<tr>';
            $ur = mysql_fetch_assoc($sql_result_ur_select);
            echo ("<td class=\"user-size\">" . $ur ['USER_LAST_NAME'] . " " . $ur ['USER_FIRST_NAME'] . "	");

            echo "</td></tr><br>";

            /* ▽ 大学・学年・学科 ▽ */
            /* 大学・学年・学科 */
            echo "<tr><td class=\"name-size\">" . $ur ["COLLEGE_NAME"] . " " . $_POST ['gakka'] . " " . $_POST ['grade'] . "</td></tr><br>";
            echo '<input type="hidden" name="gakka" value="' . $_POST ['gakka'] . '">';
            /* ▽ 興味・関心のある分野 ▽ */
            echo ("<tr><td class=\"name-size2\">興味・関心のある分野" . "</td></tr>");
            $interest = array(
                "アニメ",
                "映画 ",
                "音楽 ",
                "カメラ",
                "グルメ",
                "ゲーム",
                "スポーツ",
                "釣り ",
                "天体観測",
                "動物 ",
                "読書 ",
                "乗り物",
                "ファッション",
                "漫画 ",
                "料理 ",
                "旅行 "
            );

            $tf = "";
            for ($i = 0; $i < $_POST ['key']; $i ++) {
                $tf = $tf . "f";
            }

            echo '<tr><td class="space3">';
            if (isset($_POST ['interest'])) {
                foreach ($_POST ['interest'] as $key => $value) {
                    $tf [$value] = "t";
                    echo "・", $interest [$value] . "　";
                    // 4行ごとに改行
                    if (!(($key + 1) % 4))
                        echo '<br>';
                }
            } else {
                echo '登録されていません';
            }

            echo '<input type="hidden" name="interest" value="' . $tf . '">';
            echo ("</td></tr>");

            /* ▽ 自己紹介 ▽ */
            echo '<tr><td class="name-size2">' . "自己紹介" . "</td></tr>";
            echo '<tr><td class="space">';

            if ($_POST['jikoshokai'] != "") {
                echo '<p>' . $_POST ['jikoshokai'] . '</p>';
            } else {
                echo '登録されていません';
            }
            echo '<input type="hidden" name="jikoshokai" value="' . $_POST ['jikoshokai'] . '">';
            echo '</td></tr>';
            echo '<br><br><br><br><br><br><br><br><br><br><br><br><br>';
            echo '</table>';
            ?>

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
</html>
