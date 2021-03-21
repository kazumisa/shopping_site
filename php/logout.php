<?php 
session_start();
require_once('./dbc_create_user.php');

$user = new User();

// ログインユーザの確認
if(!isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
}

// ログアウト処理
$user->logOut();

