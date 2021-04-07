<?php
session_start();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
} else {
  header('Location: ./index.php');
}

?>
<?php define("title" ,"Milfin_purchase_history"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/purchase_history.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<?php define("src1", "../js/common.js")?>
<?php define("src2", "../js/purchase_history.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>