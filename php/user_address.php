<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) { // ログインユーザが存在しない時
  header('Location: ./login_form.php');
} else { // ログインユーザが存在している時
  $login_user = $_SESSION['login_user'];
  $id = $login_user['id'];
  if(isset($_SESSION['user_address'])) {
    $userAddress = $user->getUserAddress($id);
    $sub_one = substr_replace($userAddress['tel'], '-', 3, 0);
    $sub_second = substr_replace($sub_one, '-', 8, 0);
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/user_address.css">
  <title>Milfin_register_user_address</title>
</head>
<body>
  <!-- スマートフォンサイト -->
  <section class="sp-site">
    <header>
    <div class="top">
        <h2 class="milfin">Milfin</h2>
        <nav>
          <div class="top_menu">
            <a href="../php/favorite.php" class="favorite">
              <span class="material-icons top_menu_icon" id="favorite">favorite</span>
            </a>
            <a href="../php/shopping_cart.php" class="shopping_cart">
              <span class="material-icons top_menu_icon" id="shopping_cart">shopping_cart</span>
            </a>
            <span class="material-icons top_menu_icon menu" id="menu">menu</span>
          </div>
        </nav>
      </div>
      <!-- 商品検索機能 -->
      <div class="search">
        <form action="./complete_user_address.php" method="POST">
          <input type="text" name="serach" id="search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="submit" value="&#xf002;" class="fas">
        </form>
      </div>

      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <?php if(!isset($login_user)) :?>   
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./create_user.php">新規登録</a></li>
          <li><a href="./login_form.php">ログイン</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
        </ul>
        <?php endif ;?>
        <?php if(isset($login_user)) :?>   
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./my_page.php">アカウント情報</a></li>
          <li><a href="">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>

    <main>
      <!-- 配送先登録をしていない場合 -->
      <?php if(!isset($userAddress)) :?>
      <div class="personal_data">
        <span class="material-icons top_icon account_circle">account_circle</span>
        <h3>個人情報</h3>
      </div>

      <form action="./complete_user_address.php" method="POST">
        <!-- ユーザIDに関する記述 -->
        <input type="hidden" name="userId" value="<?php echo $login_user['id'];?>">

        <!-- 名前に関する記述 -->
        <div class="name">
          <p>お名前 <span>※必須</span></p>
          <input type="text" name="name" id="name" 
          <?php if(isset($name)):?>
          value="<?php echo $name ;?>"
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
            value="<?php echo $postalCode ;?>"
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
            value="<?php echo $address ;?>"
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
            value="<?php echo $tel ;?>"
          <?php endif ;?>>
          <div class="err">
            <?php if(isset($err['tel'])) :?>
              <p class="err_msg"><?php echo '※'.$err['tel'] ;?></p>
            <?php endif ;?>
          </div>
        </div>

        <!-- トークンに関する記述 -->
        <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">

        <!-- 登録ボタンに関する記述 -->
        <div class="submit">
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
            <td><?php echo User::h($userAddress['name']) ;?></td>
          </tr>
          <tr>
            <th>郵便番号</th>
            <td><?php echo substr_replace(User::h($userAddress['postalCode']), '-', 3, 0) ;?></td>
          </tr>
          <tr>
            <th>住所</th>
            <td><?php echo User::h($userAddress['address']) ;?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?php echo User::h($sub_second) ;?></td>
          </tr>
        </table>

        <div class="btn">注文確定</div>

        <div class="note">
          <p class="change_address">配送先住所を変更されたいお客様はお手数ですが<a href="./user_account.php" class="this">こちら</a>より変更をお願いします。</p>
          <p><span class="kome">※</span> 送料に関しましては、全て当ショップが負担させていただきます。</p>
          <p><span class="kome">※</span> 当ショップは代引きのみでの配送となっております。</p>
        </div>
      <?php endif ;?>
    </main>
  </section>

  <section class="pc-site">
    <header>
      <div class="top">
        <h2 class="milfin">Milfin</h2>
        <nav>
          <div class="top_menu">
            <a href="../php/favorite.php" class="favorite">
              <span class="material-icons top_menu_icon" id="favorite">favorite</span>
            </a>
            <a href="../php/shopping_cart.php" class="shopping_cart">
              <span class="material-icons top_menu_icon" id="shopping_cart">shopping_cart</span>
            </a>
            <span class="material-icons top_menu_icon menu" id="menu">menu</span>
          </div>
        </nav>
      </div>
      <!-- 商品検索機能 -->
      <div class="search">
        <form action="">
          <input type="text" name="serach" id="search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="submit" value="&#xf002;" class="fas">
        </form>
      </div>
      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <?php if(!isset($login_user)) :?>
        <ul>
          <li><a href="./create_user.php">新規登録</a></li>
          <li><a href="./login_form.php">ログイン</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
        </ul>
        <?php endif ;?>
        <?php if(isset($login_user)) :?>   
        <ul>
          <li><a href="./my_page.php">アカウント情報</a></li>
          <li><a href="">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>


      </div>
    </header>
  </section>
  
  <script src="../js/user_address.js"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</body>
</html>