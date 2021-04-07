<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  $login_user = $_SESSION['login_user'];
}

if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}

?>
<?php define("title" ,"Milfin_update_user"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/update_user.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <div class="update">
    <span class="material-icons" id="update">update</span>
    <h3>会員情報編集</h3>
  </div>

  <!-- フォームに関する記述 -->
  <form class="update_form" action="./complete_update_user.php" method="POST">

  <!-- メールアドレスに関する記述 -->
    <div class="email">
      <p class="title">メールアドレス <span>※必須</span></p>
      <input type="email" name="email" id="email" autocomplete="off"
      value="<?php echo $login_user['email']?>">
      
      <div class="err">
        <?php if(isset($err['email'])) :?>
          <p id="err_msg"><?php echo $err['email'] ;?></p>
        <?php endif ;?>
      </div>

      <div class="desc">
        <input type="checkbox" name="checkbox" id="checkbox" <?php echo $login_user['get_messages'] === "on" ? "checked" : " " ;?>>
        <p>クーポンおよびショップに関する情報を受け取る</p>
      </div>
    </div>


    <!-- 電話番号に関する記述 -->
    <div class="tel">
      <p class="title">電話番号</p>
      <p class="title_desc">ハイフンなし電話番号を記入して下さい</p>
      <input type="tel" name="tel" id="tel" autocomplete="off" value="<?php echo $login_user['tel']?>">

      <div class="err">
        <?php if(isset($err['tel'])) :?>
          <p id="err_msg"><?php echo '※'.$err['tel'] ;?></p>
        <?php endif ;?>
      </div>

      <p class="desc">※設定していただくとパスワードをお忘れの際、パスワードの設定がスムーズにおこなえます。</p>
    </div>

    <!-- 送信に関する記述 -->
    <div class="submit">
      <input type="hidden" name="id" value="<?php echo $login_user['id'];?>">
      <input type="hidden" name="token" value="<?php echo User::h(User::setToken());?>">
      <input type="submit" name="submit" id="submit" value="登録完了">
    </div>
  </form>
</main>

<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>

