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
        <title>掲示板詳細</title>
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

            <!-- コメント投稿処理 -->
            <?php
            //DB情報
            $db = "greenbakari";
            $host = "localhost";
            $user = "root";
            $pass = "root";
            //ユーザ情報
            $user_id = $_SESSION[user_id];

            //table情報
            $comment_count = 0;
            $comment = $_POST['posted_content'];
            $bb_id = $_POST['id'];
            $table = "PF" . $bb_id;
            ?>

            <!--コメント数取得 -->
            <?php
            $link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");
            $sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
            $sql = "SELECT COUNT(*) FROM $table";
            $result_comment_num = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
            $comment_num = mysql_result($result_comment_num, 0);
            mysql_close($link) or die("MySQL切断に失敗しました。");
            $next_com_num = $comment_num + 1;
            ?>

            <!-- 現在時刻の取得 -->
            <?php
            date_default_timezone_set('Asia/Tokyo');
            $time = date('Y-m-d H:i:s');
            ?>

            <!--コメント投稿(pfテーブルにinsert)-->
            <?php
            //SQL発行
            $pdo = new PDO("mysql:dbname=$db;charset=utf8", $user, $pass);
            $st = $pdo->prepare("INSERT INTO $table VALUES(?,?,?,?,?)");
            $st->execute(array($bb_id, $user_id, $next_com_num, $comment, $time));
            ?>


            <?php
            print("投稿しました。");
            ?>

            <!--コメント数と投稿時間更新-->
            <?php
            $link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");
            $sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");
            $sql = "UPDATE BB SET COMMENT_COUNT = $comment_num, LAST_POSTED_DATE = '$time' WHERE BB_ID = $bb_id";
            $result_comment_update = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
            mysql_close($link) or die("MySQL切断に失敗しました。");
            ?>

            <a href="bulletin_detail.php?bb_id=<?php echo $bb_id ?>">掲示板へ</a>
            
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
