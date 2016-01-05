<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="style.css"　type="text/css">
<body topmargin="100" bottommargin="100">

<div id="headerArea"></div>
<div id="footerArea"></div>

<form id="loginForm" name="loginForm" action="" method="POST">

  <div id = "box">
    <a href="http://localhost/php/v0/event.php"><img src="img/ev_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/bulletin.php"><img src="img/bb_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/search.php"><img src="img/se_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/dm.php"><img src="img/dm_home.jpg" height="7%" width="16%"></a>
    <a href="http://localhost/php/v0/mypage.php"><img src="img/mp_home.jpg" height="7%" width="16%"></a></div>
  <br><br><br>

<label for="event_title" style="margin-left:-10%">掲示板タイトル*：</label>
<input type="text" id="event_title" name="event_title"="">
<br><br><br>

<label for="time" style="margin-left:-7%">分類*：</label>
<select name="time">
<option value="全て">全て</option>
<option value="グルメ/フェスティバル">グルメ/フェスティバル</option>
<option value="芸術/エンタメ">芸術/エンタメ</option>
<option value="交流/スポーツ">交流/スポーツ</option>
<option value="地域復興/福祉">地域復興/福祉</option>
<option value="就活/キャリア">就活/キャリア</option>
</select><br><br><br>

<label for="event_comment" align="left" style="margin-left:-2%">作成者コメント*：</label>
<textarea name="event_comment" rows="7" cols="40"></textarea>
<br><br><br>

<input type="reset" id="delete" name="delete" value="クリアする">
<input type="submit" id="edit_conf" name="edit_conf" value="確認画面へ進む">

</body>
</center>
</html>
