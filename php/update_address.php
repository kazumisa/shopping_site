<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/update_address.css">
  <title>Milfin_update_address</title>
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
        <form action="./index.php" method="GET" id="form">
          <input type="text" name="search" id="sp_search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="sp_submit" value="&#xf002;" class="fas">
      </form>
      </div>
      
      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <?php if(isset($login_user)) :?>   
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./user_account.php">アカウント情報</a></li>
          <li><a href="./purchase_history.php">購入履歴</a></li>
          <!-- <li><a href="">よくある質問</a></li> -->
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>

    <main>
      <div class="update">
        <span class="material-icons" id="update">update</span>
        <h3>配送先住所変更</h3>
      </div>

      <form action="./complete_update_address.php" method="POST" class="address_form">
        <!-- ユーザIDに関する記述 -->
        <input type="hidden" name="id" value="<?php echo $login_user['id'];?>">

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

        <!-- トークンに関する記述 -->
        <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">

        <!-- 登録ボタンに関する記述 -->
        <div class="submit">
          <input type="submit" name="submit" id="submit" value="登録">
        </div>
      </form>
    </main>
  </section>

  <!-- PCサイト -->
  <section class="pc-site">
    <header>
      <div class="top">
        <h1 class="milfin">Milfin</h1>
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
          <li><a href="./purchase_history.php">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>
  </section>
  
  <script src="../js/update_address.js"></script>
</body>
</html>