<!-- ログインしている利用者のIDを取得 -->
<?php
    $NOW_ID = 1;
?>

<!-- 利用者情報の取得 -->
<?php
    $last_name = array();
    $first_name = array();
    $last_roma = array();
    $first_name = array();
    $sex = array();
    $college_name = array();
    $grade = array();
    $department_name = array();
    $interest = array();
    $profile = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
      die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
      die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //利用者情報の取得
    $sql_UR_UA = "SELECT UR.USER_LAST_NAME, UR.USER_FIRST_NAME, UR.USER_LAST_ROMA, UR.USER_FIRST_ROMA,
                  UR.SEX, UR.COLLEGE_NAME, UR.GRADE, UA.DEPARTMENT_NAME, UA.INTEREST, UA.PROFILE
                  FROM UR, UA WHERE UR.USER_ID = UA.USER_ID
                  AND UR.USER_ID = $NOW_ID";

    $result_UR_UA = mysql_query($sql_UR_UA, $link);

    if (!$result_UR_UA) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_UR_UA = mysql_fetch_array($result_UR_UA)) {
      $last_name[] = $row_UR_UA['USER_LAST_NAME'];
      $first_name[] = $row_UR_UA['USER_FIRST_NAME'];
      $last_roma[] = $row_UR_UA['USER_LAST_ROMA'];
      $first_roma[] = $row_UR_UA['USER_FIRST_ROMA'];
      $sex[] = $row_UR_UA['SEX'];
      $college_name[] = $row_UR_UA['COLLEGE_NAME'];
      $grade[] = $row_UR_UA['GRADE'];
      $department_name[] = $row_UR_UA['DEPARTMENT_NAME'];
      $profile[] = $row_UR_UA['PROFILE'];
      $interest[]=$row_UR_UA['INTEREST'];
    }
    //興味・関心を表す値を取り出す
    //興味・関心に格納されている値の文字数を数える
      $length = mb_strlen($interest[0]);
      $interest_user = array();
      $interest_result = array();
    //先頭の文字から1文字ずつ配列interest_userに格納する
    for ($i=0; $i<$length; $i++) {
              $interest_user[$i] = substr($interest[0], $i, 1);
            }
    //配列interest_userの値によって対応する文字列を配列interest_resultに格納する
    for ($i=0; $i<$length; $i++) {
      if ($interest_user[$i] == 1) {
        $interest_result[$i] = アニメ;
      }
      else if ($interest_user[$i] == 2) {
        $interest_result[$i] = 映画;
      }
      else if ($interest_user[$i] == 3) {
        $interest_result[$i] = 音楽;
      }
      else if ($interest_user[$i] == 4) {
        $interest_result[$i] = カメラ;
      }
      else if ($interest_user[$i] == 5) {
        $interest_result[$i] = グルメ;
      }
      else if ($interest_user[$i] == 6) {
        $interest_result[$i] = ゲーム;
      }
      else if ($interest_user[$i] == 7) {
        $interest_result[$i] = スポーツ;
      }
      else if ($interest_user[$i] == 8) {
        $interest_result[$i] = 釣り;
      }
      else if ($interest_user[$i] == 9) {
        $interest_result[$i] = 天体観測;
      }
      else if ($interest_user[$i] == a) {
        $interest_result[$i] = 動物;
      }
      else if ($interest_user[$i] == b) {
        $interest_result[$i] = 読書;
      }
      else if ($interest_user[$i] == c) {
        $interest_result[$i] = 乗り物;
      }
      else if ($interest_user[$i] == d) {
        $interest_result[$i] = ファッション;
      }
      else if ($interest_user[$i] == e) {
        $interest_result[$i] = 漫画;
      }
      else if ($interest_user[$i] == f) {
        $interest_result[$i] = 料理;
      }
      else if ($interest_user[$i] == g) {
        $interest_result[$i] = 旅行;
      }
    }
      mysql_close($link);
?>

<!-- このページの利用者が立ち上げているイベント情報の取得 -->
<?php
    $event_title = array();
    $event_start = array();
    $event_id = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
      die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
      die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //このページの利用者が立ち上げているイベント情報を5件分取得
    $sql_EV = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START
               FROM EV WHERE EV.USER_ID = $NOW_ID ORDER BY EVENT_START LIMIT 5;";

    $result_EV = mysql_query($sql_EV, $link);
    if (!$result_EV) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_EV = mysql_fetch_array($result_EV)) {
      array_push($event_id, $row_EV['EVENT_ID']);
      array_push($event_title, $row_EV['EVENT_TITLE']);
      array_push($event_start, $row_EV['EVENT_START']);
    }
    mysql_close($link);
?>

<!-- このページの利用者が参加しているイベント情報の取得 -->
<?php
    $event_title_join = array();
    $event_start_join = array();
    $event_id_join = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
      die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
      die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');

    //このページの利用者が参加しているイベント情報を5件分取得
    $sql_join = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START
                 FROM EV, PEV WHERE EV.EVENT_ID = PEV.EVENT_ID
                 AND PEV.USER_ID = $NOW_ID ORDER BY EV.EVENT_START LIMIT 5;";

    $result_join = mysql_query($sql_join, $link);
    if (!$result_join) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_join = mysql_fetch_array($result_join)) {
      array_push($event_id_join, $row_join['EVENT_ID']);
      array_push($event_title_join, $row_join['EVENT_TITLE']);
      array_push($event_start_join, $row_join['EVENT_START']);
    }
    mysql_close($link);
?>

<!-- このページの利用者がお気に入り登録しているイベント情報の取得 -->
<?php
    $event_title_fev = array();
    $event_start_fev = array();
    $event_id_fev = array();

    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
      die('接続失敗です。' .mysql_error());
    }
    $db_selected = mysql_select_db('greenbakari', $link);
    if (!$db_selected) {
      die('データベース選択失敗です。'.mysql_error());
    }
    mysql_set_charset('utf8');
    //このページの利用者がお気に入り登録しているイベント情報を5件分取得
    $sql_fev = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START
                FROM EV, FEV WHERE EV.EVENT_ID = FEV.EVENT_ID
                AND FEV.USER_ID = $NOW_ID ORDER BY EV.EVENT_START LIMIT 5;";

    $result_fev = mysql_query($sql_fev, $link);
    if (!$result_join) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_fev = mysql_fetch_array($result_fev)) {
      array_push($event_id_fev, $row_fev['EVENT_ID']);
      array_push($event_title_fev, $row_fev['EVENT_TITLE']);
      array_push($event_start_fev, $row_fev['EVENT_START']);
    }
    mysql_close($link);

?>

<!-- イベントの参加人数を取得する -->
<?php
    //イベントの参加人数を数える関数(参加人数を数えたいイベントのイベントIDを引数とする)
    function event_count($cnt_id) {
      $link = mysql_connect('localhost', 'root', 'root');
      if (!$link) {
        die('接続失敗です。' .mysql_error());
      }
      $db_selected = mysql_select_db('greenbakari', $link);
      if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
      }
      mysql_set_charset('utf8');
      //参加イベントテーブルから引数のイベントIDを持つレコード数をカウントする
      $sql_evcnt = "SELECT COUNT(PEV.EVENT_ID) AS CNT FROM PEV WHERE PEV.EVENT_ID = $cnt_id;";

      $result_evcnt = mysql_query($sql_evcnt, $link);
      if (!$result_evcnt) {
        die('クエリが失敗しました。'.mysql_error());
      }

      while ($row_evcnt = mysql_fetch_array($result_evcnt)) {
        $event_evcnt = $row_evcnt['CNT'];
      }
      mysql_close($link);
      return $event_evcnt;
    }
    //このページの利用者が立ち上げているイベントの参加人数
    for($i=0; $i < count($event_id); $i++) {
      $EVCNT[$i] =& event_count($event_id[$i]);
    }
    //このページの利用者が参加しているイベントの参加人数
    for($i=0; $i < count($event_id_join); $i++) {
      $EVCNT_JOIN[$i] =& event_count($event_id_join[$i]);
    }
    //このページの利用者がお気に入り登録しているイベントの参加人数
    for($i=0; $i < count($event_id_fev); $i++) {
      $EVCNT_FEV[$i] =& event_count($event_id_fev[$i]);
    }
?>

<!-- HTML本文　-->
<html>
<head>
<meta charset="UTF-8">
<title>高知県大学生用交流サイト「KoCo + Te」</title>
</head>
<center>
<link rel="stylesheet" href="../style.css"　type="text/css">
<body topmargin="100" bottommargin="100">


<div id="headerArea"></div>


<form id="loginForm" name="loginForm" action="" method="POST">
  <!-- <?php echo $errorMessage ?> -->

<div id = "box">
  <a href="http://localhost/kocote/event/event.php"><img src="../img/ev_home.jpg" height="7%" width="16%"></a>
  <a href="http://localhost/kocote/bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="7%" width="16%"></a>
  <a href="http://localhost/kocote/search/search.php"><img src="../img/se_home.jpg" height="7%" width="16%"></a>
  <a href="http://localhost/kocote/dm/dm.php"><img src="../img/dm_home.jpg" height="7%" width="16%"></a>
  <a href="http://localhost/kocote/mypage/mypage.php"><img src="../img/mp_home.jpg" height="7%" width="16%"></a></div>
<br><br><br>


<!-- アイコン画像の表示-->
<img src="mypage_image.php?id=<?php echo $NOW_ID ?>&image=1">
<img src="mypage_image.php?id=<?php echo $NOW_ID ?>&image=2">

<!-- 編集ボタン-->
<form>
<button type="button" name="aaa" value="aaa" onclick="location.href='http://localhost/kocote/mypage/mypage_conf.php?user_id=<?php echo $NOW_ID ?>'">
<font size="5" color="#333399">編集</font>
</button>
</form>

<!-- 利用者情報の表示-->
<p>
  <?php echo $last_name[0], $first_name[0],'　', $sex[0];?> <br />
  <?php echo $college_name[0], '　', $grade[0], '年', '　', $department_name[0];?>
</p>
<p> 興味関心のある分野 <br />
  <?php
      for($i=0; $i<$length; $i++) {
        echo $interest_result[$i], '<br />';
      }
  ?>
</p>
<p> 自己紹介文 <br />
  <?php echo $profile[0];?>
</p>
<!-- 利用者が立ち上げているイベントの表示-->
<p>
  <?php echo $last_name[0], 'さんが立ち上げているイベント', '<br />';
      for($i=0; $i < count($event_id); $i++) {
        echo substr($event_start[$i],5,2), '月',
        substr($event_start[$i],8,2), '日',
        '　', '<a href=http://localhost/kocote/event/event_detail.php?event_id='.$event_id[$i].'>'.$event_title[$i].'</a>',
        '(', '現在の参加人数:', $EVCNT[$i], '人)', '<br />',
        '<form>
        <button type="button" name="aaa" value="aaa" onclick="location.href=\'http://localhost/kocote/mypage/event_edit.php?event_id='.$event_id[$i].'\'">
        <font size="2" color="#333399">編集・削除</font>
        </button>
        </form>';
      }
  ?>
</p>
<!-- 利用者が参加しているイベントの表示-->
<p>
  <?php echo $last_name[0], 'さんが参加しているイベント', '<br />';
      for($i=0; $i < count($event_id_join); $i++) {
        echo substr($event_start_join[$i],5,2), '月',
        substr($event_start_join[$i],8,2), '日',
        '　', '<a href=http://localhost/kocote/event/event_detail.php?event_id='.$event_id_join[$i].'>'.$event_title_join[$i].'</a>',
        '(', '現在の参加人数:', $EVCNT_JOIN[$i], '人)', '<br />';
      }
  ?>
</p>
<!-- 利用者がお気に入り登録しているイベントの表示-->
<p>
  <?php echo $last_name[0], 'さんがお気に入り登録しているイベント', '<br />';
      for($i=0; $i < count($event_id_fev); $i++) {
        echo substr($event_start_fev[$i],5,2), '月',
        substr($event_start_fev[$i],8,2), '日',
        '　', '<a href=http://localhost/kocote/event/event_detail.php?event_id='.$event_id_fev[$i].'>'.$event_title_fev[$i].'</a>',
        '(', '現在の参加人数:', $EVCNT_FEV[$i], '人)', '<br />';
      }
  ?>
</p>

<!-- 本体 -->

<div id="footerArea">
<ul>
<li><a href="">会社概要</a></li>
<li><a href="">お問い合わせ</a></li>
<li><a href="">個人情報保護方針</a></li>
<li><a href="">採用情報</a></li>
<li><a href="">サイトマップ</a></li>
</ul></div>
</body>
</html>
