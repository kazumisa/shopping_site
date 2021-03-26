<?php
session_start();
require_once('./php/dbc_item.php');

// インスタンス化
$items = new Item();

// エラーが存在した場合、変数に格納
if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}

// ページ遷移の際に受け取ったセッションが存在した場合、変数に格納
if(isset($_SESSION['brand_name'])) {
  $brand_name = $_SESSION['brand_name'];

  unset($_SESSION['brand_name']);
} 
if(isset($_SESSION['item_name'])) {
  $item_name = $_SESSION['item_name'];

  unset($_SESSION['item_name']);
}
if(isset($_SESSION['item_detail'])) {
  $item_detail = $_SESSION['item_detail'];

  unset($_SESSION['item_detail']);
}
if(isset($_SESSION['item_price'])) {
  $item_price = $_SESSION['item_price'];

  unset($_SESSION['item_price']);
}
if(isset($_SESSION['target'])) {
  $target = $_SESSION['target'];

  unset($_SESSION['target']);
}
if(isset($_SESSION['category'])) {
  $category = $_SESSION['category'];

  unset($_SESSION['category']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./administractor.css">
  <title>Milfin_Administrator_page</title>
</head>
<body>
  <header>
    <h1 class="title">Milfin<span>管理者専用ページ</span></h1>    
  </header>
  <main>
    <!-- フォームに関する記載 -->
    <form enctype="multipart/form-data" action="./administrator_register_item.php" method="POST">
      <table border="1" width="100%">
        <!-- 写真に関する記載 -->
        <tr>
          <th>商品写真</th>
          <td>
            <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
            <input type="file" name="file" accept="image/*" id="file">
            <?php if(isset($err['file'])) :?>
              <p class="err_msg"><?php echo $err['file'] ;?></p>
            <?php endif ;?>
          </td>

        </tr>
        <!-- ブランド名に関する記載 -->
        <tr>
          <th>ブランド名</th>
          <td>
            <input type="text" name="brand_name" id="brand_name" 
            <?php if(isset($brand_name)) :?>
            value="<?php echo Item::h($brand_name) ?>"
            <?php endif ;?>>
            <?php if(isset($err['brand_name'])) :?>
              <p class="err_msg"><?php echo $err['brand_name'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- 商品名に関する記載 -->
        <tr>
          <th>商品名</th>
          <td>
            <input type="text" name="item_name" id="item_name"
            <?php if(isset($item_name)) :?>
            value="<?php echo Item::h($item_name) ;?>"
            <?php endif ;?>>
            <?php if(isset($err['item_name'])) :?>
              <p class="err_msg"><?php echo $err['item_name'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- 商品価格に関する記載 -->
        <tr>
          <th>商品価格</th>
          <td>
            <input type="text" name="item_price" id="item_price" 
            <?php if(isset($item_price)) :?> 
            value="<?php echo Item::h($item_price) ;?>"
            <?php endif ;?>>
            <?php if(isset($err['item_price'])) :?>
              <p class="err_msg"><?php echo $err['item_price'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- ターゲットに関する記載 -->
        <tr>
          <th>ターゲット</th>
          <td>
            <select name="target" id="target">
              <option class="target" value="メンズ">メンズ</option>
              <option class="target" value="レディース">レディース</option>
              <option class="target" value="ユニセックス">ユニセックス</option>
              <option class="target" value="キッズ">キッズ</option>
            </select>
            <?php if(isset($err['target'])) :?>
              <p class="err_msg"><?php echo $err['target'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- カテゴリに関する記載 -->
        <tr>
          <th>カテゴリ</th>
          <td>
            <select name="category" id="category">
              <option value="Tシャツ">Tシャツ</option>
              <option value="パンツ">パンツ</option>
              <option value="スカート">スカート</option>
              <option value="スーツ">スーツ</option>
              <option value="デニム">デニム</option>
              <option value="ポロシャツ">ポロシャツ</option>
            </select>
            <?php if(isset($err['catygory'])) :?>
              <p class="err_msg"><?php echo $err['catygory'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- 商品説明に関する記載 -->
        <tr>
          <th>商品説明</th>
          <td>
            <textarea name="item_detail" id="item_detail" cols="80" rows="10"><?php if(isset($item_detail)) :?><?php echo Item::h($item_detail) ;?><?php endif ;?></textarea>
            <?php if(isset($err['item_detail'])) :?>
            <p class="err_msg"><?php echo $err['item_detail'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>

        <!-- 商品在庫に関する記載 -->
        <tr>
          <th>商品在庫</th>
          <td>
            <select name="stock" id="stock">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
            </select>
            <?php if(isset($err['stock'])) :?>
              <p class="err_msg"><?php echo $err['stock'] ;?></p>
            <?php endif ;?>
          </td>
        </tr>
      </table>
      
      <!-- トークンに関する記述 -->
      <input type="hidden" name="token" value="<?php echo Item::h(Item::setToken()) ?>">

      <!-- 登録に関する記述 -->
      <input type="submit" name="submit" id="submit" value="商品登録">
    </form>
  </main>
</body>
</html>