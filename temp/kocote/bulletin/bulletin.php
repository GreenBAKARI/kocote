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
        <title>掲示板一覧</title>
    </head>
    <center>
        <link rel="stylesheet" href="../css/style.css" type="text/css">
        <link rel="stylesheet" href="../css/bb_style.css" type="text/css">

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
            <div id="box2">
                <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%"></a>
                <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%"></a>
                <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%"></a>
                <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%"></a></div>
            <br>

            <!--掲示板ジャンル選択ボタン -->
            <p class="category">カテゴリで絞る</p>
            <form class="category" action="bulletin.php" method = "post">
                <input type="submit" name="all" value="" class="cate_all"/>
                <input type="submit" name="gourmet" value="" class="cate_gf"/>
                <input type="submit" name="art" value="" class="cate_ge"/>
                <input type="submit" name="sports" value="" class="cate_ks"/>
                <input type="submit" name="welfare" value="" class ="cate_ft"/>
                <input type="submit" name="carrier" value="" class="cate_sc"/>
                <input type="submit" name="etc" value="" class="cate_etc"/>
            </form>
            <input type="button" onClick="location.href = 'bulletin_add_front.php'" class="bb_make"/>
    </center>

    <?php
    //表示する掲示板の順番番号(デフォルト)
    $seq = 3;
    ?>

    <!-- 押されたボタンに応じて並び替え番号を変更 -->
    <?php
    if ($_POST['order'] == 2) {
        $seq = 2;
    } else if ($_POST['order'] == 1) {
        $seq = 1;
    } else if ($_POST['order'] == 3) {
        $seq = 3;
    }
    ?>

    <!--ページめくり(参考にしたサイト http://okky.way-nifty.com/tama_nikki/2010/06/php-e18e.html) -->
    <?php
    //1ページあたりの表示件数
    $one_page = 15;
    ?>

    <?php
    //startパラメータ=このページの最初の行
    //startパラメータがなければ、start=0をセット
    if (isset($_GET['start']) == false) {
        $start = 0;
    } else {
        //そうでなければstartパラメータの値をstart変数にセット
        $start = $_GET['start'];
    }
    ?>

    <?php
    //データベースでクエリする最初の行にstart値をセット
    $first_rows = $start;
    //データベースでクエリする最後の行に(start値 + 1ページ当たり表示数 -1) をセット
    $last_rows = $start + $one_page - 1;
    ?>

    <?php
    //DB情報
    $db = "greenbakari";
    $host = "localhost";
    $user = "root";
    $pass = "root";

    $table = "BB";
    $category = "category";

    if (isset($_POST['all'])) {
        $category = "category";
    } else if (isset($_POST['gourmet'])) {
        $category = "'グルメ/フェスティバル'";
    } else if (isset($_POST['art'])) {
        $category = "'芸術/エンタメ'";
    } else if (isset($_POST['sports'])) {
        $category = "'交流/スポーツ'";
    } else if (isset($_POST['welfare'])) {
        $category = "'地域振興/福祉'";
    } else if (isset($_POST['carrier'])) {
        $category = "'就活/キャリア'";
    } else if (isset($_POST['etc'])) {
        $category = "'その他'";
    }

    //MySQLへ接続
    $link = mysql_connect($host, $user, $pass) or die("MySQLへの接続に失敗しました。");

    //データベースの選択
    $sdb = mysql_select_db($db, $link) or die("データベースの選択に失敗しました。");

    //クエリの送信(作成が新しい順に$one_pageページずつ取得)
    mysql_set_charset('utf8');
    switch ($seq) {
        case '1':
            $sql = "SELECT * FROM $table WHERE CATEGORY = $category ORDER BY COMMENT_COUNT DESC LIMIT $start, $one_page";
            $seq_str = "コメント数の多い順";
            //$table="sorted_table";
            break;

        case '2':
            $sql = "SELECT * FROM $table WHERE CATEGORY = $category ORDER BY LAST_POSTED_DATE DESC LIMIT $start, $one_page";
            $seq_str = "最新投稿順";
            break;

        case '3':
            $sql = "SELECT * FROM $table WHERE CATEGORY = $category ORDER BY CREATED_DATE DESC LIMIT $start, $one_page";
            $seq_str = "掲示板作成順";
            break;

        default:
            $sql = "SELECT * FROM $table ORDER BY BB_ID DESC LIMIT $start, $one_page";
    }

    $result = mysql_query($sql) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);

    //全ての行数を取得しall_rowsへ格納
    $sql_all = "SELECT * FROM $table WHERE CATEGORY = $category";
    $result_all = mysql_query($sql_all, $link) or die("クエリの送信に失敗しました。<br />SQL:" . $sql_all);
    $all_rows = mysql_num_rows($result_all);

    mysql_close($link) or die("MySQL切断に失敗しました。");
    ?>

    <br><br>

    <!-- 一覧の出力 -->
    <div align="center">
        <table class="bulletin-all">
            <tr>
                <td>全部で<?= $all_rows ?>件の掲示板があります。( 現在の並び順：<?php echo $seq_str ?> )</td>

                <!-- 掲示板の並べ方をプルダウンから選択 -->
                <td class="botton"><form class="bulletin-all" method="post" action="bulletin.php">
                        <select name="order">
                            <option value="0" selected>----------------</option>
                            <option value="1">コメント数の多い順</option>
                            <option value="2">最新投稿順</option>
                            <option value="3">掲示板作成順</option>
                        </select>
                        <input type="submit" value="変更">
                    </form></td>
            </tr>
        </table>
        <table class="bb_view" rules="all">
            <th class="category">分類</th>
            <th class="title">タイトル</th>
            <th class="comment">コメント数</th>
            <?php while (($row = mysql_fetch_array($result)) && ($first_rows <= $last_rows) && ($first_rows <= $all_rows)) { ?>
                <tr><td class="category"><?php echo ($row["CATEGORY"]); ?></td>
                    <td class="title"><a href="http:../bulletin/bulletin_detail.php?bb_id=<?php echo ($row["BB_ID"]) ?>"><?php echo ($row["BB_NAME"]); ?></a></td>
                    <td class="comment"><?php echo ($row["COMMENT_COUNT"]); ?></td>
                </tr>
                <?php
                $first_rows++;
            }
            ?>
        </table>
    </div>

    <?php
    //start値が0より大きい(=最初のページでない)ときは、前のページへのリンクを作成
    if ($start > 0) {
        ?>
        <div id = "box">
            <a href="http:../bulletin/bulletin.php?start=<?php echo ($start - $one_page) ?>"><br>[前のページ]</a>
            <?php
        } else {
            //startが0なら最初のページなので、前のページへのリンクは無し
            ?>
            <br>
            <!--前のページ-->
            <?php
        }
        ?>

        <?php
        //last_row値がクエリした全行数-1より小さければ、まだ次のページがあるということなので次ページのリンクを作成
        if ($last_rows < ($all_rows - 1)) {
            ?>
            <a href="http:../bulletin/bulletin.php?start=<?php echo ($start + $one_page) ?>">[次のページ]</a>
            <?php
        } else {
            ?>
            <!--次のページ-->
            <?php
        }
        ?>
    </div>
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

</html>
