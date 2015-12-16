<?php
$NOW_ID = 1;
//利用者情報の取得
  $user_name = array();
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
  $db_selected = mysql_select_db('mypage', $link);
  if (!$db_selected) {
    die('データベース選択失敗です。'.mysql_error());
  }
  mysql_set_charset('utf8');


  $sql_UR_UA = "SELECT UR.USER_NAME, UR.SEX, UR.COLLEGE_NAME, UR.GRADE, UA.DEPARTMENT_NAME,
        UA.INTEREST, UA.PROFILE FROM UR, UA WHERE UR.USER_ID = UA.USER_ID
        AND UR.USER_ID = $NOW_ID";

  $result_UR_UA = mysql_query($sql_UR_UA, $link);
  if (!$result_UR_UA) {
    die('クエリが失敗しました。'.mysql_error());
  }

  while ($row_UR_UA = mysql_fetch_array($result_UR_UA)) {
    $user_name[] = $row_UR_UA['USER_NAME'];
    $sex[] = $row_UR_UA['SEX'];
    $college_name[] = $row_UR_UA['COLLEGE_NAME'];
    $grade[] = $row_UR_UA['GRADE'];
    $department_name[] = $row_UR_UA['DEPARTMENT_NAME'];
    $profile[] = $row_UR_UA['PROFILE'];
    if ($row_UR_UA['INTEREST'] == 1) {
      $interest[] = 音楽;
    }
    if ($row_UR_UA['INTEREST'] == 2) {
      $interest[] = 映画;
    }
    if ($row_UR_UA['INTEREST'] == 3) {
      $interest[] = スポーツ;
    }
    if ($row_UR_UA['INTEREST'] == 4) {
      $interest[] = ゲーム;
    }
  }
    mysql_close($link);
?>

<?php
//このページの利用者が立ち上げているイベント情報の取得

$event_title = array();
$event_start = array();
$event_id = array();

$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
  die('接続失敗です。' .mysql_error());
}
$db_selected = mysql_select_db('mypage', $link);
if (!$db_selected) {
  die('データベース選択失敗です。'.mysql_error());
}
mysql_set_charset('utf8');

//$sql_EV = "SELECT EV.EVENT_TITLE, EV.EVENT_START, COUNT($NOW_ID) AS CNT FROM EV WHERE EV.USER_ID = $NOW_ID;";
$sql_EV = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START FROM EV WHERE EV.USER_ID = $NOW_ID ORDER BY EVENT_START LIMIT 5;";

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

<?php
//このページの利用者が参加しているイベント情報の取得

$event_title_join = array();
$event_start_join = array();
$event_id_join = array();

$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
  die('接続失敗です。' .mysql_error());
}
$db_selected = mysql_select_db('mypage', $link);
if (!$db_selected) {
  die('データベース選択失敗です。'.mysql_error());
}
mysql_set_charset('utf8');

//$sql_EV = "SELECT EV.EVENT_TITLE, EV.EVENT_START, COUNT($NOW_ID) AS CNT FROM EV WHERE EV.USER_ID = $NOW_ID;";
$sql_join = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START FROM EV, PEV WHERE EV.EVENT_ID = PEV.EVENT_ID AND PEV.USER_ID = $NOW_ID ORDER BY EV.EVENT_START LIMIT 5;";

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

<?php
//このページの利用者がお気に入り登録しているイベント情報の取得

$event_title_fev = array();
$event_start_fev = array();
$event_id_fev = array();

$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
  die('接続失敗です。' .mysql_error());
}
$db_selected = mysql_select_db('mypage', $link);
if (!$db_selected) {
  die('データベース選択失敗です。'.mysql_error());
}
mysql_set_charset('utf8');

$sql_fev = "SELECT EV.EVENT_ID, EV.EVENT_TITLE, EV.EVENT_START FROM EV, FEV WHERE EV.EVENT_ID = FEV.EVENT_ID AND FEV.USER_ID = $NOW_ID ORDER BY EV.EVENT_START LIMIT 5;";

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

<?php
//イベントの参加人数を取得する
function event_count($cnt_id) {
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
  die('接続失敗です。' .mysql_error());
}
$db_selected = mysql_select_db('mypage', $link);
if (!$db_selected) {
  die('データベース選択失敗です。'.mysql_error());
}
mysql_set_charset('utf8');

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

<?php
/*function my_image() {
    //配列の初期化
    $icon_image = array();

    //データベースへの接続
    $link = mysql_connect('localhost', 'root', 'root');
    if (!$link) {
        die('接続失敗です。' .mysql_error());
    }

    //データベースの選択
    $db_selected = mysql_select_db('mypage', $link);
    if (!$db_selected) {
        die('データベース選択失敗です。'.mysql_error());
    }

    //文字コード設定
    mysql_set_charset('utf8');

    //テスト用SQL文
    //$sql = "SELECT EVENT_IMAGE FROM EV WHERE EVENT_ID = 1 OR EVENT_ID = 2";
    //AND EVENT_ID = 2 AND EVENT_ID = 3 AND EVENT_ID = 4";

    //参加者数の多いイベント上位4件のイベント画像の取得
    $sql = "SELECT ICON_IMAGE FROM UA";

    //クエリの実行
    $result = mysql_query($sql, $link);
    if (!$result) {
        die('クエリが失敗しました。'.mysql_error());
    }

    header("Content-Type: image/jpeg");

    //抽出したデータを1件ずつ配列の最後に格納していく
    while ($row = mysql_fetch_array($result)) {
        array_push($icon_image, $row['ICON_IMAGE']);
    }
    //画像の表示
    //配列の添字0~3に参加者数の多いイベント画像順で格納されている
    echo $icon_image[0];

    mysql_close($link);
}
*/
//my_image();
//my_all();
?>


<html>
<head>
<title>personalpage</title>
</head>
<body>
  <!-- 利用者情報の表示-->
  <p>
    <?php echo $user_name[0], '　', $sex[0];?> <br />
    <?php echo $college_name[0], '　', $grade[0], '年', '　', $department_name[0];?>
　</p>
  <p> 興味関心のある分野 <br />
    <?php echo $interest[0];?>
  </p>
  <p> 自己紹介文 <br />
    <?php echo $profile[0];?>
  </p>
<!-- 利用者が立ち上げているイベントの表示-->
  <p>
    <?php echo $user_name[0], 'さんが立ち上げているイベント', '<br />';
    for($i=0; $i < count($event_id); $i++) {
      echo $event_start[$i], '　', $event_title[$i], '(', $EVCNT[$i], ')', '<br />';
    }
    ?>
　</p>
<!-- 利用者が参加しているイベントの表示-->
  <p>
  <?php echo $user_name[0], 'さんが参加しているイベント', '<br />';
  for($i=0; $i < count($event_id_join); $i++) {
    echo $event_start_join[$i], '　', $event_title_join[$i], '(', $EVCNT_JOIN[$i], ')', '<br />';
  }
  ?>
　</p>
<!-- 利用者がお気に入り登録しているイベントの表示-->
  <p>
  <?php echo $user_name[0], 'さんがお気に入り登録しているイベント', '<br />';
  for($i=0; $i < count($event_id_fev); $i++) {
    echo $event_start_fev[$i], '　', $event_title_fev[$i], '(', $EVCNT_FEV[$i], ')', '<br />';
  }
  ?>
　</p>

</body>
</html>
