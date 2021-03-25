<?php
session_start();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/shopping_cart.css">
  <title>Document</title>
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
      <div class="cart_count">

      </div>
      <div class="go_register">

      </div>
      <div class="container">
        
      </div>
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
          <li><a href="">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>
  </section>
  
  <script src="../js/shopping_cart.js"></script>
</body>
</html>