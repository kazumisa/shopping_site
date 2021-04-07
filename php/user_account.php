<?php 
session_start();
require_once('./dbc_create_user.php');

$user = new User();

// ログインユーザの存在を確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
} else {
  $login_user = $_SESSION['login_user'];
  $id = $login_user['id'];
  $log_one = substr_replace($login_user['tel'], '-', 3, 0);
  $log_second = substr_replace($log_one, '-', 8, 0);
}

if(isset($_SESSION['user_address'])) {
  $userAddress = $user->getUserAddress($id);
  $sub_one = substr_replace($userAddress['tel'], '-', 3, 0);
  $sub_second = substr_replace($sub_one, '-', 8, 0);
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
        <td><?php echo User::h($login_user['email']) ;?></td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td><?php echo User::h($login_user['birthday']) ;?></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><?php echo User::h($log_second) ;?></td>
      </tr>
    </table>
    <?php endif ?>

    <?php if(isset($_SESSION['user_address'])) :?>
    <div class="user_address">
      <h3>配送先住所</h3>
      <div class="change"><a href="./update_address.php">変更</a></div>
    </div>
    <table border="1">
      <tr>
        <th>お名前</th>
        <td><?php echo User::h($userAddress['name']) ;?></td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td><?php echo substr_replace(User::h($userAddress['postalCode']), '-', 3, 0) ;?></td>
      </tr>
      <tr>
        <th>住所</th>
        <td><?php echo User::h($userAddress['address']) ;?></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><?php echo User::h($sub_second) ;?></td>
      </tr>
    </table>
    <?php endif ?>
  </section>
</main>

<?php define("src1", "../js/common.js")?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/php/footer.php'); ?>