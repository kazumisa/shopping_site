<?php 
session_start();
require_once('./dbc_create_user.php');

$login_user = $_SESSION['login_user'];

$user = new User();

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$tel   = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$get_messages = filter_input(INPUT_POST, 'checkbox', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);

// バリデーション機能
// エラーが存在したら配列に格納
$err = array();
// バリデーション(メールアドレス)
if(empty($email)) {
  $err['email'] = 'メールアドレスを登録して下さい。';
}
$Regular_expressions_email = '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/';
if(!preg_match($Regular_expressions_email, $email) && $email) {
  $err['email'] = '正しいメールアドレスを入力して下さい。'; 
}
$all_emails = $user->getEmail();
foreach($all_emails as $only_email) {
  if($only_email['email'] === $email) {
    if($login_user['email'] !== $email) {
      $err['email'] = '既に同じメールアドレスが登録されています。';
    }
  }
}

// バリデーション(電話番号)
$Regular_expressions_tel = '/^0[0-9]{9,10}\z/';
if(!preg_match($Regular_expressions_tel, $tel) && $tel) {
  $err['tel'] = '正しい電話番号を登録して下さい。';
}

$all_tels = $user->getTel();
foreach($all_tels as $only_tel) {
  if($only_tel['tel'] === $tel) {
    if($login_user['tel'] !== $tel) {
      $err['tel'] = '既に同じ電話番号が登録されています。';
    }
  }
}

// エラーが存在した時の挙動
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./update.php');
  exit();
} else {
  // 編集登録完了
  $user->updateUser($id, $email, $get_messages, $tel);
  // 編集登録直後に編集した情報でログイン状態にする
  unset($_SESSION['login_user']);
  $userData = $user->getUserById($email);
  $_SESSION['login_user'] = $userData;
  header('Location: ./index.php');
}
?>