<?php 
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

$user = new User('user');

// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
} else {
  $login_user = $_SESSION['login_user'];
  $userID = $login_user['id'];
}

?>
<?php define("title" ,"Milfin_user_account"); ?>
<?php define("href1", "../css/common.css")?>
<?php define("href2", "../css/user_account.css")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/header.php'); ?>

<main>
  <div class="account">
    <span class="material-icons account_box">account_box</span>
    <h3>アカウント情報</h3>
  </div>
  <section class="infomation">
    <?php if(isset($login_user)) :?>
    <div class="user_info">
      <h3>ユーザ情報</h3>
      <div class="change"><a href="./update_user.php">変更</a></div>
    </div>
    <table border="1">
      <tr>
        <th>メールアドレス</th>
        <td><?php echo Dbc::h($login_user['email']) ;?></td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td><?php echo is_null($login_user['birthday']) ? '未登録' : Dbc::h($login_user['birthday']) ;?></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><?php echo is_null($login_user['tel']) ? '未登録' : Dbc::hyphenTel(Dbc::h($login_user['tel'])); ?></td>
      </tr>
      <tr>
        <th>ショップ情報</th>
        <td><?php echo $login_user['get_messages'] == 'on' ? '配信中' : '停止中' ;?></td>
      </tr>
    </table>
    <?php endif ?>

    <div class="user_address">
      <h3>配送先住所</h3>
      <div class="change"><a href="./update_address.php">変更</a></div>
    </div>
    <table border="1">
      <tr>
        <th>お名前</th>
        <td><?php echo is_null($login_user['name']) ? '未登録' : Dbc::h($login_user['name']); ?></td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td><?php echo is_null($login_user['postalCode']) ? '未登録' : Dbc::hyphenPostalCode(Dbc::h($login_user['postalCode'])); ?></td>
      </tr>
      <tr>
        <th>住所</th>
        <td><?php echo is_null($login_user['address']) ? '未登録' : Dbc::h($login_user['address']); ?></td>
      </tr>
    </table>
  </section>
</main>

<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>