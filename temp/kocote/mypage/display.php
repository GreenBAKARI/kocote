<?php
session_start();
$user_id = $_SESSION['user_id'];
if (empty($user_id)) {
    header("LOCATION: ../login.php");
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>マイページ画像表示</title>
    </head>
    <body>
        <form method="POST" action="display.php">
            <P>画像の表示</P>
            ID：<input type="text" name="id">
            <input type="submit" name="submit" value="送信">
            <br><br>
        </form>

        <?php
        if (count($_POST) > 0 && isset($_POST["submit"])) {
            $id = $_POST["id"];
            if ($id == "") {
                print("IDが入力されていません。<br>\n");
            } else {
                print("<img src=\"./img_get.php?id=" . $id . "\">");
            }
        }
        ?>
    </body>
</html>