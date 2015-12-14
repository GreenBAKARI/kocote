<html>
<head><title>mypage_detail.php</title></head>
<body>

<?php
//phpinfo();
//$link = mysql_connect ( 'c:\xampp\mysql', 'user', 'pass' );

// if (! $link) {
// 	die ( '接続失敗です。' . mysql_error () );
// }

// print('<p>接続に成功しました。</p>');

// /* ヘッダ画像 */
// echo "ヘッダ画像<<br>";
// /* アイコン画像 */
// echo "アイコン画像<br>";
// /* 「編集を確認する」-ボタン */
// echo "「編集を確認する」-ボタン<br>";
// /* 名前 */
// echo "名前<br>";
// /* 性別 */
// echo "性別<br>";
// /* 名前の表記-ラジオボタン */
// echo "名前の表記-ラジオボタン<br>";
// /* 学科-プルダウンメニュー */
// echo "学科-プルダウンメニュー<br>";
// /* 興味・関心のある分野-チェックボックス */
// echo "興味・関心のある分野-チェックボックス<br>";
// /* 自己紹介-入力フォーム */
// echo "自己紹介-入力フォーム<br>";
// /* 立ち上げているイベント */
// echo "立ち上げているイベント<br>";
// /* 参加しているイベント */
// echo "参加しているイベント<br>";
// /* お気に入り登録しているイベント */
// echo "お気に入り登録しているイベント<br>";

// $close_flag = mysql_close($link);

// if ($close_flag){
//     print('<p>切断に成功しました。</p>');
// }
//
?>

<table border="1">
<tr><th>名前</th><th>価格</th></tr>
<?php
  $pdo = new PDO("mysql:dbname=men", "root");
  $st = $pdo->query("SELECT * FROM udon");
  while ($row = $st->fetch()) {
    $name = htmlspecialchars($row['name']);
    $price = htmlspecialchars($row['price']);
    echo "<tr><td>$name</td><td>$price 円</td></tr>";
  }
?>
</table>
<<<<<<< HEAD

</body>
</html>

