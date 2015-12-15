<?php
//掲示板作成
function bbs_make($bulletin_title, $category){
  //とりあえず足してみただけ
  return $bulletin_title + $category;
}

//ここで引数指定
echo "↓bbs_make関数に渡した引数(123と234)をとりあえず足しただけ<br />";
echo bbs_make(123, 234);
?>

<!-- フロントやけどとりあえず -->
<form action="bulletin.php" method="get">
<select name = "category">
 <option>食</option>
 <option>芸術</option>
 <option>スポーツ</option>
</select>
<input type="submit">
</form>
