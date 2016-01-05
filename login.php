<?php
session_start();
    $link = mysql_connect('localhost', 'root', 'root');
        if (!$link) {
           die('接続失敗です。' .mysql_error());
         }
      //  データベーすの名前
      $db_selected = mysql_select_db('greenbakari', $link);
        if (!$db_selected) {
           die('データベース選択失敗です。'.mysql_error());
         }
      $session_id=0;
      mysql_set_charset('utf8');
      $user_id=0;
      $user_last_name="";
      $user_first_name="";
      $user_last_roma="";
      $user_first_roma="";
      $SEX="";
      $college_name="";
      $grade=0;
      $mail_address="";
      $password="";
      $password_conf="";
      $loginstatus="false";
      $mode="";
      $flg=true;
      $nameflg=true;
      $romaflg=true;
    if(isset($_SESSION["user_id"])){//セッションIDが既に登録されている場合ログインを省略する
          header("Location: home.php");
       }
    if (isset($_COOKIE["user_id"])){
        $_SESSION["user_id"]=$_COOKIE["user_id"];
        header("Location: home.php");
   }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {//ログイン処理か会員登録処理かを判断する変数modeの取得
       $mode= htmlspecialchars($_POST["mode"], ENT_QUOTES);
     }
    if($mode == "login"){//ログイン処理
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $mail_address = htmlspecialchars($_POST["mail_address"], ENT_QUOTES);
       $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
       }
       $sql="SELECT USER_ID FROM LA WHERE MAIL_ADDRESS = '$mail_address' AND PASSWORD ='$password'";
       $result = mysql_query($sql, $link);

       if(mysql_num_rows($result)==1){//メールアドレス、パスワードからユーザIDを取得できたら、、、
       $row = mysql_fetch_row($result);
       $user_id=$row[0];
       $_SESSION["user_id"]=$user_id;
       if(isset($_POST["loginstatus"])){
         setcookie("user_id",$user_id,time()+259200);
       }
       header("Location: home.php");//ログインする
       }
       else{
        echo "パスワードまたはメールアドレスが違います";
       }

      }
    elseif($mode =="add"){//会員登録処理
      if ($_SERVER["REQUEST_METHOD"] == "POST") {//フォーム送信から各情報を変数に格納
        if(isset($_POST["user_last_name"])&& !(htmlspecialchars($_POST["user_last_name"], ENT_QUOTES) == "")){
          $user_last_name = htmlspecialchars($_POST["user_last_name"], ENT_QUOTES );
        }else{
          // $flg= false;
          $nameflg=false;
        }
        if(isset($_POST["user_first_name"])&& !(htmlspecialchars($_POST["user_first_name"], ENT_QUOTES) == "")){
          $user_first_name = htmlspecialchars($_POST["user_first_name"], ENT_QUOTES);
        }else{
          // $flg=false;
          $nameflg=false;
        }

        if(isset($_POST["user_last_roma"])&& !(htmlspecialchars($_POST["user_last_roma"], ENT_QUOTES) == "")){
          $user_last_roma = htmlspecialchars($_POST["user_last_roma"], ENT_QUOTES);
        }else{
          // $flg=false;
          $romaflg=false;
        }
        if(isset($_POST["user_first_roma"])&& !(htmlspecialchars($_POST["user_first_roma"], ENT_QUOTES) == "")){
          $user_first_roma = htmlspecialchars($_POST["user_first_roma"], ENT_QUOTES);
        }else{
          // $flg=false;
          $romaflg=false;
        }
        if($nameflg==false&&$romaflg==false){
          echo "姓,名,ローマ字(姓)，ローマ字(名)，";
        }

        if(isset($_POST["sex"])){
          $sex = htmlspecialchars($_POST["sex"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "性別，";
        }
        if(isset($_POST["college_name"]) && !(htmlspecialchars($_POST["college_name"], ENT_QUOTES)==0) ){
          $college_name = htmlspecialchars($_POST["college_name"], ENT_QUOTES);
          switch($college_name){
            case 1: $college_name="高知大学";
                    break;
            case 2: $college_name="高知県立大学";
                    break;
            case 3: $college_name="高知工科大学";
                    break;
            default: break;
                   }
        }else{
          $flg=false;
          echo "大学，";

        }
        if(isset($_POST["grade"]) && !(htmlspecialchars($_POST["grade"], ENT_QUOTES)==0) ){
          $grade = htmlspecialchars($_POST["grade"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "学年，";
        }
        if(isset($_POST["mail_address"])&& !(htmlspecialchars($_POST["mail_address"], ENT_QUOTES) == "")){
          $mail_address = htmlspecialchars($_POST["mail_address"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "メールアドレス，";
        }
        if(isset($_POST["password"]) && !(htmlspecialchars($_POST["password"], ENT_QUOTES)==null)){
          $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "パスワード，";
        }
        if(isset($_POST["password_conf"]) && !(htmlspecialchars($_POST["password_conf"], ENT_QUOTES)==null)){
            $password_conf = htmlspecialchars($_POST["password_conf"], ENT_QUOTES);
        }else{
            $flg=false;
            echo "パスワード確認用";
        }
      }
      $mail_conf="SELECT USER_ID FROM UR WHERE MAIL_ADDRESS = '$mail_address'";
      $mail_result = mysql_query($mail_conf, $link);

    if($flg==false||($nameflg==false&&$romaflg==false)){//もし未入力部分があれば。。。
        echo "が未入力です。";
    }else if($password!=$password_conf){
        echo "パスワードとパスワード確認用の入力が違います。";
    }else if(!preg_match(//メールアドレスが正しいか
        '/^[a-z0-9][a-z0-9_¥.¥-]*@[a-z0-9][a-z0-9_¥.¥-]+[a-z]$/i',
        $mail_address)) {
      echo "不正なメールアドレスです。";
    }else if (strpos($mail_address,'@ugs.kochi-tech.ac.jp')===false &&strpos($mail_address,'@kochi-u.ac.jp')===false && strpos($mail_address,'@u-kochi.ac.jp')===false){
      echo "高知県内の大学のメールアドレスではありません";
    }else if (mysql_num_rows($mail_result) >= 1){//既に登録されているメールアドレスか
      echo "既に登録されているメールアドレスです。";
    }
      else{//データベースに会員情報を登録
        $sql="SELECT USER_ID FROM UR";
        $result = mysql_query($sql, $link);
        $user_id= mysql_num_rows($result)+1;
        // echo $user_id,$user_last_name,$user_first_name,$user_last_roma,$user_first_roma,$sex,$college_name,$grade,$mail_address,$password;
        $sql2="INSERT INTO UR (USER_ID,USER_LAST_NAME,USER_FIRST_NAME,USER_LAST_ROMA,USER_FIRST_ROMA,SEX,COLLEGE_NAME,GRADE,MAIL_ADDRESS,PASSWORD) VALUES('$user_id','$user_last_name','$user_first_name','$user_last_roma','$user_first_roma','$sex','$college_name','$grade','$mail_address','$password')";
        $result2 = mysql_query($sql2, $link);
        $sql3="INSERT INTO LA (USER_ID,MAIL_ADDRESS,PASSWORD) VALUES('$user_id','$mail_address','$password')";
        $result2 = mysql_query($sql3, $link);
        echo "登録できました。";
      }

  }

  ?>
<html>
  <head>
  <meta charset="UTF-8">

  <title>高知県大学生用交流サイト「KoCo + Te」</title>
  </head>
    <!-- cssのパス -->
    <link rel="stylesheet" href="login_style.css"　type="text/css">
    <body topmargin="100" leftmargin="200" rightmargin="200 "bottommargin="100">


  <!-- フォーム送信時の遷移先 -->
 <form id="loginForm" name="loginForm" action="login.php" method="POST">

    <!-- <?php echo $errorMessage ?> -->
  <p>
    <!-- ロゴ画像のパス -->
  <img src="img/logo.jpg" id="logo" height="30%" width="70%">
  <label id="title">ログイン</label><br><br><br>
  <label for="mail_address">メールアドレス</label>
  <input type="text" id="mail_address" name="mail_address"="<?php echo $mail_address;?>">
  <br><br>

  <label for="password">パスワード</label>
  <input type="password" id="password" name="password" value="">
  <br><br>

  <input type="checkbox" id="loginstatus" name="loginstatus" value="true">
  <label for="loginstatus">ログイン状態を保存する</label>
  <br><br>
  <input type="hidden" name="mode" value="login">
  <input type="submit" id="login" name="formname" value="ログイン" >
  <br><br><br><br><br><br>
  </p>
  </form>

  <form id="acountaddForm" name="acountaddForm" action="login.php" method="POST">
  <!-- <?php echo $errorMessage ?> -->
  <label id="title">アカウント登録</label><br><br><br>
  <label for="username">名前：</label>
  <input pattern="[^\x20-\x7E]*" type="text" id="usernamelast" name="user_last_name"="" placeholder="姓" value="<?php echo $user_last_name;?>">
  <input pattern="[^\x20-\x7E]*" type="text" id="usernamefirst" name="user_first_name"="" placeholder="名" value="<?php echo $user_first_name;?>">
  <br><br>

  <input pattern="^[0-9A-Za-z]+$" type="text" id="usernamelast1" name="user_last_roma"="" placeholder="ローマ字(姓)" value="<?php echo $user_last_roma;?>">
  <input pattern="^[0-9A-Za-z]+$" type="text" id="usernamefirst1" name="user_first_roma"="" placeholder="ローマ字(名)" value="<?php echo $user_first_roma;?>">
  <br><br>
  <label for="username">姓名もしくはローマ字どちらかの入力のみで可</label>
  <br><br>

  <label for="password">パスワード：</label>
  <input type="password" id="password" name="password" value="">
  <br><br>

  <label for="password_conf">パスワード確認用：</label>
  <input type="password" id="passwordconf" name="password_conf" value="">
  <br><br>

  <label for="mail_address">メールアドレス：</label>
  <input type="text" id="mail_address" name="mail_address" value="<?php echo $mail_address;?>">
  <br><br>

  <label for="sex">性別：</label>
  <input type="radio" id="sex" name="sex"value="m">男性
  <input type="radio" id="sex" name="sex"value="f">女性
  <br><br>

  <label for="college">大学：</label>
  <select name="college_name">
  <option value="0">-------------------</option>
  <option value="1">高知大学</option>
  <option value="2">高知県立大学</option>
  <option value="3">高知工科大学</option>
  </select>
  <br><br>

  <label for="grade">学年：</label>
  <select name="grade">
  <option value="0">------------</option>
  <option value="1">学部1年</option>
  <option value="2">学部2年</option>
  <option value="3">学部3年</option>
  <option value="4">学部4年</option>
  <option value="5">修士1年</option>
  <option value="6">修士2年</option>
  </select>
  <br><br>
  	<input type="hidden" name="mode" value="add">
<input type="submit" id="acountadd" name="formname" value="アカウント登録">
</form>
<br>
  <div id="output"></div>
  </body>
</html>
