<?php
include_once '../API/connectdb.php';
session_start();

$response = [];

try {
  // Retrieve the raw POST data from the request body
  $json = file_get_contents('php://input');
  $data = json_decode($json, true); // Decode the JSON data

  if (!empty($data) && isset($data['data'])) {
    // Begin a transaction
    $pdo->beginTransaction();

    foreach ($data['data'] as $item) {
      // Prepare SQL query to update the 'ourprice' column in 'product_stock' table
      $sql = "UPDATE product_stock SET ourprice = :our_price WHERE id = :stock_id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':stock_id', $item['stock_id'], PDO::PARAM_INT);
      $stmt->bindParam(':our_price', $item['our_price'], PDO::PARAM_STR);

      // Execute the query
      if (!$stmt->execute()) {
        throw new Exception("Failed to update our price for stock ID: " . $item['stock_id']);
      }
    }

    // Commit the transaction
    $pdo->commit();
    $response['status'] = 'success';
    $response['message'] = 'Our prices updated successfully in product_stock';
  } else {
    throw new Exception("Invalid request, data missing");
  }
} catch (Exception $e) {
  // An error occurred, roll back the transaction
  $pdo->rollBack();
  $response['status'] = 'error';
  $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
