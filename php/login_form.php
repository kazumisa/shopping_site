<?php
session_start();
require_once('./dbc_create_user.php');

$user = new User();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
}

// 受け取った$_SESSION['err']を変数に格納
if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}
if(isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  unset($_SESSION['email']);
}
if(isset($_SESSION['login_err'])) {
  $login_err = $_SESSION['login_err'];

  unset($_SESSION['login_err']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Milfin_login_form</title>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/login_form.css">
</head>
<body>
  <section class="sp-site">
    <header>
    <!-- トップ -->
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
      <form action="./complete_login_form.php" method="POST">
        <input type="text" name="serach" id="sp_search" placeholder="何かお探しですか？" autocomplete="off">
        <input type="submit" name="submit" id="sp_submit" value="&#xf002;" class="fas">
      </form>
    </div>
    <!-- タブメニュー -->
    <div class="mask"></div>
    <div class="window">
      <ul>
        <li><a href="./index.php">トップへ</a></li>
        <li><a href="./create_user.php">新規登録</a></li>
        <li><a href="">よくある質問</a></li>
        <li><a href="./contact_form.php">お問い合わせ</a></li>
      </ul>
    </div>
    </header>

    <main>
      <div class="login">
        <span class="material-icons" id="login">login</span>
        <h3>ログイン</h3>
      </div>
  
      <!-- ログインフォームに関する記述 -->
      <form action="./complete_login_form.php" method="POST" class="login_form">
  
        <!-- メールアドレスに関する記述 -->
        <div class="email">
          <input type="email" name="email" id="email" placeholder="メールアドレス" 
          <?php if(isset($email)):?>
          value="<?php echo $email ;?>"
          <?php endif ;?>>
  
          <div class="err">
            <?php if(isset($err['email'])) :?>
              <p id="err_msg"><?php echo $err['email'] ;?></p>
            <?php endif ;?>
          </div>
          <div class="login_err">
            <?php if(isset($login_err['email'])) :?>
              <p id="login_err_msg"><?php echo $login_err['email'] ;?></p>
            <?php endif ;?>
          </div>
        </div>
  
        <!-- パスワードに関する記述 -->
        <div class="password">
          <input type="password" name="password" id="password" placeholder="パスワード">
  
          <div class="err">
            <?php if(isset($err['password'])) :?>
              <p id="err_msg"><?php echo $err['password'];?></p>
            <?php endif ;?>
          </div>
          <div class="login_err">
            <?php if(isset($login_err['password'])) :?>
              <p id="login_err_msg"><?php echo $login_err['password'] ;?></p>
            <?php endif ;?>
          </div>
        </div>
  
        <!-- トークンに関する記述 -->
        <div class="token">
          <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">
        </div>
  
        <!-- 送信に関する記述 -->
        <div class="submit">
          <input type="submit" name="submit" id="login_submit" value="ログイン">
        </div>
      </form>
  
      <div class="forget">
        <a href="./contact_form.php" id="forget">メールアドレス・パスワードをお忘れですか？</a>
      </div>
      <div class="new">
        <a href="./create_user.php" id="new">初めてご利用の方 (新規会員登録)</a>
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
          <input type="text" name="serach" id="pc_search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="pc_submit" value="&#xf002;" class="fas">
        </form>
      </div>
      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <?php if(!isset($login_user)) :?>
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./create_user.php">新規登録</a></li>
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
          <li><a href="./logout.php" id="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>
  </section>

  <script src="../js/login_form.js"></script>
</body>
</html>