<?php 
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

// インスタンス化
$user = new User('user');

// POSTで受け取った値を変数に格納
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$postalCode = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

$_SESSION['name'] = $name;
$_SESSION['postalCode'] = $postalCode;
$_SESSION['address'] = $address;


// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);

// バリデーション機能
$err = array(); // エラーメッセージを格納する配列
// バリデーション(お名前)
if(empty($name)) {
  $name = null;
} else {
  if(mb_strlen($name) >= 150) {
    $err['name'] = '150文字以内で入力して下さい。';
  }
}

// バリデーション(郵便番号)
if(empty($postalCode)) {
  $postalCode = null;
} else {
  $regular_expression_postalCode = '/^\d{7}$/';
  if(preg_match($regular_expression_postalCode, $postalCode) === 0) {
    $err['postalCode'] = '正しい郵便番号を入力して下さい。';
  }
}

// バリデーション(住所)
if(empty($address)) {
  $address = null;
} else {
  if(mb_strlen($address) >= 50) {
    $err['address'] = '50文字以内で入力して下さい。';
  }
}

$update_address = [
  'id'         => $id,
  'name'       => $name,
  'postalCode' => $postalCode,
  'address'    => $address,
];

// エラーが存在した時の処理
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./update_address.php');
  exit();
} else {
  // 編集登録完了
  $user->updateAddress($update_address);
  // 編集登録直後に編集した情報でログイン状態にする
  unset($_SESSION['login_user']);
  unset($_SESSION['name']);
  unset($_SESSION['postalCode']);
  unset($_SESSION['address']);
  $userData = $user->getUserData($id);
  $_SESSION['login_user'] = $userData;
  header('Location: ./index.php');
  exit();
}