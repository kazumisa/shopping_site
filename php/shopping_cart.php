<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

?>
<?php define("title" ,"Milfin_shopping_cart"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/shopping_cart.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <form action="./user_address.php" method="POST">
    <div class="cart_count">

    </div>
    <div class="go_register">

    </div>
    <div class="container">
      
    </div>

    <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">
  </form>
</main>

<?php define("src1", "../js/common.js")?>
<script src="../js/shopping_cart.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>