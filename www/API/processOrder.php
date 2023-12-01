<?php

require_once 'connectdb.php';

$response = ['success' => false, 'message' => '', 'invoice_id' => null];

// Collect POST data
$postData = $_POST;


try {
  // Begin transaction
  $pdo->beginTransaction();

  // Insert into invoice table
  $invoiceSQL = "INSERT INTO invoice (date_time, subtotal, discount, total, payment_type, due, paid)
                   VALUES (:order_datetime, :sub_total, :discount, :total, :payment_method, :balance, :paid)";
  $stmt = $pdo->prepare($invoiceSQL);
  $stmt->execute([
    ':order_datetime' => $postData['order_datetime'],
    ':sub_total' => $postData['sub_total'],
    ':discount' => $postData['discount'],
    ':total' => $postData['total'],
    ':payment_method' => $postData['payment_method'],
    ':balance' => $postData['balance'],
    ':paid' => $postData['paid']
  ]);

  $lastInvoiceID = $pdo->lastInsertId();

  // Loop through each stock item and insert into invoice_details & update product_stock
  foreach ($postData['items'] as $item) {
    $stockID = $item['stock_id'];
    $quantity = $item['quantity'];
    $unit_price = $item['saleprice']; // Ensure that saleprice is provided for each item

    // Find the corresponding product_id for the stock_id from the product_stock table
    $productIDQuery = "SELECT pid, purchaseprice, saleprice, ourprice FROM product_stock WHERE id = :stock_id";
    $productStmt = $pdo->prepare($productIDQuery);
    $productStmt->execute([':stock_id' => $stockID]);
    $productRow = $productStmt->fetch(PDO::FETCH_ASSOC);
    $productID = $productRow['pid']; // Assuming 'pid' is the product_id column in your product_stock table
    $profit = $productRow['ourprice'] - $productRow['purchaseprice'];
    $ourprice = $productRow['ourprice'];

    // Check if product_id is found
    if ($productID) {
      // Insert into invoice_details table
      $detailsSQL = "INSERT INTO invoice_details (invoice_id, product_id, qty, unit_price, profit, ourprice) VALUES (:invoice_id, :product_id, :qty, :unit_price, :profit, :ourprice)";
      $stmt = $pdo->prepare($detailsSQL);
      $stmt->execute([
        ':invoice_id' => $lastInvoiceID,
        ':product_id' => $productID,
        ':qty' => $quantity,
        ':unit_price' => $unit_price,
        ':profit' => $profit,
        ':ourprice' => $ourprice
      ]);
    } else {
      $pdo->rollBack();
      $response['message'] = "Error: Product ID not found for stock ID $stockID.";
      echo json_encode($response);
      exit; // Exit the script
    }


    // Update product_stock
    $updateStockSQL = "UPDATE product_stock SET stock = stock - :qty WHERE id = :stock_id";
    $stmt = $pdo->prepare($updateStockSQL);
    $stmt->execute([
      ':qty' => $quantity,
      ':stock_id' => $stockID
    ]);

    // Check if stock becomes 0, then delete the record
    $checkStockSQL = "DELETE FROM product_stock WHERE stock = 0 AND id = :stock_id";
    $stmt = $pdo->prepare($checkStockSQL);
    $stmt->execute([':stock_id' => $stockID]);
  }

  $pdo->commit();

  // After successfully inserting the data, set the response
  $response['success'] = true;
  $response['message'] = "Order processed successfully!";
  $response['invoice_id'] = $lastInvoiceID; // Add the invoice ID to the response

} catch (Exception $e) {
  $pdo->rollBack();
  $response['message'] = "Error processing the order: " . $e->getMessage();
}

echo json_encode($response);
?>
