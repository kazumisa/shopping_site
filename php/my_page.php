<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
} else {
  $login_user = $_SESSION['login_user'];

  $id = $login_user['id'];
  $userAddress = $user->getUserAddress($id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/my_page.css">
  <title>Document</title>
</head>
<body>
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
          <input type="text" name="serach" id="search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="submit" value="&#xf002;" class="fas">
      </form>
      </div>

      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
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
      <section class="email">
        <?php if(isset($login_user['email'])) :?>
          <?php echo $login_user['email'] ;?>
        <?php endif ;?>
      </section>
      <div class="container">
        <div class="account">
          <a href="./user_account.php">アカウント</a>
        </div>
        <?php if(isset($userAddress)) :?>
        <div class="address">
          <a href="">住所変更</a>
        </div>
        <?php endif ;?>
  
        <?php if(!isset($userAddress)) :?>
        <div class="address">
          <a href="./user_address.php">住所登録</a>
        </div>
        <?php endif ;?>
        <div class="purchase_history"> 
          <a href="">購入履歴</a>
        </div>
        <div class="question"> 
          <a href="">よくある質問</a>
        </div>
      </div>
    </main>
  </section>

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

  <script src="../js/my_page.js"></script>
</body>
</html>