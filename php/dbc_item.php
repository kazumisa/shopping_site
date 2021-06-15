<?php
require_once(dirname(__FILE__).'/dbc.php');

Class Item extends Dbc 
{
  /**
   * データベースに商品を登録
   * @param string $file_name
   * @param string $save_path
   * @param string $brand_name
   * @param string $item_name
   * @param string $item_detail
   * @param int    $item_price
   * @param string $target
   * @param string $category
   * @param int    $stock
   * @param bool   $result
   */
  public function registerItem($file_name, $save_path, $brand_name, $item_name, $item_detail, $item_price, $target, $category, $stock) {
    try {
      $pdo = $this->dbConnect();
      $sql = "INSERT INTO 
                    $this->table_name (file_name, file_path, brand_name, item_name, item_detail, item_price, target, category, stock) 
              VALUES (:file_name, :file_path, :brand_name, :item_name, :item_detail, :item_price, :target, :category, :stock)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':file_name', $file_name, PDO::PARAM_STR);
      $stmt->bindValue(':file_path', $save_path, PDO::PARAM_STR);
      $stmt->bindValue(':brand_name', $brand_name, PDO::PARAM_STR);
      $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
      $stmt->bindValue(':item_detail', $item_detail, PDO::PARAM_STR);
      $stmt->bindValue(':item_price', $item_price, PDO::PARAM_INT);
      $stmt->bindValue(':target', $target, PDO::PARAM_STR);
      $stmt->bindValue(':category', $category, PDO::PARAM_STR);
      $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
      $result = $stmt->execute();
      return $result;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  } 

  /**
   * データベースから商品を降順で20件取得
   * @param void
   * @param array $itemsData
   */
  public function getItemData() {
    try {
      $pdo = $this->dbConnect();
      $sql = "SELECT * FROM $this->table_name ORDER BY id DESC LIMIT 20";
      $result = $pdo->query($sql);
      $itemsData = $result->fetchAll(PDO::FETCH_ASSOC);
      return $itemsData;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * 商品IDに該当するデータを全て取得
   * @param  int   $id
   * @return array $itemData
   */
  public function getItemDataById($id) {
    try {
      $pdo  = $this->dbConnect();
      $sql  = "SELECT * FROM $this->table_name WHERE id=:id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $itemData = $stmt->fetch(PDO::FETCH_ASSOC);
      return $itemData;
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  /**
   * 検索された商品をデータベースから取得
   * @param string $item
   * @return array $itemsData
   */
  public function searchItem($search_word) {
    try {
      $pdo  = $this->dbConnect();
      $sql  = "SELECT * FROM $this->table_name WHERE category = :category OR brand_name = :brand_name OR item_name = :item_name";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('category', $search_word, PDO::PARAM_STR);
      $stmt->bindValue('brand_name', $search_word, PDO::PARAM_STR);
      $stmt->bindValue('item_name', $search_word, PDO::PARAM_STR);
      $stmt->execute();
      $itemsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $itemsData;
    } catch (PDOException $e){
      exit($e->getMessage());
    }
  }
}

?>