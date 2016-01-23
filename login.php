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
      mysql_set_charset('utf8');
      //関数定義
      $session_id=0;
      $user_id=0;
      $user_last_name="";
      $user_first_name="";
      $user_last_roma="";
      $user_first_roma="";
      $sex="";
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
          header("Location: index.php");
       }
    if (isset($_COOKIE["user_id"])){
        $_SESSION["user_id"]=$_COOKIE["user_id"];
        header("Location: index.php");
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
       header("Location: index.php");//ログインする
       }
       else{
        echo "<a class=error>パスワードまたはメールアドレスが違います</a>";
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
          echo "<a class=error2>「名前」</a>";
        }

        if(isset($_POST["sex"])){
          $sex = htmlspecialchars($_POST["sex"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "<a class=error2>「性別」</a>";
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
          echo "<a class=error2>「大学」</a>";

        }
        if(isset($_POST["grade"]) && !(htmlspecialchars($_POST["grade"], ENT_QUOTES)==0) ){
          $grade = htmlspecialchars($_POST["grade"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "<a class=error2>「学年」</a>";
        }
        if(isset($_POST["mail_address"])&& !(htmlspecialchars($_POST["mail_address"], ENT_QUOTES) == "")){
          $mail_address = htmlspecialchars($_POST["mail_address"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "<a class=error2>「メールアドレス」</a>";
        }
        if(isset($_POST["password"]) && !(htmlspecialchars($_POST["password"], ENT_QUOTES)==null)){
          $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
        }else{
          $flg=false;
          echo "<a class=error2>「パスワード」</a>";
        }
        if(isset($_POST["password_conf"]) && !(htmlspecialchars($_POST["password_conf"], ENT_QUOTES)==null)){
            $password_conf = htmlspecialchars($_POST["password_conf"], ENT_QUOTES);
        }else{
            $flg=false;
            echo "<a class=error2>「パスワード確認」</a>";
        }
      }
      $mail_conf="SELECT USER_ID FROM UR WHERE MAIL_ADDRESS = '$mail_address'";
      $mail_result = mysql_query($mail_conf, $link);

    if($flg==false||($nameflg==false&&$romaflg==false)){//もし未入力部分があれば。。。
        echo "<a class=error2>が未入力です。</a>";
    }else if($password!=$password_conf){
        echo "<a class=error2>パスワードとパスワード確認が異なっています。</a>";
    }else if(!preg_match(//メールアドレスが正しいか
        '/^[a-z0-9][a-z0-9_¥.¥-]*@[a-z0-9][a-z0-9_¥.¥-]+[a-z]$/i',
        $mail_address)) {
      echo "<a class=error2>不正なメールアドレスです。</a>";
    }else if (strpos($mail_address,'@ugs.kochi-tech.ac.jp')===false &&strpos($mail_address,'@kochi-u.ac.jp')===false && strpos($mail_address,'@u-kochi.ac.jp')===false){
      echo "<a class=error2>高知県内の大学のメールアドレスではありません</a>";
    }else if (mysql_num_rows($mail_result) >= 1){//既に登録されているメールアドレスか
      echo "<a class=error2>既に登録されているメールアドレスです。</a>";
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

  <title>ログイン</title>
  </head>
    <!-- cssのパス -->
    <link rel="stylesheet" href="css/lo_style.css"　type="text/css">
    <body>
    <!-- <?php echo $errorMessage ?> -->
  <p>
    <!-- ロゴ画像のパス -->
  <div id =sub>
  <img src="img/kocote.png" id="logo">
  <!--
  <p><font size="5" color="#ffffff">KoCo+Teとは・・・</font></p>
  <p><font size="5" color="#ffffff"><u>K</u>ochi <u>Co</u>llege + <u>T</u>asty <u>e</u>vent</font></p>
  -->
  </div>


  <div id="form-login">
  <form id="loginForm" name="loginForm" action="login.php" method="POST">
        <table id=login_table>
            <tr><td><p id =title>ログイン</p></td></tr>
            
            <tr><td id="content_name"><div class="form-item"><input type="text" id="mail_address" placeholder="Mail Address" name="mail_address"="<?php echo $mail_address;?>"></div></td></tr>
            
            <tr><td id="content_name"><div class="form-item"><input type="password" id="password" name="password" value="" placeholder="Password"></div></td></tr>

            <tr><td  id="title_name" colspan="2"><input type="checkbox" id="loginstatus" name="loginstatus" value="true">
            <div id=moji>ログイン状態を保持する</div></td></tr>
            
            <tr>
            <input type="hidden" name="mode" value="login">
            <td id="title_name" colspan="2"><div class="botton-panel"><input type="submit" id="login" name="formname" value="ログイン" ></div></td>
            </tr>
        </table>
</form>
</div>
  
<div id="form-clear">
</div>
  
  <br><br><br><br><br>
  <hr>

  <div id="form-reg">
<form id="acountaddForm" name="acountaddForm" action="login.php" method="POST">
  <p id =title>アカウント登録</p>
  <table id=add_table>
  <tr>
    <td id=title_name><p id =moji>名前(日本語)：</p></td>
    <td id=content_name><div class="form-item2"><input pattern="[^\x20-\x7E]*" type="text" id="usernamelast" name="user_last_name" placeholder="日本語(姓)" value="<?php echo $user_last_name;?>">
       <input pattern="[^\x20-\x7E]*" type="text" id="usernamefirst" name="user_first_name" placeholder="日本語(名)" value="<?php echo $user_first_name;?>"></div></td>
  </tr>
  <tr>
    <td id=title_name><p id =moji>名前(ローマ字)：</p></td>
    <td id =content_name><div class="form-item2"><input pattern="^[0-9A-Za-z]+$" type="text" id="usernamelast1" name="user_last_roma" placeholder="ローマ字(姓)" value="<?php echo $user_last_roma;?>">
    <input pattern="^[0-9A-Za-z]+$" type="text" id="usernamefirst1" name="user_first_roma" placeholder="ローマ字(名)" value="<?php echo $user_first_roma;?>"></div></td>
  </tr>
  <tr>
      <td></td>
      <td id =content_name><p id="moji">日本語もしくはローマ字どちらかの入力のみで可</p></td>
  </tr>
  <tr>
    <td id =title_name><p id=moji>パスワード：</p></td>
    <td id =content_name><div class="form-item2"><input type="password" id="password" name="password" value=""></div></td>
  </tr>
  <tr>
  <td id =title_name><p id =moji>パスワード確認：</p></td>
  <td id =content_name><div class="form-item2"><input type="password" id="passwordconf" name="password_conf" value=""></div></td>
  </tr>
  <tr>
  <td id =title_name><p id=moji>メールアドレス：</p></td>
  <td id =content_name><div class="form-item2"><input type="text" id="mail_address" name="mail_address" value="<?php echo $mail_address;?>"></div></td>
  </tr>

  <tr>
    <td id = title_name> <p id =moji>性別：</p></td>
    <td id= content_name> <input type="radio" id="sex" name="sex"value="m"><p id=seibetsu>男性</p>
    <input type="radio" id="sex" name="sex"value="f"><p id=seibetsu>女性</p></td>
  </tr>
  <tr>
    <td id=title_name><p id =moji>大学：</p></td>
    <td id=content_name><select name="college_name">
      <option value="0">---------------</option>
      <option value="1">高知大学</option>
      <option value="2">高知県立大学</option>
      <option value="3">高知工科大学</option>
    </select></td>
  </tr>
  <tr>
    <td id=title_name><p id=moji>学年：</p></td>
    <td id =content_name><select name="grade">
      <option value="0">----------</option>
      <option value="1">学部1年</option>
      <option value="2">学部2年</option>
      <option value="3">学部3年</option>
      <option value="4">学部4年</option>
      <option value="5">修士1年</option>
      <option value="6">修士2年</option>
    </select></td>
  </tr>
  <tr>
      <td></td>
  	<td id=title_name><input type="hidden" name="mode" value="add">
    <input type="submit" id="acountadd" name="formname" value="アカウント登録"></td>
    
  </tr>
</table>
</form>
  </div>

  
</body>
</html>
