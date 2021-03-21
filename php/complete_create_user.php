<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// POSTで受け取った各要素を変数に格納
$year  = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_SPECIAL_CHARS);
$month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_SPECIAL_CHARS);
$day   = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$tel   = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$get_messages = filter_input(INPUT_POST, 'checkbox', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password_conf = filter_input(INPUT_POST, 'password_conf', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

// ページ遷移で使用するためセッション変数に格納
$_SESSION['year']  = $year;
$_SESSION['month'] = $month;
$_SESSION['day']   = $day;
$_SESSION['email'] = $email;
$_SESSION['tel']   = $tel;

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
// バリデーション(生年月日)
$check = checkdate($month, $day, $year);
if(!$check && (!empty($year) || !empty($month) || !empty($day))) {
  $err['birthday'] = '正しい生年月日を登録して下さい。';
} else {
  $date = [$year, $month, $day];
  $birthday = implode('-', $date);
}

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
    $err['email'] = '既に同じメールアドレスが登録されています。';
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
    $err['tel'] = '既に同じ電話番号が登録されています。';
  }
}

// バリデーション(パスワード)
if(empty($password)) {
  $err['password'] = 'パスワードを登録して下さい。';
}
$Regular_expressions_password = '/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i';
if(!preg_match($Regular_expressions_password, $password) && $password) {
  $err['password'] = '半角英数字をそれぞれ1種類以上含む8文字以上100文字以下で登録して下さい。';
}

// バリデーション(確認用パスワード)
if(empty($password_conf)) {
  $err['password_conf'] = '確認用パスワードを入力して下さい。';
}
if($password_conf !== $password && $password) {
  $err['password_conf'] = '確認用パスワードが異なります。';
}

// エラーが存在した時の挙動
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./create_user.php');
  exit();
} else {
  // 新規登録完了
  $user->createUser($birthday, $email, $get_messages, $tel, $password);
  // 新規登録直後にログイン状態にする
  $userData = $user->getUserById($email);
  $_SESSION['login_user'] = $userData;
  header('Location: ./index.php');
}