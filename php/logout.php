<?php 
session_start();
require_once(dirname(__FILE__).'/dbc_create_user.php');

$user = new User('create_user');

// ログインユーザの確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
}

// ログアウト処理
$user->logOut();

