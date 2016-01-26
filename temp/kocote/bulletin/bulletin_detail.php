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
    <div id ="header"></div>
    <meta charset="UTF-8">
    <title>掲示板詳細</title>
</head>
<center>
    <link rel="stylesheet" href="../css/style.css"　type="text/css">
    <link rel="stylesheet" href="../css/bb_style.css"　type="text/css">

    <body  topmargin="100" bottommargin="100">

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

</center>
</div>
<br>

<!--float解除-->
<div class="clear"></div>

<!-- 投稿コメント一覧の取得&表示とDB情報-->
<?php
//DB情報
$db = "greenbakari";
$host = "localhost";
$user = "root";
$pass = "root";

$bb_id = $_GET['bb_id'];
$table_name = "PF" . $bb_id;
?>

<center>
    <!--掲示板タイトル取得 -->
    <?php
    $link = mysql_connect("$host", "$user", "$pass") or die("MySQLへの接続に失敗しました。");
    $sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
    mysql_set_charset('utf8');
    $sql = "SELECT BB_NAME FROM BB WHERE BB_ID = $bb_id";
    $result_name = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
    $title = mysql_result($result_name, 0);
    mysql_close($link) or die("MySQL切断に失敗しました。");
    ?>
    <!-- 掲示板タイトル-->
    <h2 class="bulletin-title"><div align="center"><?php echo $title; ?></div></h2>

    <!--コメント数取得 -->
    <?php
    $link = mysql_connect("$host", "$user", "$pass") or die("MySQLへの接続に失敗しました。");
    $sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
    $sql = "SELECT COUNT(*) FROM $table_name";
    $result_comment_num = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
    $comment_num = mysql_result($result_comment_num, 0);
    mysql_close($link) or die("MySQL切断に失敗しました。");

    print("<div align='right' style='margin-right:240px'>全部で" . $comment_num . "件のコメントがあります。<a href=\"#post_form\">投稿フォームへ</a></div>");
    ?>

    <!--コメント数更新-->
    <?php
    $link = mysql_connect("$host", "$user", "$pass") or die("MySQLへの接続に失敗しました。");
    $sdb = mysql_select_db("$db", $link) or die("データベースの選択に失敗しました。");
    $sql = "UPDATE BB SET COMMENT_COUNT = $comment_num WHERE BB_ID = $bb_id";
    $result_comment_update = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
    mysql_close($link) or die("MySQL切断に失敗しました。");
    ?>

    <!-- コメント中にURLがあるか判定(http://www.phppro.jp/qa/688より)-->
    <?php

    function autoLinker($str) {
        $pat_sub = preg_quote('-._~%:/?#[]@!$&\'()*+,;=', '/'); // 正規表現向けのエスケープ処理
        $pat = '/((http|https):\/\/[0-9a-z' . $pat_sub . ']+)/i'; // 正規表現パターン
        $rep = '<a href="\\1">\\1</a>'; // \\1が正規表現にマッチした文字列に置き換わります
        $str = preg_replace($pat, $rep, $str); // 実処理
        return $str;
    }
    ?>


    <!-- 掲示板詳細の表組 -->
    <form>
        <table class="bb_detail" rules="all">
            <?php
            $url = 0; //変数初期化
            $res_num = 1; //返信番号用
            $pdo = new PDO("mysql:dbname=$db;charset=utf8", "$user", "$pass");

            $roma_switch = 0;
            $st = $pdo->query("SELECT COMMENT_NUM, BB_ID, USER_LAST_NAME, USER_FIRST_NAME, POSTED_DATE, $table_name.USER_ID, POSTED_CONTENT FROM UR, $table_name WHERE UR.USER_ID = $table_name.USER_ID ORDER BY COMMENT_NUM");

            //抽出結果を変数に格納
            while ($row = $st->fetch()) {
                // $roma_switch=$row['roma_switch'];
                if ($roma_switch == 1) {
                    $last_name = htmlspecialchars($row['USER_LAST_NAME_ROMA']);
                    $first_name = htmlspecialchars($row['USER_FIRST_NAME_ROMA']);
                } else {
                    $last_name = htmlspecialchars($row['USER_LAST_NAME']);
                    $first_name = htmlspecialchars($row['USER_FIRST_NAME']);
                }
                $bb_id = htmlspecialchars($row['BB_ID']);
                $user_id = htmlspecialchars($row['USER_ID']);
                $comment_num = htmlspecialchars($row['COMMENT_NUM']);
                $posted_content = htmlspecialchars($row['POSTED_CONTENT']);
                $posted_date = htmlspecialchars($row['POSTED_DATE']);
                //コメントの改行、URL処理
                $posted_content = nl2br($posted_content);
                $posted_content = autoLinker($posted_content);

                if ($user_id == $_SESSION['user_id']) {
                    $url = "http:../mypage/mypage.php";
                } else {
                    $url = "http:../mypage/parsonalpage.php?user_id=$user_id";
                }

                //詳細表示
                echo "
    <tr>
    <td class=\"top_cell\">$comment_num:&nbsp;<a class=\"user\" href=\"$url\">$last_name $first_name</a>&nbsp;&nbsp; $posted_date &nbsp;&nbsp; ID:$user_id</td>
    </tr>
    <tr>
    <td class=\"middle_cell\">$posted_content</td>
    </tr>
    <tr>
    <td class=\"under_cell\"><input type=\"button\" name=\"$res_num\" id=\"SELECT\" onclick=\"res(this)\" value=\"返信\"></td>
    </tr>";
                $res_num = $res_num + 1;
            }
            ?>

    </form>

</table>

<a href="#header">ページトップへ</a>
<br><br><br>

<!-- 返信ボタン押下時の処理 -->
<!-- 押したら投稿フォームへジャンプ-->
<?php
echo <<<EOM
<script type="text/javascript">
    function res(obj){
        var num;
        var str;
        num = obj.name;
        str = ">>" + num + "  ";
        document.getElementById("text").value = str ;
        location.hash='post_form'; return false;
    }
</script>
EOM;
?>

<!--コメント投稿フォーム-->
<a name="post_form"></a>
<form method = "POST" action="bulletin_write.php">
    <label for="title"> コメント：</label>
    <textarea id="text" wrap="hard" name = "posted_content"  required = "required" cols = "110"  rows = "5"></textarea>
    <input type="hidden" name = "id" value = "<?php echo $bb_id; ?>">
    <br><br>
    <input type="reset" id="delete" name="delete" value="クリア">
    <input type="submit" name="btn" value="書き込む">
</form>
</center>

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
