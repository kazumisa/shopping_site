<?php
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

// インスタンス化
$user = new User('user');

$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
// トークンバリデーション(XSS対策, 二重送信防止対策)
if(!$_SESSION['token'] || $_SESSION['token'] !== $token) {
  header('Location: ./index.php');
  exit();
}
// トークン削除
unset($_SESSION['token']);


// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) { // ログインユーザが存在しない時
  header('Location: ./login_form.php');
} else { 
  // ログインユーザが存在している時
  $login_user = $_SESSION['login_user'];
  if(isset($_SESSION['user_address'])) {
    $userAddress = $user->getUserAddress($login_user['id']);
  }
}

// 受け取った$_SESSION['err']を変数に格納
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
// 受け取った$_SESSION['tel']を変数に格納
if(isset($_SESSION['tel'])) {
  $tel = $_SESSION['tel'];

  unset($_SESSION['tel']);
}

?>
<?php define("title" ,"Milfin_user_address"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/user_address.css")?>
<?php include(dirname(__FILE__).'/header.php'); ?>

<main>
<?php var_dump($login_user) ;?>
  <!-- 配送先登録をしていない場合 -->
  <?php if(!isset($userAddress)) :?>
  <div class="personal_data">
    <span class="material-icons top_icon account_circle">account_circle</span>
    <h3>個人情報</h3>
  </div>

  <form action="./complete_user_address.php" method="POST" class="address_form">
    <!-- ユーザIDに関する記述 -->
    <input type="hidden" name="userID" value="<?php echo $login_user['id'];?>">

    <!-- 名前に関する記述 -->
    <div class="name">
      <p>お名前 <span>※必須</span></p>
      <input type="text" name="name" id="name" 
      <?php if(isset($name)):?>
      value="<?php echo Dbc::h($name) ;?>"
      <?php endif ;?>>
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
      <?php if(isset($postalCode)) :?>
        value="<?php echo Dbc::h($postalCode) ;?>"
      <?php endif ;?>>
      <div class="err">
        <?php if(isset($err['postalCode'])) :?>
          <p class="err_msg"><?php echo '※'.$err['postalCode'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 住所に関する記述 -->
    <div class="address">
      <p>住所 <span>※必須</span></p>
      <input type="text" name="address" id="address"
      <?php if(isset($address)) :?>
        value="<?php echo Dbc::h($address) ;?>"
      <?php endif ;?>>
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
      <input type="tel" name="tel" id="tel"
      <?php if(isset($tel)) :?>
        value="<?php echo Dbc::h($tel) ;?>"
      <?php endif ;?>>
      <div class="err">
        <?php if(isset($err['tel'])) :?>
          <p class="err_msg"><?php echo '※'.$err['tel'] ;?></p>
        <?php endif ;?>
      </div>
    </div>
    
    <!-- 登録ボタンに関する記述 -->
    <div class="submit">
      <input type="hidden" name="token" value="<?php echo Dbc::setToken() ;?>">
      <input type="submit" name="submit" id="submit" value="登録">
    </div>
  </form>
  <?php endif ;?>

  <!-- 既に配送先登録が済んでいる場合 -->
  <?php if(isset($userAddress)) :?>
    <div class="personal_data">
      <span class="material-icons home" id="home">home</span>
      <h3>配送先住所</h3>
    </div>
    <table border="1">
      <tr>
        <th>お名前</th>
        <td><?php echo Dbc::h($userAddress['name']) ;?></td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td><?php echo Dbc::h(Dbc::hyphenPostalCode($userAddress['postalCode'])) ;?></td>
      </tr>
      <tr>
        <th>住所</th>
        <td><?php echo Dbc::h($userAddress['address']) ;?></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><?php echo Dbc::h(Dbc::hyphenTel($userAddress['tel'])) ;?></td>
      </tr>
    </table>

    <form action="./complete_purchase.php" method="POST" class="purchase">
      <input type="hidden" name="token" value="<?php echo Dbc::setToken() ;?>">
      <input type="submit" class="btn" value="注文確定">
    </form>

    <div class="note">
      <p class="change_address">配送先住所を変更されたいお客様はお手数ですが<a href="./update_address.php" class="this">こちら</a>より変更をお願いします。</p>
      <p><span class="kome">※</span> 送料に関しましては、全て当ショップが負担させていただきます。</p>
      <p><span class="kome">※</span> 当ショップは代引きのみでの配送となっております。</p>
    </div>
  <?php endif ;?>
</main>

<?php define("src1", "../js/common.js")?>
<?php include(dirname(__FILE__).'/footer.php'); ?>