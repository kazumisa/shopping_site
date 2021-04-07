<?php
session_start();
require_once('../php/dbc_item.php');

// インスタンス化
$Item = new Item();

$items = $Item->getItemData();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}
?>
<?php define("title" ,"Milfin_favorite"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/favorite.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <div class="count_favorite">

  </div>
  <div class="container">
  
  </div>
</main>

<?php define("src1", "../js/common.js")?>
<script src="../js/favorite.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>