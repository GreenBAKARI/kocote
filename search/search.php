<html>
<head>
<meta charset = "utf-8">
<title>検索画面</title>
</head>
<center>
<link rel = "stylesheet" href = "../css/style.css"　type = "text/css">
<link rel = "stylesheet" href = "../css/se_style.css"　type = "text/css">
<body topmargin = "100" bottommargin = "100">

<div id = "headerArea"></div>
<div id = "footerArea"></div>
<br><br><br>

<div id = "box">
<a href = "../event/event.php">
<img src = "../img/ev_home.jpg" height = "13%" width = "16%"></a>
<a href = "../bulletin/bulletin.php">
<img src = "../img/bb_home.jpg" height = "13%" width = "16%"></a>
<a href = "../search/search.php">
<img src = "../img/se_home.jpg" height = "13%" width = "16%"></a>
<a href = "../dm/dm.php">
<img src = "../img/dm_home.jpg" height = "13%" width = "16%"></a>
<a href = "../mypage/mypage.php">
<img src = "../img/mp_home.jpg" height = "13%" width = "16%"></a>
</div><br><br><br>



<!-- ↓ search_user.php(利用者検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_user.php" method = "post">

<hr class="top">
<hr class="bottom">
<br>


<font size = "6">利用者検索</font>

<br><br>

<table class="user1">
<tr>
<td class="title">姓：</td><td class="content"><input type = "text" name = "last_name"></td>
<td class="title">名：</td><td class="content"><input type = "text" name = "first_name"></td>
</tr>

<tr>
<td class="title">大学：</td>
<td class="content"><select name = "college">
<option value = "0">------------------</option>
<option value = "1">高知大学</option>
<option value = "2">高知県立大学</option>
<option value = "3">高知工科大学</option>
</select></td>

<td class="title">学年：</td>
<td class="content"><select name = "grade">
<option value = "0">------------</option>
<option value = "1">学部1年</option>
<option value = "2">学部2年</option>
<option value = "3">学部3年</option>
<option value = "4">学部4年</option>
<option value = "5">修士1年</option>
<option value = "6">修士2年</option>
</select>
</td>
</tr>
</table>

<table class="user2">
    <tr>
     <td>タグ：</td>
     <td><input type = "checkbox" name = "tag1" value = "1"> アニメ</td>　　　　
　　　<td><input type = "checkbox" name = "tag2" value = "2"> 映画</td>　　　　　　
　　　<td><input type = "checkbox" name = "tag3" value = "3"> 音楽</td>　　　　　　
　　　<td><input type = "checkbox" name = "tag4" value = "4"> カメラ</td>　
    </tr>
    <tr>
     <td></td>
　　　<td><input type = "checkbox" name = "tag5" value = "5"> グルメ</td>　　　　　
　　　<td><input type = "checkbox" name = "tag6" value = "6"> ゲーム</td>　　　　　
　　　<td><input type = "checkbox" name = "tag7" value = "7"> スポーツ</td>　　　　
　　　<td><input type = "checkbox" name = "tag8" value = "8"> 釣り</td>　 　　　　 
   </tr>
   <tr>
     <td></td>
　　　<td><input type = "checkbox" name = "tag9" value = "9"> 天体観測</td>　　　　
　　　<td><input type = "checkbox" name = "tag10" value = "a"> 動物</td>　　　　　　 
　　　<td><input type = "checkbox" name = "tag11" value = "b"> 読書</td>　　　　　　
　　　<td><input type = "checkbox" name = "tag12" value = "c"> 乗り物</td>　　　　 
   </tr>
   <tr>
     <td></td>
　　　<td><input type = "checkbox" name = "tag13" value = "d"> ファッション</td>　　
　　　<td><input type = "checkbox" name = "tag14" value = "e"> 漫画</td>　　　　　　
　　　<td><input type = "checkbox" name = "tag15" value = "f"> 料理</td>　　　　　　
　　　<td><input type = "checkbox" name = "tag16" value = "g"> 旅行</td>　
   </tr>
</table>

<br>

<input type = "submit" name = "user_exec" value = "検索">
<br><br><br>

<hr class="top">
<hr class="bottom">
<br></form>



<!-- ↓ search_event.php(イベント検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_event.php" method = "post" name="formDate">

<font size = "6">イベント検索</font>

<br><br>

<table class="event">
 
<tr>
<td class="title">キーワード：</td><td class="content"><input type = "text" name = "ev_keyword"></td>
</tr>

<tr>
<td class="title">分類：</td>
<td class="content">
<select name = "ev_category">
<option value = "0">------------------</option>
<option value = "1">グルメ/フェスティバル</option>
<option value = "2">芸術/エンタメ</option>
<option value = "3">交流/スポーツ</option>
<option value = "4">福祉/地域振興</option>
<option value = "5">就活/キャリア</option>
</select>
</td>
</tr>

<tr>
<td class="title">開催日：</td>
<td class="content">
<select name="select_year" onchange="set_select_month()"></select> 年
<select name="select_month" onchange="set_select_date()"></select> 月
<select name="select_date"></select> 日
</td>
</tr>
</table>

<br>

<input type = "submit" name = "ev_exec" value = "検索">
<br><br><br>

<hr class="top">
<hr class="bottom">
<br>
</form>

<script type="text/javascript">
    var now = new Date();
    var now_year = now.getFullYear();
    var now_month = now.getMonth() + 1;
    var now_date = now.getDate();
    
    function uruu(Year) {
        var uruu = 
            (Year % 400 == 0) ? true :
            (Year % 100 == 0) ? false :
            (Year % 4 == 0) ? true : false;
        return uruu;
    }
    
    function set_select_year() {
        var select = document.formDate.select_year;
        var option = select.appendChild(document.createElement('option'));
        option.value = 0;
        option.text = '----';
        for (var y = now_year; y < now_year + 5; y++) {
            var select = document.formDate.select_year;
            var option = select.appendChild(document.createElement('option'));
            option.value = y;
            option.text = y;
            option.selected = (y == 0) ? 'selected' : false;
        }
        set_select_month();
    }
    set_select_year();
  
    function set_select_month() {
        var Year =
            document.formDate.select_year.options[
            document.formDate.select_year.selectedIndex
            ].value;
        var select = document.formDate.select_month;
        while (select.options.length){
            select.removeChild(select.options[0]);
        }
        if (Year != 0) {
            for (var m = 1; m <= 12; m++){
                var option = select.appendChild(document.createElement('option'));
                option.value = m;
                option.text = m;
                option.selected =
                    (Year == now_year) ?
                    ((m == now_month) ? 'selected' : false ) :
                    ((m == 0) ? 'selected' : false );
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
        set_select_date();
    }

    function set_select_date() {
        var Year =
            document.formDate.select_year.options[
            document.formDate.select_year.selectedIndex
            ].value;
        var Month =
            document.formDate.select_month.options[
            document.formDate.select_month.selectedIndex
            ].value;
        var days =
            [31,(uruu(Year)?29:28),31,30,31,30,31,31,30,31,30,31];
        var select = document.formDate.select_date;
        while(select.options.length) {
            select.removeChild(select.options[0]);
        }
        
        if (Month != 0) {        
            for (var d = 1; d <= days[Month - 1]; d++) {
            var option = select.appendChild(document.createElement('option'));
            option.value = d;
            option.text = d;
            option.select =
                (Year == now_year && Month == now_month) ?
                ((d == now_date) ? 'selected' : false ) : 
                ((d == 1) ? 'selected' : false ); 
            }
        } else {
            var option = select.appendChild(document.createElement('option'));
            option.value = 0;
            option.text = '';
        }
    }
</script>



<!-- ↓ search_bulletin.php(掲示板検索)にPOST形式でフォームのデータを送信する -->
<form action = "search_bulletin.php" method = "post">

<font size = "6">掲示板検索</font>

<br>

<table class="bulletin">
<tr>
<td class="title">キーワード：</td><td class="content"><input type = "text" name = "bb_keyword"><td>
</tr>

<br>

<tr>
<td class="title">分類：</td>
<td class="content"><select name = "bb_category">
<option value = "0">------------------</option>
<option value = "1">グルメ/フェスティバル</option>
<option value = "2">芸術/エンタメ</option>
<option value = "3">交流/スポーツ</option>
<option value = "4">地域復興/福祉</option>
<option value = "5">就活/キャリア</option>
<option value = "6">その他</option>
</select>
</td>
</tr>
</table>

<br>

<input type = "submit" name = "bb_exec" value = "検索">
<br><br><br>

<hr class="top">
<hr class="bottom">
<br><br></form>

</body>
</html> 
