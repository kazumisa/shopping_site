<?php
session_start();
require_once(dirname(__FILE__).'/dbc_item.php');

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

// インスタンス化
$Item = new Item('items');

// 新着アイテムを最新の商品から20件
if(!isset($search_word)) {
  $items = $Item->getItemData();
}

// 商品検索機能
$search_word = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($search_word)) {
  $search_items = $Item->searchItem($search_word);
}

?>
<?php define("title" ,"Milfin"); ?>
<link href="../css/swiper-bundle.min.css" rel="stylesheet">
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/index.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

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

<!-- PCサイト -->
<section class="pc-site">
  <!-- 商品ターゲットと商品カテゴリー -->
  <div class="target_category">
    <ul class="target">
      <li class="target_person">すべて</li>
      <li class="target_person">メンズ</li>
      <li class="target_person">レディース</li>
      <li class="target_person">キッズ</li>
    </ul>
  </div>
</section>


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

<?php define("src1", "../js/common.js"); ?>
<script src="../js/swiper_bundle.min.js" defer></script>
<script src="../js/index.js" defer></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>
