<html>
  <head>
  <meta charset="UTF-8">
  <title>高知県大学生用交流サイト「KoCo + Te」</title>
  </head>
  <link rel="stylesheet" href="login_style.css"　type="text/css">
  <body topmargin="100" leftmargin="200" rightmargin="200 "bottommargin="100">
  <form id="loginForm" name="loginForm" action="" method="POST">

  <!-- <?php echo $errorMessage ?> -->
  <p>
  <img src="img/logo.jpg" id="logo" height="30%" >
  <label id="title">ログイン</label><br><br><br>
  <label for="mailaddress">メールアドレス</label>
  <input type="text" id="mailaddess" name="mailaddress"="">
  <br><br>

  <label for="password">パスワード</label>
  <input type="password" id="password" name="password" value="">
  <br><br>

  <input type="checkbox" id="loginstatus" name="loginstatus" value="">
  <label for="loginstatus">ログイン状態を保存する</label>
  <br><br>
  <input type="submit" id="login" name="login" value="ログイン">

  <br><br><br><br><br><br>
  </p>
  </form>

  <form id="acountaddForm" name="acountaddForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->
  <label id="title">アカウント登録</label><br><br><br>
  <label for="username">名前：</label>
  <input type="text" id="usernamelast" name="usernamelast"="" placeholder="姓" value="">
  <input type="text" id="usernamefirst" name="usernamefirst"="" placeholder="名" value="">
  <br><br>

  <input type="text" id="usernamelast" name="usernamelast"="" placeholder="ローマ字(姓)" value="">
  <input type="text" id="usernamefirst" name="usernamefirst"="" placeholder="ローマ字(名)" value="">
  <br><br>

  <label for="password">パスワード：</label>
  <input type="password" id="password" name="password" value="">
  <br><br>

  <label for="passwordconf">パスワード確認用：</label>
  <input type="password" id="passwordconf" name="passwordconf" value="">
  <br><br>

  <label for="mailaddress">メールアドレス：</label>
  <input type="text" id="mailaddress" name="mailaddress" value="">
  <br><br>

  <label for="sex">性別：</label>
  <input type="radio" id="sex" name="sex">男性
  <input type="radio" id="sex" name="sex">女性
  <br><br>

  <label for="college">大学：</label>
  <select name="college">
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

  <input type="submit" id="acountadd" name="acountadd" value="アカウント登録">
  </form>
  </body>
</html>
