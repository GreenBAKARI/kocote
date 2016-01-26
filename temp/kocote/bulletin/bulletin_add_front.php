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

<!-- 掲示板作成フォーム-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>掲示板作成</title>
    </head>
    <center>
        <link rel="stylesheet" href="../css/style.css"　type="text/css">
        <link rel="stylesheet" href="../css/bb_style.css"　type="text/css">

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

            <!-- 機能選択ボタン -->
            <div id="box">
                <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
                <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
                <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
                <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a></div>
            <br>
            <br>  

            <p class="error">* 印は必須項目です。</p>

            <!-- 作成フォームここから -->
            <form action="bulletin_add.php" method="post">
                <div>
                    <table class="bulletin-add">
                        <tr>
                            <td class="title">掲示板タイトル*：</td>
                            <td><input type="text" size="80" name="bb_name" required = "required"></td>
                        </tr>
                        <tr>         
                            <td class="title">分類*：</td>
                            <td><select name="category" required = "required">
                                    <option value="">-------------------------</option>
                                    <option value="グルメ/フェスティバル">グルメ/フェスティバル</option>
                                    <option value="芸術/エンタメ">芸術/エンタメ</option>
                                    <option value="交流/スポーツ">交流/スポーツ</option>
                                    <option value="地域振興/福祉">地域振興/福祉</option>
                                    <option value="就活/キャリア">就活/キャリア</option>
                                    <option value="その他">その他</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="title">投稿者コメント：</td>
                            <td><textarea name = "make_comment"  placeholder="記入した場合、このコメントが1レス目になります。" cols = 45 rows = 4></textarea></td>
                        </tr>
                    </table>
                </div>

                <input type="reset" id="delete" name="delete" value="クリア">
                <input type="submit" id="makebulletin" name="makebulletin" value="作成する">

            </form>

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
