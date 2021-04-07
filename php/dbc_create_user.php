<?php 
require_once('dbc.php');

Class User extends Dbc {
  /**
     * アカウント登録機能
     * @param  string $birthday
     * @param  string $email
     * @param  string $get_messages
     * @param  string $tel
     * @param  string $password
     * @return bool   $result
     */
    public function createUser($birthday, $email, $get_messages, $tel, $password) {
      // パスワードをハッシュ化(暗号化)
      $hash_pass = password_hash($password, PASSWORD_DEFAULT);
      try {
        $pdo = $this->dbConnect();
        $sql = 'INSERT INTO 
                      create_user (birthday, email, get_messages, tel, password) 
                VALUES (:birthday, :email, :get_messages, :tel, :password)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->bindValue('get_messages', $get_messages, PDO::PARAM_STR);
        $stmt->bindValue('tel', $tel, PDO::PARAM_STR);
        $stmt->bindValue('password', $hash_pass, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * アカウント情報編集
     * @param  $id
     * @param  $email
     * @param  $get_messages
     * @param  $tel
     * @return $result
     */
    public function updateUser($id, $email, $get_messages, $tel) {
      try {
        $pdo = $this->dbConnect();
        $sql = 'UPDATE create_user SET email = :email, get_messages = :get_messages, tel = :tel WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->bindValue('get_messages', $get_messages, PDO::PARAM_STR);
        $stmt->bindValue('tel', $tel, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * データベースからメールアドレスを取得 
     * @param void
     * @return string $email
    */
    public function getEmail() {
      try {
        $pdo = $this->dbConnect();
        $sql = 'SELECT email FROM create_user';
        $stmt = $pdo->query($sql);
        $email = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $email;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * データベースから電話番号を取得 
     * @param void
     * @return string $tel
    */
    public function getTel() {
      try {
        $pdo = $this->dbConnect();
        $sql = 'SELECT tel FROM create_user';
        $stmt = $pdo->query($sql);
        $tel = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tel;
      } catch (PDOException $e) {
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
     * メールアドレスを元にユーザIDを取得
     * @param  string $email
     * @return bool   $userData
     */
    public function getUserById($email) {
      try {
        $pdo  = $this->dbConnect();
        $sql  = "SELECT * FROM create_user WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * 住所登録
     * @param  int    $userId
     * @param  string $name
     * @param  int    $postalCode
     * @param  string $address
     * @param  string $tel
     * @return bool   $result
     */
    public function registerAddress($userID, $name, $postalCode, $address, $tel) {
      try {
        $pdo  = $this->dbConnect();
        $sql  = "INSERT INTO 
                        user_address (userID, name, postalCode, address, tel)
                VALUES (:userID, :name, :postalCode, :address, :tel)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':postalCode', $postalCode, PDO::PARAM_INT);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * 住所登録の際の電話番号の被りをチェック
     * @param  string $tel
     * @return bool  $result
     */
    public function checkUsersTel($tel) {
      try {
        $pdo  = $this->dbConnect();
        $sql  = "SELECT * FROM user_address WHERE tel = :tel";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * ログインユーザのidを元に住所をデータベースから取得
     * @param  string $id
     * @return bool  $result
     */
    public function getUserAddress($id) {
      try {
        $pdo  = $this->dbConnect();
        $sql  = "SELECT * FROM user_address WHERE userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userID', $id, PDO::PARAM_INT);
        $stmt->execute();
        $userAddress = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userAddress;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * 住所変更
     * @param  $id
     * @param  $name
     * @param  $postalCode
     * @param  $address
     * @param  $tel
     * @return $result;
     */
    public function updateAddress($id, $name, $postalCode, $address, $tel) {
      try {
        $pdo = $this->dbConnect();
        $sql = 'UPDATE user_address SET name = :name, postalCode = :postalCode, address = :address, tel = :tel WHERE userID = :userID';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('userID', $id, PDO::PARAM_INT);
        $stmt->bindValue('name', $name, PDO::PARAM_STR);
        $stmt->bindValue('postalCode', $postalCode, PDO::PARAM_STR);
        $stmt->bindValue('address', $address, PDO::PARAM_STR);
        $stmt->bindValue('tel', $tel, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    /**
     * ログアウト
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