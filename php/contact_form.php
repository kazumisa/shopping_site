<?php
session_start();
require_once(dirname(__FILE__).'/dbc.php');

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
<?php define("title" ,"Milfin_contact_form"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/contact_form.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <div class="contact">
    <span class="material-icons contact_support">contact_support</span>
    <h3>お問い合わせ</h3>
  </div>
  <div class="questions">
    <p>よくある質問は<a href="">こちら</a></p>
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

<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>