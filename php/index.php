<?php
session_start();
require_once('../php/dbc_item.php');

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

// インスタンス化
$Item = new Item();

// 商品検索機能
$search_word = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$search_items = $Item->getItem($search_word);

if(!$search_word) {
  // 商品一覧を最新の商品から30件
  $items = $Item->getItemData();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ショッピングサイト</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/swiper-bundle.min.css">
  <link rel="stylesheet" href="../css/index.css">
</head>
<body>
  <!-- スマートフォンサイト -->
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
          <input type="text" name="search" id="search" placeholder="何かお探しですか？" autocomplete="off">
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
      
      <!-- スライダー -->
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img class="main_pic" src="../img/clothing-store-984396_1920.jpg" alt="ショップの写真です">
          </div>
          <div class="swiper-slide">
            <img class="main_pic" src="../img/lan-deng-quddu_dZKkQ-unsplash.jpg" alt="ショップの写真です">
          </div>
          <div class="swiper-slide">
            <img class="main_pic" src="../img/nick-de-partee-5DLBoEX99Cs-unsplash.jpg" alt="ショップの写真です">
          </div>
          <div class="swiper-slide">
            <img class="main_pic" src="../img/priscilla-du-preez-dlxLGIy-2VU-unsplash.jpg" alt="ショップの写真です">
          </div>
          <div class="swiper-slide">
            <img class="main_pic" src="../img/keagan-henman-Won79_9oUEk-unsplash.jpg" alt="ショップの写真です">
          </div>
          <div class="swiper-slide">
            <img class="main_pic" src="../img/shop-906722_1920.jpg" alt="ショップの写真です">
          </div>
        </div>
        <div class="swiper-pagination"></div>
        <!-- <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div> -->
      </div>
    </header>

    <!-- 商品画像掲載処理 -->
    <main>
      <h3 class="title">新着アイテム</h3>
        <?php if(!$search_word) :?> 
          <div class="container">
            <?php foreach($items as $item) :?>
              <div class="box">
                <a href="./select_item.php?id=<?php echo $item['id'] ;?>">
                  <img src=".<?php echo $item['file_path'];?>" alt="商品の写真">
                </a>
                <span class="material-icons img_favorite" id="<?php echo $item['id'] ;?>">favorite</span>
                <div class="detail">
                  <p class="brand_name"><?php echo Item::h(Item::limited($item['brand_name'])) ;?></p>
                  <p class="item_name"><?php echo Item::h(Item::limited($item['item_name'])) ;?></p>
                  <p class="item_price"><?php echo Item::h("¥".number_format($item['item_price'])) ;?></p>
                </div>
              </div>
            <?php endforeach ;?>
          </div>
        <?php else :?>
          <?php if(!$search_items) :?>
            <p class="message">条件に一致する商品は見つかりませんでした。</p>
          <?php else :?>
            <div class="container">
              <?php foreach($search_items as $search_item) :?>
                <div class="box">
                  <a href="./select_item.php?id=<?php echo $search_item['id'] ;?>">
                    <img src=".<?php echo $search_item['file_path'];?>" alt="商品の写真">
                  </a>
                  <span class="material-icons img_favorite" id="<?php echo $search_item['id'] ;?>">favorite</span>
                  <div class="detail">
                    <p class="brand_name"><?php echo Item::h(Item::limited($search_item['brand_name'])) ;?></p>
                    <p class="item_name"><?php echo Item::h(Item::limited($search_item['item_name'])) ;?></p>
                    <p class="item_price"><?php echo Item::h("¥".number_format($search_item['item_price'])) ;?></p>
                  </div>
                </div>
              <?php endforeach ;?>
            </div>
          <?php endif ;?>
        <?php endif ;?>
      
    </main>
      

    <footer>
      <a href="">プライバシーポリシー</a>
      <a href="">特定商品取引法に基づく表記</a>
    </footer>
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
        <form action="./index.php" method="GET">
          <input type="text" name="search" id="search" placeholder="何かお探しですか？" autocomplete="off">
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

      <!-- 商品ターゲットと商品カテゴリー -->
      <div class="target_category">
        <ul class="target">
          <li class="target_person">すべて</li>
          <li class="target_person">メンズ</li>
          <li class="target_person">レディース</li>
          <li class="target_person">キッズ</li>
        </ul>
      </div>
    </header>
    <main>
      <h1 class="title">新着アイテム</h1>
        <?php if(!$search_word) :?> 
          <div class="container">
            <?php foreach($items as $item) :?>
              <div class="box">
                <a href="./select_item.php?id=<?php echo $item['id'] ;?>">
                  <img src=".<?php echo $item['file_path'];?>" alt="商品の写真">
                </a>
                <span class="material-icons img_favorite" id="<?php echo $item['id'] ;?>">favorite</span>
                <div class="detail">
                  <p class="brand_name"><?php echo Item::h(Item::limited($item['brand_name'])) ;?></p>
                  <p class="item_name"><?php echo Item::h(Item::limited($item['item_name'])) ;?></p>
                  <p class="item_price"><?php echo Item::h("¥".number_format($item['item_price'])) ;?></p>
                </div>
              </div>
            <?php endforeach ;?>
          </div>
        <?php elseif($search_word) :?>
          <?php if(!$search_items) :?>
            <p class="message">条件に一致する商品は見つかりませんでした。</p>
          <?php else :?>
            <div class="container">
              <?php foreach($search_items as $search_item) :?>
                <div class="box">
                  <a href="./select_item.php?id=<?php echo $search_item['id'] ;?>">
                    <img src=".<?php echo $search_item['file_path'];?>" alt="商品の写真">
                  </a>
                  <span class="material-icons img_favorite" id="<?php echo $search_item['id'] ;?>">favorite</span>
                  <div class="detail">
                    <p class="brand_name"><?php echo Item::h(Item::limited($search_item['brand_name'])) ;?></p>
                    <p class="item_name"><?php echo Item::h(Item::limited($search_item['item_name'])) ;?></p>
                    <p class="item_price"><?php echo Item::h("¥".number_format($search_item['item_price'])) ;?></p>
                  </div>
                </div>
              <?php endforeach ;?>
            </div>
          <?php endif ;?>
        <?php endif ;?>
    </main>

    <footer>
      <a href="">プライバシーポリシー</a>
      <a href="">特定商品取引法に基づく表記</a>
    </footer>
  </section>

  <script src="../js/swiper_bundle.min.js" defer></script>
  <script src="../js/index.js" defer></script>
</body>
</html>
