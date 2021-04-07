<?php

$nowPage = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$index_php = "localhost:8888/php/index.php";
$create_user_php = "localhost:8888/php/create_user.php";
$login_form_php = "localhost:8888/php/login_form.php";
$contact_form_php = "localhost:8888/php/contact_form.php";
$purchase_history_php = "localhost:8888/php/purchase_history.php";
$user_account_php = "localhost:8888/php/user_account.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="<?php echo href1 ;?>" rel="stylesheet">
  <link href="<?php echo href2 ;?>" rel="stylesheet">
  <title><?php echo title ;?></title>
</head>
<body>
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
        <input type="text" name="search" id="item_search" placeholder="何かお探しですか？" autocomplete="off">
        <input type="submit" id="item_submit" value="&#xf002;" class="fas">
    </form>
    </div>

    <!-- タブメニュー -->
    <div class="mask"></div>
    <div class="window">
    <?php if(!isset($login_user)) :?>   
        <ul>
          <?php if($nowPage !== $index_php) :?>
            <li><a href="./index.php">トップへ</a></li>
          <?php endif ;?>
          <?php if($nowPage !== $create_user_php) :?>
            <li><a href="./create_user.php">新規登録</a></li>
          <?php endif ;?>
          <?php if($nowPage !== $login_form_php) :?>
            <li><a href="./login_form.php">ログイン</a></li>
          <?php endif ;?>
          <?php if($nowPage !== $contact_form_php) :?>
            <li><a href="./contact_form.php">お問い合わせ</a></li>
          <?php endif ;?>
        </ul>
        <?php endif ;?>

        <?php if(isset($login_user)) :?>   
        <ul>
          <?php if($nowPage !== $index_php) :?>
            <li><a href="./index.php">トップへ</a></li>
          <?php endif ;?>
          <?php if($nowPage !== $purchase_history_php) :?>
            <li><a href="./purchase_history.php">購入履歴</a></li>
          <?php endif ;?>
          <?php if($nowPage !== $user_account_php) :?>
            <li><a href="./my_page.php">アカウント情報</a></li>
          <?php endif ;?>
            <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
    </div>
  </header>
  