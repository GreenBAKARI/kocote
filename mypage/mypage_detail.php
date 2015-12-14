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
