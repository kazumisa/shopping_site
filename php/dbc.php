<?php
require_once('env.php');
ini_set('display_errors', 1);

Class Dbc 
{
  protected $table_name;

  // データベースに接続
  protected function dbConnect() {
    $host = DB_HOST;
    $name = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;
    $dsn  = "mysql:host=$host;dbname=$name;charset=utf8mb4";

    try {
      $pdo = new PDO($dsn, $user, $pass, 
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
      return $pdo;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * 文字数制限
   * @param string
   * @return string $limitedString||$string
   */
  public static function limited($string) {
    $count = mb_strlen($string);
    if($count > 20) {
      $limited = mb_substr($string, 0, 20);
      $limitedString = $limited."...";
      return $limitedString;
    } else {
      return $string;
    }
  }

  /**
   * CSRF対策 : ワンタイムトークン
   * @param void
   * @return string $token
   */
  public static function setToken() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;
    return $token;
  }

  // XSS対策 : エスケープ処理
  public static function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}