<?php
if (@$_GET['category']){
  $category = htmlspecialchars($_GET['category']);
  echo "{$category}をせんたく";
}else{
echo "ここは掲示板一覧建設予定地です。<br />";
echo "分類が選択されていません。";


}
 ?>
