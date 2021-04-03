<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
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
  <link rel="stylesheet" href="../css/update_user.css">
  <title>Milfin_update_user</title>
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
        <h3>会員情報編集</h3>
      </div>

      <!-- フォームに関する記述 -->
      <form class="update_form" action="./complete_update_user.php" method="POST">

      <!-- メールアドレスに関する記述 -->
        <div class="email">
          <p class="title">メールアドレス <span>※必須</span></p>
          <input type="email" name="email" id="email" autocomplete="off"
          value="<?php echo $login_user['email']?>">
          
          <div class="err">
            <?php if(isset($err['email'])) :?>
              <p id="err_msg"><?php echo $err['email'] ;?></p>
            <?php endif ;?>
          </div>

          <div class="desc">
            <input type="checkbox" name="checkbox" id="checkbox" <?php echo $login_user['get_messages'] === "on" ? "checked" : " " ;?>>
            <p>クーポンおよびショップに関する情報を受け取る</p>
          </div>
        </div>


        <!-- 電話番号に関する記述 -->
        <div class="tel">
          <p class="title">電話番号</p>
          <p class="title_desc">ハイフンなし電話番号を記入して下さい</p>
          <input type="tel" name="tel" id="tel" autocomplete="off" value="<?php echo $login_user['tel']?>">

          <div class="err">
            <?php if(isset($err['tel'])) :?>
              <p id="err_msg"><?php echo '※'.$err['tel'] ;?></p>
            <?php endif ;?>
          </div>

          <p class="desc">※設定していただくとパスワードをお忘れの際、パスワードの設定がスムーズにおこなえます。</p>
        </div>

        <!-- ログインユーザのIDに関する記述 -->
        <input type="hidden" name="id" value="<?php echo $login_user['id'];?>">

        <!-- トークンに関する記述 -->
        <input type="hidden" name="token" value="<?php echo User::h(User::setToken());?>">

        <!-- 送信に関する記述 -->
        <div class="submit">
          <input type="submit" name="submit" id="submit" value="登録完了">
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
  
  <script src="../js/update_user.js"></script>
</body>
</html>