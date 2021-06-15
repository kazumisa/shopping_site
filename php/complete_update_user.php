<?php 
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

$user = new User('user');

$id = (int)filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$year  = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_SPECIAL_CHARS);
$month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_SPECIAL_CHARS);
$day   = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_SPECIAL_CHARS);
$birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$tel   = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$get_messages = filter_input(INPUT_POST, 'checkbox', FILTER_SANITIZE_SPECIAL_CHARS);
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
if(empty($birthday)) {
  // バリデーション(生年月日)
  $check = checkdate($month, $day, $year);
  if(!$check && (!empty($year) || !empty($month) || !empty($day))) {
    $err['birthday'] = '正しい生年月日を入力して下さい。';
  } else if(empty($year) && empty($month) && empty($day)) {
    $birthday = null;
  } else {
    $date = [$year, $month, $day];
    $birthday = implode('/', $date);
  }
}

// バリデーション(メールアドレス)
if(empty($email)) {
  $err['email'] = 'メールアドレスを入力して下さい。';
} else {
  $regular_expressions_email = '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/';
  if(preg_match($Regular_expressions_email, $email) === 0) {
    $err['email'] = '正しいメールアドレスを入力して下さい。'; 
  } else {
    $userData = $user->getUserData($id);
    if($userData['email'] !== $email) {
      $checkUsersEmail = $user->checkUsersEmail($email);
      if($checkUsersEmail['email'] === $email) {
        $err['email'] = '既に同じメールアドレスが登録されています。';
      }
    }
  }
}

// バリデーション(電話番号)
if(empty($tel)) {
  $tel = null;
} else {
  $Regular_expressions_tel = '/^0[0-9]{9,10}\z/';
  if(preg_match($Regular_expressions_tel, $tel) === 0) {
    $err['tel'] = '正しい電話番号を登録して下さい。';
  } else {
    $userData = $user->getUserData($id);
    if($userData['tel'] !== $tel) {
      $checkUsersTel = $user->checkUsersTel($tel);
      if($checkUsersTel['tel'] === $tel) {
        $err['tel'] = '既に同じ電話番号が登録されています。';
      }
    }
  }
}

$update_user = [
  'id'    => $id,
  'birthday' => $birthday,
  'email' => $email,
  'get_messages' => $get_messages,
  'tel'   => $tel,
];

// エラーが存在した時の挙動
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./update_user.php');
  exit();
} else {
  // 編集登録完了
  $user->updateUser($update_user);
  // 編集登録直後に編集した情報でログイン状態にする
  unset($_SESSION['login_user']);
  unset($_SESSION['year']);
  unset($_SESSION['month']);
  unset($_SESSION['day']);
  unset($_SESSION['email']);
  unset($_SESSION['tel']);
  $userData = $user->getUserData($id);
  $_SESSION['login_user'] = $userData;
  header('Location: ./index.php');
  exit();
}
?>