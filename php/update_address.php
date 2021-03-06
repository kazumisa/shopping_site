<?php
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

// インスタンス化
$user = new User('user');

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}

// 受け取った$_SESSION['name']を変数に格納
if(isset($_SESSION['name'])) {
  $name = $_SESSION['name'];

  unset($_SESSION['name']);
}
// 受け取った$_SESSION['postalCode']を変数に格納
if(isset($_SESSION['postalCode'])) {
  $postalCode = $_SESSION['postalCode'];

  unset($_SESSION['postalCode']);
}
// 受け取った$_SESSION['address']を変数に格納
if(isset($_SESSION['address'])) {
  $address = $_SESSION['address'];

  unset($_SESSION['address']);
}

?>
<?php define("title" ,"Milfin_update_address"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/update_address.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <div class="update">
    <span class="material-icons" id="update">update</span>
    <h3>配送先住所変更</h3>
  </div>

  <form action="./complete_update_address.php" method="POST" class="address_form">

    <!-- 名前に関する記述 -->
    <div class="name">
      <p>お名前</p>
      <input type="text" name="name" id="name" value="<?php echo isset($name) ? $name : $login_user['name']; ?>">
      <div class="err">
        <?php if(isset($err['name'])) :?>
          <p class="err_msg"><?php echo '※'.$err['name'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 郵便番号に関する記述 -->
    <div class="postalCode">
      <p>郵便番号 (ハイフン不要)</p>
      <input type="text" name="zip" id="postalCode" onKeyUp="AjaxZip3.zip2addr('zip','','address','address');"
        value="<?php echo isset($postalCode) ? $postalCode : $login_user['postalCode']; ?>">
      <div class="err">
        <?php if(isset($err['postalCode'])) :?>
          <p class="err_msg"><?php echo '※'.$err['postalCode']; ?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 住所に関する記述 -->
    <div class="address">
      <p>住所</p>
      <input type="text" name="address" id="address" value="<?php echo isset($address) ? $address : $login_user['address']; ?>">
      <div class="err">
        <?php if(isset($err['address'])) :?>
          <p class="err_msg"><?php echo '※'.$err['address']; ?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 登録ボタンに関する記述 -->
    <div class="submit">
      <input type="hidden" name="id" value="<?php echo $login_user['id']; ?>">
      <input type="hidden" name="token" value="<?php echo Dbc::h(Dbc::setToken()); ?>">
      <input type="submit" name="submit" id="submit" value="登録">
    </div>
  </form>
</main>

<script type="text/javascript" src="../js/ajaxzip3.js"></script>
<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>