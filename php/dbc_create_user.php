<?php 
require_once(dirname(__FILE__).'/dbc.php');

Class User extends Dbc {
  /**
   * アカウント登録機能
   * @param  array  $create_user
   * @return bool   $result
   */
  public function createUser($create_user) {
    // パスワードをハッシュ化(暗号化)
    $hash_password = password_hash($create_user['password'], PASSWORD_DEFAULT);
    $pdo = $this->dbConnect();
    $sql = "INSERT INTO 
                $this->table_name (birthday, email, get_messages, tel, password) 
            VALUES (:birthday, :email, :get_messages, :tel, :password)";
    $pdo->beginTransaction();
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('birthday', $create_user['birthday'], PDO::PARAM_STR);
      $stmt->bindValue('email', $create_user['email'], PDO::PARAM_STR);
      $stmt->bindValue('get_messages', $create_user['get_messages'], PDO::PARAM_STR);
      $stmt->bindValue('tel', $create_user['tel'], PDO::PARAM_STR);
      $stmt->bindValue('password', $hash_password, PDO::PARAM_STR);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch (PDOException $e) {
      $pdo->rollBack();
      exit($e->getMessage());
    }
  }

  /**
   * アカウント情報編集
   * @param  array $update_user
   * @return bool  $result
   */
  public function updateUser($update_user) {
    $pdo = $this->dbConnect();
    $sql = "UPDATE 
                $this->table_name SET birthday = :birthday, email = :email, get_messages = :get_messages, tel = :tel
            WHERE id = :id";
    $pdo->beginTransaction();
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('id', $update_user['id'], PDO::PARAM_INT);
      $stmt->bindValue('birthday', $update_user['birthday'], PDO::PARAM_STR);
      $stmt->bindValue('email', $update_user['email'], PDO::PARAM_STR);
      $stmt->bindValue('get_messages', $update_user['get_messages'], PDO::PARAM_STR);
      $stmt->bindValue('tel', $update_user['tel'], PDO::PARAM_STR);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch (PDOException $e) {
      $pdo->rollBack();
      exit($e->getMessage());
    }
  }

  /**
   * ログイン機能
   * @param  string $email
   * @param  string $password
   * @return bool   $result
   */
  public function login($email, $password) {
    $result = false;
    $login_err = array();

    $userData = $this->getUserById($email);
    if($userData) {
      // パスワード照合
      if(password_verify($password, $userData['password'])) {
        $_SESSION['login_user'] = $userData;
        session_regenerate_id(true);
        $result = true;
        return $result;
      } else {
        $login_err['password'] = 'パスワードが一致しません。';
        $_SESSION['login_err'] = $login_err;
        return $result;
      }
    } else {
      $login_err['email'] = 'メールアドレスが一致しません。';
      $_SESSION['login_err'] = $login_err;
      return $result;
    }
  }

  /**
   * メールアドレスを元にユーザデータを取得
   * @param  string $email
   * @return array  $userData
   */
  public function getUserById($email) {
    $pdo  = $this->dbConnect();
    $sql  = "SELECT * FROM $this->table_name WHERE email = :email";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $userData = $stmt->fetch(PDO::FETCH_ASSOC);
      return $userData;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * 住所登録
   * @param  array $register_address
   * @return bool  $result
   */
  public function registerAddress($register_address) {
    $pdo = $this->dbConnect();
    $sql = "INSERT INTO 
                $this->table_name (userID, name, postalCode, address, tel)
            VALUES (:userID, :name, :postalCode, :address, :tel)";
    
    $pdo->beginTransaction();
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('userID', $register_address['userID'], PDO::PARAM_INT);
      $stmt->bindValue('name', $register_address['name'], PDO::PARAM_STR);
      $stmt->bindValue('postalCode', $register_address['postalCode'], PDO::PARAM_INT);
      $stmt->bindValue('address', $register_address['address'], PDO::PARAM_STR);
      $stmt->bindValue('tel', $register_address['tel'], PDO::PARAM_STR);
      $pdo->commit();
      $result = $stmt->execute();
      return $result;
    } catch (PDOException $e) {
      $pdo->rollBack();
      exit($e->getMessage());
    }
  }

  /**
   * メールアドレスの被りをチェック
   * @param  string $email
   * @return bool   $result
   */
  public function checkUsersEmail($email) {
    try {
      $pdo  = $this->dbConnect();
      $sql  = "SELECT email FROM $this->table_name WHERE email = :email";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }


  /**
   * 電話番号の被りをチェック
   * @param  String $tel
   * @return bool  $result
   */
  public function checkUsersTel($tel) {
    $pdo  = $this->dbConnect();
    $sql  = "SELECT tel FROM $this->table_name WHERE tel = :tel";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('tel', $tel, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * userIDを元にuserDataをデータベースから取得
   * @param  string $userID
   * @return bool   $userData
   */
  public function getUserData($userID) {
    $pdo  = $this->dbConnect();
    $sql  = "SELECT * FROM $this->table_name WHERE id = :userID";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('userID', $userID, PDO::PARAM_INT);
      $stmt->execute();
      $userData = $stmt->fetch(PDO::FETCH_ASSOC);
      return $userData;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * userIDを元に住所をデータベースから取得
   * @param  string $userID
   * @return bool   $userAddress
   */
  public function getUserAddress($userID) {
    $pdo  = $this->dbConnect();
    $sql  = "SELECT name, postalCode, address FROM $this->table_name WHERE id = :userID";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('userID', $userID, PDO::PARAM_INT);
      $stmt->execute();
      $userAddress = $stmt->fetch(PDO::FETCH_ASSOC);
      return $userAddress;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * 住所変更
   * @param  $update_address
   * @return $result;
   */
  public function updateAddress($update_address) {
    $pdo = $this->dbConnect();
    $sql = "UPDATE 
                $this->table_name SET name = :name, postalCode = :postalCode, address = :address 
            WHERE id = :id";
    
    $pdo->beginTransaction();
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('id', $update_address['id'], PDO::PARAM_INT);
      $stmt->bindValue('name', $update_address['name'], PDO::PARAM_STR);
      $stmt->bindValue('postalCode', $update_address['postalCode'], PDO::PARAM_STR);
      $stmt->bindValue('address', $update_address['address'], PDO::PARAM_STR);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch (PDOException $e) {
      $pdo->rollBack();
      exit($e->getMessage());
    }
  }

  /**
   * フラッシュメッセージ機能
   * @param  string $message
   * @return void
   */
  public function flashMessage($message) {
    $_SESSION['flash_message'] = $message;
  }

  /**
   * ログアウト
   * @param  void
   * @return void
   */
  public function logOut() {
    // セッション変数を全て解除
    $_SESSION = array();
    // セッションを破棄する
    session_destroy();
    // ログアウト完了後にサイトトップに遷移
    header('Location: ./index.php');
  }
}

?>