<?php 
session_start();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
} else {
  header('Location: ./index.php');
}

$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);

?>
<?php define("title" ,"Milfin_complete_purchase"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/complete_purchase.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <p>注文を確定しました。注文内容の確認は購入履歴からできます。</p>
</main>

<?php define("src1", "../js/common.js")?>
<script src="../js/purchase_history.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>