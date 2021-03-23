<?php 
session_start();
require_once('./dbc_item.php');

// インスタンス化
$Item = new Item() ;

// POSTで受け取った各要素を変数に格納
$item = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

// // トークンバリデーション(XSS対策, 二重送信防止対策)
// if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
//   header('Location: ./index.php');
//   exit();
// }
// // トークン削除
// unset($_SESSION['token']);

// $getItem = $Item->getItem($item); 
// if($getItem) {
//   $_SESSION['item'] = $getItem;
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php echo $item ;?>
</body>
</html>