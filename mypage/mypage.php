<?php
//ログイン中の利用者のIDを取得
    session_start();
    $user_id = $_SESSION[user_id];
    if (empty($user_id)) {
      header("LOCATION: ../login.php");
    }
    //$user_id = 1;
?>

<!-- 利用者付加情報の取得 -->
<?php
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
    $sql_UR = "SELECT USER_LAST_NAME, USER_FIRST_NAME, USER_LAST_ROMA, USER_FIRST_ROMA,
                  SEX, COLLEGE_NAME, GRADE
                  FROM UR WHERE USER_ID = $user_id";

    $result_UR = mysql_query($sql_UR, $link);

    if (!$result_UR) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_UR = mysql_fetch_array($result_UR)) {
      $last_name[] = $row_UR['USER_LAST_NAME'];
      $first_name[] = $row_UR['USER_FIRST_NAME'];
      $last_roma[] = $row_UR['USER_LAST_ROMA'];
      $first_roma[] = $row_UR['USER_FIRST_ROMA'];
      $sex[] = $row_UR['SEX'];
      $college_name[] = $row_UR['COLLEGE_NAME'];
      $grade[] = $row_UR['GRADE'];
    }
    mysql_close($link);
?>

<!-- 利用者付加情報の取得 -->
<?php
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
    $sql_UA = "SELECT DEPARTMENT_NAME, INTEREST, PROFILE
                  FROM UA WHERE USER_ID = USER_ID
                  AND USER_ID = $user_id";

    $result_UA = mysql_query($sql_UA, $link);

    if (!$result_UA) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_UA = mysql_fetch_array($result_UA)) {
      $department_name[] = $row_UA['DEPARTMENT_NAME'];
      $profile[] = $row_UA['PROFILE'];
      $interest[]=$row_UA['INTEREST'];
    }
    //興味・関心を表す値を取り出す
    //興味・関心に格納されている値の文字数を数える
      $length = mb_strlen($interest[0]);
      $interest_user = array();
      $interest_result = array();
    //先頭の文字から1文字ずつ配列interest_userに格納する
    for ($i = 0; $i < $length; $i++) {
              $interest_user[$i] = substr($interest[0], $i, 1);
            }
    //for文が何回目かを表す変数
      $count_interest = 0;
    //何個目に格納するかを表す変数
      $count_result = 1;
    //配列interest_userの値によって対応する文字列を配列interest_resultに格納する
    for ($i = 0; $i < $length; $i++) {
      $count_interest += 1;
      if ($interest_user[$i] == 't' && $count_interest == 1) {
        $interest_result[$count_result] = アニメ;
        $count_result += 1;
      }

      else if ($interest_user[$i] == 't' && $count_interest == 2) {
        $interest_result[$count_result] = 映画;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 3) {
        $interest_result[$count_result] = 音楽;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 4) {
        $interest_result[$count_result] = カメラ;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 5) {
        $interest_result[$count_result] = グルメ;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 6) {
        $interest_result[$count_result] = ゲーム;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 7) {
        $interest_result[$count_result] = スポーツ;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 8) {
        $interest_result[$count_result] = 釣り;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 9) {
        $interest_result[$count_result] = 天体観測;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 10) {
        $interest_result[$count_result] = 動物;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 11) {
        $interest_result[$count_result] = 読書;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 12) {
        $interest_result[$count_result] = 乗り物;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 13) {
        $interest_result[$count_result] = ファッション;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 14) {
        $interest_result[$count_result] = 漫画;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 15) {
        $interest_result[$count_result] = 料理;
        $count_result += 1;
      }
      else if ($interest_user[$i] == 't' && $count_interest == 16) {
        $interest_result[$count_result] = 旅行;
        $count_result += 1;
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
    $sql_ev = "SELECT EVENT_ID, EVENT_TITLE, EVENT_START
               FROM EV WHERE USER_ID = $user_id ORDER BY EVENT_START LIMIT 5";

    $result_ev = mysql_query($sql_ev, $link);
    if (!$result_ev) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_ev = mysql_fetch_array($result_ev)) {
      $event_id[] = $row_ev['EVENT_ID'];
      $event_title[] = $row_ev['EVENT_TITLE'];
      $event_start[] = $row_ev['EVENT_START'];
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
                 AND PEV.USER_ID = $user_id ORDER BY EV.EVENT_START LIMIT 5";

    $result_join = mysql_query($sql_join, $link);
    if (!$result_join) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_join = mysql_fetch_array($result_join)) {
      $event_id_join[] = $row_join['EVENT_ID'];
      $event_title_join[] = $row_join['EVENT_TITLE'];
      $event_start_join[] = $row_join['EVENT_START'];
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
                AND FEV.USER_ID = $user_id ORDER BY EV.EVENT_START LIMIT 5";

    $result_fev = mysql_query($sql_fev, $link);
    if (!$result_join) {
      die('クエリが失敗しました。'.mysql_error());
    }

    while ($row_fev = mysql_fetch_array($result_fev)) {
      $event_id_fev[] = $row_fev['EVENT_ID'];
      $event_title_fev[] = $row_fev['EVENT_TITLE'];
      $event_start_fev[] = $row_fev['EVENT_START'];
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
      $sql_evcnt = "SELECT COUNT(PEV.EVENT_ID) AS CNT FROM PEV WHERE EVENT_ID = $cnt_id";

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
    for($i = 0; $i < count($event_id); $i++) {
      $EVCNT[$i] =& event_count($event_id[$i]);
    }
    //このページの利用者が参加しているイベントの参加人数
    for($i = 0; $i < count($event_id_join); $i++) {
      $EVCNT_JOIN[$i] =& event_count($event_id_join[$i]);
    }
    //このページの利用者がお気に入り登録しているイベントの参加人数
    for($i = 0; $i < count($event_id_fev); $i++) {
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
<link rel="stylesheet" href="../css/style.css"　type="text/css">
<link rel="stylesheet" href="../css/my_style.css"　type="text/css">
<body topmargin="100" bottommargin="100">


<div id="headerArea"></div>


<form id="loginForm" name="loginForm" action="" method="POST">
<!-- <?php echo $errorMessage ?> -->

<!-- 機能選択ボタン -->
<div id="box">
  <a href="../event/event.php"><img src="../img/ev_home.jpg" height="13%" width="16%"></a>
  <a href="../bulletin/bulletin.php"><img src="../img/bb_home.jpg" height="13%" width="16%"></a>
  <a href="../search/search.php"><img src="../img/se_home.jpg" height="13%" width="16%"></a>
  <a href="../mypage/mypage.php"><img src="../img/mp_home.jpg" height="13%" width="16%"></a></div>
<br>

<!-- ヘッダ画像の表示-->
<img src="mypage_image.php?id=<?php echo $user_id ?>&image=2" class="header-img">
<br>
<!-- アイコン画像の表示-->
<img src="mypage_image.php?id=<?php echo $user_id ?>&image=1" class="icon-img" style="position:absolute;left:240px;top:450px;">


<!-- 編集ボタン-->
<form>
<button class="btn" type="button" name="aaa" value="aaa" onclick="location.href='./mypage_detail.php?user_id=<?php echo $user_id ?>'" style="position:absolute;left:278px;top:640px;">
<font size="5" >編集する</font>
</button>
</form>

<!-- 利用者情報の表示-->
<table  class="mypage-table" style="position:absolute;left:500px;top:450px;">
  <!-- 利用者名と性別の表示-->
  <tr>
    <td class="name-size">
      <?php
      //利用者名の表示
          echo  $last_name[0], $first_name[0],'　';
      //性別の表示
          if($sex[0] == 'm') {
            echo '<font color="#0000ff">男性</font>';
          }else {
            echo '<font color="#ff0000">女性</font>';
          }
      ?>
    </td>
  </tr>
  <br>
  <!-- 利用者の大学名、学部名、学年を表示-->
  <tr>
    <td class="space">
      <?php
      //大学名と学部名を表示
          echo $college_name[0], '　', $department_name[0], '　';
      //学年を表示
          if($grade[0] == '1') {
            echo '学部1年';
          }else if($grade[0] == '2') {
            echo '学部2年';
          }else if($grade[0] == '3') {
            echo '学部3年';
          }else if($grade[0] == '4') {
            echo '学部4年';
          }else if($grade[0] == '5') {
            echo '修士1年';
          }else{
            echo '修士2年';
          }
      ?>
    </td>
  </tr>

  <!-- 利用者の興味関心のある分野を表示-->
  <tr>
    <td class="name-size">興味関心のある分野</td>
  </tr>
  <br>
  <tr>
    <td class="space">
      <?php
          for($i = 1; $i < $count_result; $i++) {
            //三つ要素を表示すると改行する
            if( ($i % 3) == 0 ){
              echo '・', $interest_result[$i], '　<br>';
            }else {
              echo '・', $interest_result[$i], '　';
            }
          }
      ?>
    </td>
  </tr>
  <br>
  <!-- 利用者の自己紹介文を表示-->
  <tr>
    <td class="name-size">自己紹介文</td>
  </tr>
  <tr>
    <td class="space"><?php echo $profile[0];?></td>
  </tr>

  <!-- 利用者が立ち上げているイベントの表示-->
  <tr>
    <td class="name-size">
      <?php echo $last_name[0], 'さんが立ち上げているイベント', '<br />';?>
    </td>
  </tr>
</table>
  
  <table class="event">
      <?php
          for($i = 0; $i < count($event_id); $i++) {
            echo '<tr class="event">';
            echo '<td class="event1">';            //月の表示（先頭の0は表示されない）
            if (substr($event_start[$i], 5, 1) == 0) {
            echo '&nbsp;&thinsp;', substr($event_start[$i], 6, 1).'月';
            } else {
            echo substr($event_start[$i], 5, 2).'月';
            }
            //日の表示（先頭の0は表示されない）
            if (substr($event_start[$i], 8, 1) == 0) {
            echo '&ensp;&thinsp;', substr($event_start[$i], 9, 1).'日 ';
            } else {
            echo substr($event_start[$i], 8, 2).'日 ';
            }
            //イベント名とイベントの参加人数の表示
            echo '　', '<a href=../event/event_detail.php?event_id='.$event_id[$i].'>'.$event_title[$i].'</a>',
            '(', '現在の参加人数:', $EVCNT[$i], '人)';
            echo '</td>';
            echo '<td class="event2">';
            //「編集・削除」ボタンの表示
            echo '<form>'
            . '<button class="btn" type="button" name="aaa" value="aaa" onclick="location.href=\'../event/event_edit.php?event_id='.$event_id[$i].'\'">
                <font size="2">編集・削除</font>
                </button>
                </form>';
            echo '</td>';
            echo '</tr>';
          }
      ?>
  </table>

<table  class="mypage-table" style="position:absolute;left:500px;">
  <!-- 利用者が参加しているイベントの表示-->
  <tr>
    <td class="name-size">
      <?php echo $last_name[0], 'さんが参加しているイベント', '<br />'; ?>
    </td>
  </tr>
  <tr>
    <td class="space">
      <?php
          for($i = 0; $i < count($event_id_join); $i++) {
            //月の表示（先頭の0は表示されない）
            //月の表示（先頭の0は表示されない）
            if (substr($event_start_join[$i], 5, 1) == 0) {
            echo '&nbsp;&thinsp;', substr($event_start_join[$i], 6, 1).'月';
            } else {
            echo substr($event_start_join[$i], 5, 2).'月';
            }
            //日の表示（先頭の0は表示されない）
            if (substr($event_start_join[$i], 8, 1) == 0) {
            echo '&ensp;&thinsp;', substr($event_start_join[$i], 9, 1).'日 ';
            } else {
            echo substr($event_start_join[$i], 8, 2).'日 ';
            }
            //イベント名とイベントの参加人数の表示
            echo '　', '<a href=../event/event_detail.php?event_id='.$event_id_join[$i].'>'.$event_title_join[$i].'</a>',
            '(', '現在の参加人数:', $EVCNT_JOIN[$i], '人)', '<br />';
          }
      ?>
    </td>
  </tr>

  <!-- 利用者がお気に入り登録しているイベントの表示-->
  <tr>
    <td class="name-size">
      <?php echo $last_name[0], 'さんがお気に入り登録しているイベント', '<br />'; ?>
    </td>
  </tr>
  <tr>
    <td class="space">
      <?php
          for($i = 0; $i < count($event_id_fev); $i++) {
            //月の表示（先頭の0は表示されない）
            if (substr($event_start_fev[$i], 5, 1) == 0) {
            echo '&nbsp;&thinsp;', substr($event_start_fev[$i], 6, 1).'月';
            } else {
            echo substr($event_start_fev[$i], 5, 2).'月';
            }
            //日の表示（先頭の0は表示されない）
            if (substr($event_start_fev[$i], 8, 1) == 0) {
            echo '&ensp;&thinsp;', substr($event_start_fev[$i], 9, 1).'日 ';
            } else {
            echo substr($event_start_fev[$i], 8, 2).'日 ';
            }
            //イベント名とイベントの参加人数の表示
            echo '　', '<a href=../event/event_detail.php?event_id='.$event_id_fev[$i].'>'.$event_title_fev[$i].'</a>',
            '(', '現在の参加人数:', $EVCNT_FEV[$i], '人)', '<br />';
          }
      ?>
    </td>
  </tr>
  <tr><td>　</td></tr>
  <tr><td>　</td></tr>

</table>

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
