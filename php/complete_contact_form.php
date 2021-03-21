<?php
session_start();

// POSTで受け取った値を変数に格納
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);

// POSTで受け取った値をセッションに格納
$_SESSION['email'] = $email;
$_SESSION['category'] = $category;
$_SESSION['content'] = $content;

// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);

// バリデーション機能
$err = array(); // エラーメッセージを格納する配列
// バリデーション(メールアドレス)
if(empty($email)) {
  $err['email'] = 'メールアドレスを記入して下さい。';
}
$Regular_expressions_email = '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/';
if(!preg_match($Regular_expressions_email, $email) && $email) {
  $err['email'] = '正しいメールアドレスを記入して下さい。'; 
}
// バリデーション(カテゴリ)
if(empty($category)) {
  $err['category'] = 'カテゴリを選択して下さい。';
}
// バリデーション(メールアドレス)
if(empty($content)) {
  $err['content'] = 'お問い合わせ内容を記入して下さい。';
}

// エラーが存在した時の処理
if(count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: ./contact_form.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Milifin_complete_contact_form</title>
</head>
<body>
  <section class="sp-site">
    <p>お問い合わせ内容が送信されました。ご記入いただいたメールアドレス宛てに回答内容を送信さてていただきます。回答内容のご連絡に関しましては数日間かかる場合がございます。ご了承お願いいたします。</p>
  </section>
</body>
</html>