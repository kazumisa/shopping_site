<?php
session_start();
require_once(dirname(__FILE__).'/dbc.php');

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
}

// 受け取った$_SESSION['err']を変数に格納
if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}
if(isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  unset($_SESSION['email']);
}
if(isset($_SESSION['login_err'])) {
  $login_err = $_SESSION['login_err'];

  unset($_SESSION['login_err']);
}

?>
<?php define("title" ,"Milfin_login_form"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/login_form.css")?>
<?php include(dirname(__FILE__).'/header.php'); ?>

<main>
  <div class="login">
    <span class="material-icons" id="login">login</span>
    <h3>ログイン</h3>
  </div>

  <!-- ログインフォームに関する記述 -->
  <form action="./complete_login_form.php" method="POST" class="login_form">

    <!-- メールアドレスに関する記述 -->
    <div class="email">
      <input type="email" name="email" id="email" placeholder="メールアドレス" 
      <?php if(isset($email)):?>
      value="<?php echo Dbc::h($email) ;?>"
      <?php endif ;?>>

      <div class="err">
        <?php if(isset($err['email'])) :?>
          <p id="err_msg"><?php echo $err['email'] ;?></p>
        <?php endif ;?>
      </div>
      <div class="login_err">
        <?php if(isset($login_err['email'])) :?>
          <p id="login_err_msg"><?php echo $login_err['email'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- パスワードに関する記述 -->
    <div class="password">
      <input type="password" name="password" id="password" placeholder="パスワード">

      <div class="err">
        <?php if(isset($err['password'])) :?>
          <p id="err_msg"><?php echo $err['password'];?></p>
        <?php endif ;?>
      </div>
      <div class="login_err">
        <?php if(isset($login_err['password'])) :?>
          <p id="login_err_msg"><?php echo $login_err['password'] ;?></p>
        <?php endif ;?>
      </div>
    </div>

    <!-- 送信に関する記述 -->
    <div class="submit">
      <input type="hidden" name="token" value="<?php echo Dbc::setToken() ;?>">
      <input type="submit" name="submit" id="login_submit" value="ログイン">
    </div>
  </form>

  <div class="forget">
    <a href="./contact_form.php" id="forget">メールアドレス・パスワードをお忘れですか？</a>
  </div>
  <div class="new">
    <a href="./create_user.php" id="new">初めてご利用の方 (新規会員登録)</a>
  </div>
</main>

<?php define("src1", "../js/common.js")?>
<?php include(dirname(__FILE__).'/footer.php'); ?>