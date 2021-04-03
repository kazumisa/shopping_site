<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// POSTで受け取った各要素を変数に格納
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

// ページ遷移で使用するためセッション変数に格納
$_SESSION['email'] = $email;

// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);

// エラーが存在したら配列に格納
$err = array();

// バリデーション(メールアドレス)
if(empty($email)) {
  $err['email'] = 'メールアドレスを入力して下さい。';
}

// バリデーション(パスワード)
if(empty($password)) {
  $err['password'] = 'パスワード入力して下さい。';
}

if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./login_form.php');
  exit();
} else {
  // ログイン処理
  $login = $user->login($email, $password);
  if($login) {
    $id = $_SESSION['login_user']['id'];
    $userAddress = $user->getUserAddress($id);
    if($userAddress) {
      $_SESSION['user_address'] = $userAddress;
    }
    header('Location: ./index.php');
  } else {
    header('Location: ./login_form.php');
    exit();
  }
} 