<?php
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

// インスタンス化
$user = new User('create_user');

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

// ログインユーザの住所を取得
if(isset($login_user)) {
  $userAddress = $user->getUserAddress($login_user['id']);
}

if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
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
      <p>お名前 <span>※必須</span></p>
      <input type="text" name="name" id="name" value="<?php echo $userAddress['name'] ;?>">
      <div class="err">
        <?php if(isset($err['name'])) :?>
          <p class="err_msg"><?php echo '※'.$err['name'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 郵便番号に関する記述 -->
    <div class="postalCode">
      <p>郵便番号 <span>※必須</span></p>
      <input type="text" name="postalCode" id="postalCode" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');"
        value="<?php echo $userAddress['postalCode'] ;?>">
      <div class="err">
        <?php if(isset($err['postalCode'])) :?>
          <p class="err_msg"><?php echo '※'.$err['postalCode'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 住所に関する記述 -->
    <div class="address">
      <p>住所 <span>※必須</span></p>
      <input type="text" name="address" id="address" value="<?php echo $userAddress['address'] ;?>">
      <div class="err">
        <?php if(isset($err['address'])) :?>
          <p class="err_msg"><?php echo '※'.$err['address'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 電話番号に関する記述 -->
    <div class="tel">
      <p>電話番号 <span>※必須</span></p>
      <p class="desc">ご連絡の繋がる電話番号を記入して下さい。なんらかの不備があった場合ご連絡させて頂くことがございます。</p>
      <input type="tel" name="tel" id="tel" value="<?php echo $userAddress['tel'] ;?>">
      <div class="err">
        <?php if(isset($err['tel'])) :?>
          <p class="err_msg"><?php echo '※'.$err['tel'] ;?></p>
        <?php endif ;?>
      </div>
    </div>
    
    <!-- 登録ボタンに関する記述 -->
    <div class="submit">
      <input type="hidden" name="id" value="<?php echo $login_user['id'];?>">
      <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">
      <input type="submit" name="submit" id="submit" value="登録">
    </div>
  </form>
</main>


<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>