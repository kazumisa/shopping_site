<?php
session_start();
require_once('./dbc_item.php');

$id = $_GET['id'];

// インスタンス化
$item = new Item();

$itemData = $item->getItemDataById($id);

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
  <link rel="stylesheet" href="../css/select_item.css">
  <title>Milfin_user_select_item</title>
</head>
<body>
  <section class="sp-site">
    <header>
      <!-- トップ -->
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
      <article class="main_top">
        <div class="item_pic">
          <img src=".<?php echo $itemData['file_path'];?>" alt="商品の写真">
        </div>
        <div class="item_content">
          <p class="brabd_name"><?php echo $itemData['brand_name'] ;?></p>
          <p class="item_name"><?php echo $itemData['item_name']  ;?></p>
          <p class="item_price"><?php echo "¥".$itemData['item_price'] ;?></p>
        </div>

        <!-- お気に入り登録・解除 -->
        <div class="favorite">
          <span class="register_btn register">お気に入り登録</span>
        </div>

        <!-- 買い物かごに入れる処理 -->
        <div class="shopping_cart">
          <span class="shopping_cart_btn">買い物かごに入れる</span>  
        </div> 
      </article>
      
      <article class="main_middle">
        <div class="off">
          <p class="item_title">アイテム説明</p>
          <div class="upper_triangle"></div>
        </div>
        <div class="on hide">
          <p class="item_title">アイテム説明</p>
          <div class="lower_triangle"></div>
        </div>

        <div class="item_detail hide">
          <p><?php echo nl2br($itemData['item_detail']) ;?></p>
        </div>
        <div class="item_size_color_off">
          <p class="size_color">サイズとカラー</p>
          <div class="upper_triangle"></div>
        </div>
        <div class="item_size_color_on hide">
          <p class="size_color">サイズとカラー</p>
          <div class="lower_triangle"></div>
        </div>
      </article>
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

  <script src="../js/select_item.js"></script>
</body>
</html>