<html>
<head>
<meta charset = "utf-8">
<title>検索画面</title>
</head>
<center>
<link rel = "stylesheet" href = "style.css"　type = "text/css">
<body topmargin = "100" bottommargin = "100">

<div style = "background-image: url(img/search_src.jpg); background-position: bottom;">

<div id = "headerArea"></div>
<div id = "footerArea"></div>
<br><br><br>

<div id = "box">
<a href = "http://localhost/event.php">
<img src = "img/ev_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/bulletin.php">
<img src = "img/bb_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/search.php">
<img src = "img/se_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/dm.php">
<img src = "img/dm_home.jpg" height = "7%" width = "16%"></a>
<a href = "http://localhost/mypage.php">
<img src = "img/mp_home.jpg" height = "7%" width = "16%"></a>
</div><br><br><br>



<!-- ↓ search_user.php(利用者検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_user.php" method = "post">

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width =" 40%">
<br>

<font size = "6">利用者検索</font>
<br><br>

<p>
姓：<input type = "text" name = "last_name">&nbsp;&nbsp;&nbsp;&nbsp;
名：<input type = "text" name = "first_name">
</p><br>

大学：<select name = "college">
<option value = "0">------------------</option>
<option value = "1">高知大学</option>
<option value = "2">高知県立大学</option>
<option value = "3">高知工科大学</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

学年：<select name = "grade">
<option value = "0">------------</option>
<option value = "1">学部1年</option>
<option value = "2">学部2年</option>
<option value = "3">学部3年</option>
<option value = "4">学部4年</option>
<option value = "5">修士1年</option>
<option value = "6">修士2年</option>
</select><br><br><br>

<p>
タグ：<input type = "checkbox" name = "tag1" value = "1"> アニメ　　　　
　　　<input type = "checkbox" name = "tag2" value = "2"> 映画　　　　　
　　　<input type = "checkbox" name = "tag3" value = "3"> 音楽　　　　　
　　　<input type = "checkbox" name = "tag4" value = "4"> カメラ　　　</p>
<p>
　　　<input type = "checkbox" name = "tag5" value = "5"> グルメ　　　　
　　　<input type = "checkbox" name = "tag6" value = "6"> ゲーム　　　　
　　　<input type = "checkbox" name = "tag7" value = "7"> スポーツ　　　
　　　<input type = "checkbox" name = "tag8" value = "8"> 釣り 　　　　 </p>
<p>
　　　<input type = "checkbox" name = "tag9" value = "9"> 天体観測　　　
　　　<input type = "checkbox" name = "tag10" value = "10"> 動物　　　　　 
　　　<input type = "checkbox" name = "tag11" value = "11"> 読書　　　　　
　　　<input type = "checkbox" name = "tag12" value = "12"> 乗り物　　　 </p>
<p>
　　　<input type = "checkbox" name = "tag13" value = "13"> ファッション　
　　　<input type = "checkbox" name = "tag14" value = "14"> 漫画　　　　　
　　　<input type = "checkbox" name = "tag15" value = "15"> 料理　　　　　
　　　<input type = "checkbox" name = "tag16" value = "16"> 旅行 　　　　</p>
<br>

<input type = "submit" name = "user_exec" value = "検索">
<br><br><br>

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width = "40%">
<br></form>



<!-- ↓ search_event.php(イベント検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_event.php" method = "post">

<font size = "6">イベント検索</font>
<br><br>

<p>
キーワード：<input type = "text" name = "ev_keyword"></p>
<br>

分類：<select name = "ev_category">
<option value = "0">------------------</option>
<option value = "1">グルメ/フェスティバル</option>
<option value = "2">芸術/エンタメ</option>
<option value = "3">交流/スポーツ</option>
<option value = "4">地域復興/福祉</option>
<option value = "5">就活/キャリア</option>
</select><br><br><br>

<input type = "submit" name = "ev_exec" value = "検索">
<br><br><br>

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width = "40%">
<br></form>



<!-- ↓ search_bulletin.php(掲示板検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_bulletin.php" method = "post">

<font size = "6">掲示板検索</font>
<br><br>

<p>
キーワード：<input type = "text" name = "bb_keyword"></p>
<br>

分類：<select name = "bb_category">
<option value = "0">------------------</option>
<option value = "1">グルメ/フェスティバル</option>
<option value = "2">芸術/エンタメ</option>
<option value = "3">交流/スポーツ</option>
<option value = "4">地域復興/福祉</option>
<option value = "5">就活/キャリア</option>
</select><br><br><br>

<input type = "submit" name = "bb_exec" value = "検索">
<br><br><br>

<hr size = "1" color = "#87ceeb" width = "20%">
<hr size = "2" color = "#b0e0e6" width = "40%">
<br><br></form>

</body>
</html> 
