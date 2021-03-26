<?php
session_start();
require_once('./php/dbc_item.php');

// インスタンス化
$items = new Item();

// トークンバリデーション(XSS対策, 二重送信防止対策)
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./administrator.php');
  exit();
}

// トークン削除
unset($_SESSION['token']);

// ファイル関連の取得
$file = $_FILES['file'];
$file_name = basename($file['name']);
$file_size = $file['size'];
$file_tmp_path = $file['tmp_name'];
$file_err  = $file['error'];
$upload_dir = './img/'; 
// $save_file_name = date('YmdHis').$file_name;
$save_file_name = $file_name;
$save_path = $upload_dir.$save_file_name;

// POSTで受け取った値をそれぞれ変数に格納
$brand_name = filter_input(INPUT_POST, 'brand_name', FILTER_SANITIZE_SPECIAL_CHARS);
$item_name  = filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_SPECIAL_CHARS);
$item_detail = filter_input(INPUT_POST, 'item_detail', FILTER_DEFAULT );
$stock = (int)filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_SPECIAL_CHARS);
$item_price = (int)filter_input(INPUT_POST, 'item_price', FILTER_SANITIZE_SPECIAL_CHARS);
$target = filter_input(INPUT_POST, 'target', FILTER_SANITIZE_SPECIAL_CHARS);
$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);

// ページ遷移で使用するためセッション変数に格納
$_SESSION['brand_name']  = $brand_name;
$_SESSION['item_name']   = $item_name;
$_SESSION['item_detail'] = $item_detail;
$_SESSION['item_price']  = $item_price;
$_SESSION['target']      = $target;
$_SESSION['category']    = $category;

// バリデーション
// エラーメッセージを格納するための配列を用意
$err = array();
// ファイルのバリデーション
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext  = pathinfo($file_name, PATHINFO_EXTENSION);

if(!in_array(strtolower($file_ext), $allow_ext)) {
  $err['file'] = '画像ファイルを選択して下さい';
}
if($file_size > 5242880 || $file_err === 2) {
  $err['file'] = 'ファイルサイズは5MB未満にして下さい';
}

// バリデーション(ブランド名)
if(empty($brand_name)) {
  $err['brand_name'] = 'ブランド名を登録して下さい。';
}

// バリデーション(商品名)
if(empty($item_name)) {
  $err['item_name'] = '商品名を登録して下さい。';
}

// バリデーション(商品価格)
if(empty($item_price)) {
  $err['item_price'] = '商品価格を登録して下さい。';
}

// バリデーション(商品説明)
if(empty($item_detail)) {
  $err['item_detail'] = '商品説明を入力して下さい。';
}

// バリデーション(ターゲット)
if(empty($target)) {
  $err['target'] = '該当するターゲットを選択して下さい。';
}

// バリデーション(カテゴリ)
if(empty($category)) {
  $err['category'] = '該当するカテゴリを選択して下さい。';
}

// バリデーション(商品在庫)
if(empty($stock)) {
  $err['stock'] = '該当する在庫数を選択して下さい。';
}

if(count($err) === 0) {
  // HTTP POSTによりアップロードされたかどうか確認
  if(is_uploaded_file($file_tmp_path)) {
    if(move_uploaded_file($file_tmp_path, $save_path)) {
      // 商品登録処理
      $result = $items->registerItem($file_name, $save_path, $brand_name, $item_name, $item_detail, $item_price, $target, $category, $stock); 
    } else {
      $err['file'] = "ファイルがアップロードできませんでした。";
      $_SESSION['err'] = $err;
      header('Location: ./administrator.php');
      exit();
    }
  } else {
    $err['file'] = "アップロードできませんでした。";
    $_SESSION['err'] = $err;
    header('Location: ./administrator.php');
    exit();
  }
} else {
  // エラーが存在した時の処理
  $_SESSION['err'] = $err;
  header('Location: ./administrator.php');
  exit();
}

// セッション削除
unset($_SESSION['err']);
unset($_SESSION['brand_name']);
unset($_SESSION['item_name']);
unset($_SESSION['item_detail']);
unset($_SESSION['item_price']);
unset($_SESSION['target']);
unset($_SESSION['category']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./administrator_complete_register_item.css">
  <title>administrator_complete_register_item</title>
</head>
<body>
  <header>
    <h1 class="title">Milfin<span>管理者専用ページ</span></h1>    
  </header>
  <main>
    <h2>商品登録が完了しました。</h2>
    <div class="btn">商品登録画面へ戻る</div>
  </main>

  <script src="./administrator_complete_register_item.js"></script>
</body>
</html>