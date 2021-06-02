<?php
session_start();
require_once(dirname(__FILE__).'/dbc_item.php');

$id = $_GET['id'];

// インスタンス化
$item = new Item('items');

$itemData = $item->getItemDataById($id);

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}
?>
<?php define("title" ,"Milfin_shopping_cart"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/select_item.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <article class="main_top">
      <div class="item_pic">
        <img src=".<?php echo $itemData['file_path'];?>" alt="商品の写真">
      </div>
      <div class="item_content">
        <p class="brabd_name"><?php echo $itemData['brand_name'] ;?></p>
        <p class="item_name"><?php echo $itemData['item_name']  ;?></p>
        <p class="item_price"><?php echo "¥".number_format($itemData['item_price']) ;?></p>
      </div>

    <!-- お気に入り登録・解除 -->
    <div class="favorite">
      <span class="register_btn register" id="<?php echo $itemData['id']?>">お気に入り登録</span>
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

<?php define("src1", "../js/common.js")?>
<script src="../js/select_item.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>