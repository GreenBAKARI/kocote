<?php

session_start();

if (!(isset($_SESSION["user_id"]))) {
    header("Location:login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {//ログアウト処理
    if (isset($_COOKIE["user_id"])) {
        setcookie("user_id", $_SESSION["user_id"], time() - 259200);
    }
    session_destroy();
    header("Location: login.php");
}

?>
