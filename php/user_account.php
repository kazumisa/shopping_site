<?php 
session_start();
require_once('./dbc_create_user.php');

$user = new User();

// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
} else {
  $login_user = $_SESSION['login_user'];
  $id = $login_user['id'];
  $log_one = substr_replace($login_user['tel'], '-', 3, 0);
  $log_second = substr_replace($log_one, '-', 8, 0);
}

if(isset($_SESSION['user_address'])) {
  $userAddress = $user->getUserAddress($id);
  $sub_one = substr_replace($userAddress['tel'], '-', 3, 0);
  $sub_second = substr_replace($sub_one, '-', 8, 0);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/user_account.css">
  <title>Milfin_user_account</title>
</head>
<body>
  <section calss="sp-site">
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
      <div class="search">
        <form action="./complete_user_address.php" method="POST">
          <input type="text" name="serach" id="sp_search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="sp_submit" value="&#xf002;" class="fas">
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
      <div class="account">
        <span class="material-icons account_box">account_box</span>
        <h3>アカウント情報</h3>
      </div>
      <section class="infomation">
        <?php if(isset($login_user)) :?>
        <div class="user_info">
          <h3>ユーザ情報</h3>
          <div class="change">変更</div>
        </div>
        <table border="1">
          <tr>
            <th>メールアドレス</th>
            <td><?php echo User::h($login_user['email']) ;?></td>
          </tr>
          <tr>
            <th>生年月日</th>
            <td><?php echo User::h($login_user['birthday']) ;?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?php echo User::h($log_second) ;?></td>
          </tr>
        </table>
        <?php endif ?>

        <?php if(isset($_SESSION['user_address'])) :?>
        <div class="user_address">
          <h3>配送先住所</h3>
          <div class="change">変更</div>
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
        <?php endif ?>
      </section>
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

  <script src="../js/user_account.js"></script>
</body>
</html>