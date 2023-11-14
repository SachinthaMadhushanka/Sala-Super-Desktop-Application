<?php
include_once '../API/connectdb.php';

$response = "";

if (isset($_POST['stock_id'])) {
  $stock_id = $_POST['stock_id'];

  // Retrieve the pid associated with the stock_id
  $sql_get_pid = "SELECT pid FROM Product_Stock WHERE id = :stock_id";
  $get_pid = $pdo->prepare($sql_get_pid);
  $get_pid->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
  $get_pid->execute();
  $result_pid = $get_pid->fetch(PDO::FETCH_ASSOC);
  $pid = $result_pid['pid'];

  if (!$pid) {
    return "error";
  }

  // Delete the stock entry
  $sql = "DELETE FROM Product_Stock WHERE id = :stock_id";
  $delete = $pdo->prepare($sql);
  $delete->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);

  if ($delete->execute()) {

    // Check if there's any stock left for the associated product
    $sql_check_stock = "SELECT COUNT(*) as count FROM Product_Stock WHERE pid = :pid";
    $check_stock = $pdo->prepare($sql_check_stock);
    $check_stock->bindParam(':pid', $pid, PDO::PARAM_INT);
    $check_stock->execute();
    $result = $check_stock->fetch(PDO::FETCH_ASSOC);

    // If no stock entries left for the product, delete the product
    if ($result['count'] == 0) {
      $sql_delete_product = "DELETE FROM Product WHERE pid = :pid";
      $delete_product = $pdo->prepare($sql_delete_product);
      $delete_product->bindParam(':pid', $pid, PDO::PARAM_INT);
      $delete_product->execute();
    }

    $response = "success";
  } else {
    $response = "error";
  }
} else {
  $response = "invalid_request";
}

echo $response;
?>
