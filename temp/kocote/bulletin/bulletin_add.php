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

            <!--作成されている掲示板の総数の取得 -->
            <?php
            //DB情報
            $db = "greenbakari";
            $host = "localhost";
            $user = "root";
            $pass = "root";

            $table = "BB";
            $category = "category";
            ?>

            <?php
            $pdo = new PDO("mysql:dbname=$db;charset=utf8", "root", "root");
            $st_all = $pdo->query("SELECT * FROM $table");
            $st_all->execute();
            $all_rows = $st_all->rowCount();
            ?>

            <!-- 現在時刻の取得 -->
            <?php
            date_default_timezone_set('Asia/Tokyo');
            $time = date('Y-m-d H:i:s');
            ?>

            <!--最終IDの取得-->
            <?php
            $link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");
            $sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
            $sql = "SELECT BB_ID FROM BB WHERE BB_ID = (SELECT max(BB_ID) FROM BB)";
            $result_last_id = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
            $last_id = mysql_result($result_last_id, 0);
            mysql_close($link) or die("MySQL切断に失敗しました。");
            ?>


            <!--スレ立て(bbテーブルにinsert)-->
            <?php
            $comment_count = 0;
            $next_id = $last_id + 1;
            $pdo = new PDO("mysql:dbname=$db;charset=utf8", "$user", "root");
            $st = $pdo->prepare("INSERT INTO $table VALUES(?,?,?,?,?,?,?)");
            $st->execute(array($next_id, $user_id, $_POST['bb_name'], $_POST['category'], $comment_count, $time, $time));
            ?>

            <!--pfテーブル作成-->
            <?php
            $dbname = "$db"; // DB名
            $tbname = "PF" . $next_id; // テーブル名
            // MYSQL接続
            $db = mysql_connect($host, $user, $pass) or die("MYSQLへの接続に失敗しました");
            // DB選択
            mysql_select_db($dbname, $db) or die("DB選択に失敗しました");
            // テーブル情報取得
            $result = mysql_query("SHOW TABLES", $db) or die("テーブル取得に失敗しました");
            // テーブル名チェック
            while ($row = mysql_fetch_assoc($result)) {
                if ($row["Tables_in_" . $dbname] == $tbname)
                    exit($tbname . "は存在します。");
            }

            // テーブル作成
            $sql = "CREATE TABLE " . $tbname . " (BB_ID int not null, USER_ID int not null, COMMENT_NUM int, POSTED_CONTENT text, POSTED_DATE datetime)";
            mysql_query($sql, $db) or die("テーブル作成に失敗しました");

            //コメントinsert(pfテーブルにinsert)
            //コメント未入力の場合は掲示板のみ作成
            $comment = $_POST['make_comment'];
            if (empty($comment)) {
                //echo "コメント未入力で作成/ ";
            } else {
                //echo "コメント入力で作成(コメント内容：$comment)/ ";
                $comment_count = 1;
                $st_com = $pdo->prepare("INSERT INTO $tbname VALUES(?,?,?,?,?)");
                $st_com->execute(array($next_id, $user_id, $comment_count, $comment, $time));
            }

            print("掲示板「" . $_POST['bb_name'] . "」を作成しました。");
            ?>
            <br>
            <a href="bulletin.php">掲示板一覧へ</a>
            
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
