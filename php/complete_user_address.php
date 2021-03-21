<?php 
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// POSTで受け取った値を変数に格納
$userID = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

// POSTで受け取った値をセッションに格納
$_SESSION['name'] = $name;
$_SESSION['postalCode'] = $postalCode;
$_SESSION['address'] = $address;
$_SESSION['tel'] = $tel;

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
  $err['name'] = 'お名前を入力して下さい。';
}
if(mb_strlen($name) > 150) {
  $err['name'] = '150文字以内で入力して下さい。';
}
// バリデーション(郵便番号)
if(empty($postalCode)) {
  $err['postalCode'] = '郵便番号を入力して下さい。';
}
// バリデーション(住所)
if(empty($address)) {
  $err['address'] = '住所を入力して下さい。';
}
if(mb_strlen($address) > 50) {
  $err['address'] = '50文字以内で入力して下さい。';
}
// バリデーション(電話番号)
if(empty($tel)) {
  $err['tel'] = '電話番号を入力して下さい。';
}
$Regular_expressions_tel = '/^0[0-9]{9,10}\z/';
if(!preg_match($Regular_expressions_tel, $tel) && $tel) {
  $err['tel'] = '正しい電話番号を入力して下さい。';
}
$result = $user->checkUsersTel($tel);
if($result && $tel) {
  $err['tel'] = '既に同じ電話番号が存在します。';
}


// エラーが存在した時の処理
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./user_address.php');
  exit();
} else {
  // 住所登録完了後セッションに保存
  $user_address = $user->registerAddress($userID, $name, $postalCode, $address, $tel);
  $_SESSION['user_address'] = $user_address;
  header('Location: ./index.php');
  exit();
}