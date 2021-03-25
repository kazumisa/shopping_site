<?php
session_start();
require_once('./dbc.php');

$token = new Dbc();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

// 受け取った$_SESSION['err']を変数に格納
if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}
// 受け取った$_SESSION['email']を変数に格納
if(isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  unset($_SESSION['email']);
}
// 受け取った$_SESSION['category']を変数に格納
if(isset($_SESSION['category'])) {
  $category = $_SESSION['category'];

  unset($_SESSION['category']);
}
// 受け取った$_SESSION['content']を変数に格納
if(isset($_SESSION['content'])) {
  $content = $_SESSION['content'];

  unset($_SESSION['content']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/contact_form.css">
  <title>Milfin_contact_form</title>
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
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./create_user.php">新規登録</a></li>
          <li><a href="./login_form.php">ログイン</a></li>
          <li><a href="">よくある質問</a></li>
        </ul>
        <?php endif ;?>
        <?php if(isset($login_user)) :?>   
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./my_page.php">アカウント情報</a></li>
          <li><a href="">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./logout.php" class="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>
    <main>
      <div class="contact">
        <span class="material-icons contact_support">contact_support</span>
        <h3>お問い合わせ</h3>
      </div>
      <div class="questions">
        <p>よくある質問は<a href="">こちら</a></p>
        <!-- <span class="material-icons arrow_right_alt">arrow_right_alt</span> -->
      </div>
      <form action="./complete_contact_form.php" method="POST">

        <!-- メールアドレスに関する記述 -->
        <div class="email">
          <input type="email" name="email" id="email" placeholder="メールアドレス" 
          <?php if(isset($email)) :?>
            value="<?php echo $email ;?>"
          <?php endif ;?>>
          <div class="err">
            <?php if(isset($err['email'])) :?>
            <p class="err_msg"><?php echo  '※'.$err['email'] ;?></p>
            <?php endif ;?>
          </div>
        </div>

        <!-- カテゴリに関する記述 -->
        <div class="category">
          <p>カテゴリから該当する項目を選択して下さい。</p>
          <!-- 初めてこのページを開いた時に表示する処理 -->
          <?php if(!isset($category)) :?>
          <select name="category" id="category">
            <option value="商品について">商品について</option>
            <option value="配送について">配送について</option>
            <option value="返品について">返品について</option>
            <option value="アカウント情報について">アカウントについて</option>
            <option value="その他">その他</option>
          </select>
          <?php endif ;?>

          <!-- 送信を押して不備などが発生した時に表示する処理 -->
          <?php if(isset($category)) :?>
          <select name="category" id="category">
            <option value="商品について" <?php if($category === '商品について') echo "selected";?>>商品について</option>
            <option value="配送について" <?php if($category === '配送について') echo "selected";?>>配送について</option>
            <option value="返品について" <?php if($category === '返品について') echo "selected";?>>返品について</option>
            <option value="アカウント情報について" <?php if($category === 'アカウント情報について') echo "selected";?>>アカウントについて</option>
            <option value="その他"<?php if($category === 'その他') echo "selected";?>>その他</option>
          </select>
          <?php endif ;?>

          <div class="err">
            <?php if(isset($err['category'])) :?>
            <p class="err_msg"><?php echo '※'.$err['category'] ;?></p>
            <?php endif ;?>
          </div>
        </div>

        <!-- お問い合わせ内容に関する記述 -->
        <div class="content">
          <textarea name="content" id="content" placeholder="お問い合わせ内容を記入して下さい"><?php if(isset($content)) :?><?php echo $content;?><?php endif?></textarea>

          <div class="err">
            <?php if(isset($err['content'])) :?>
              <p class="err_msg"><?php echo '※'.$err['content'] ;?></p>
            <?php endif ;?>
          </div>
        </div>

        <!-- トークンに関する記述 -->
        <input type="hidden" name="token" value="<?php echo Dbc::h(Dbc::setToken()) ;?>">

        <!-- 送信ボタンに関する記述 -->
        <div class="submit">
          <input type="submit" name="submit" id="submit" value="送信">
        </div>

      </form>
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


  <script src="../js/contact_form.js"></script>
</body>
</html>