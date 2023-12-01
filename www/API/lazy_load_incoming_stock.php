<?php
// This file name is 'lazy_load_incoming_stock.php'
include_once '../API/connectdb.php';
session_start();

// Function to get stock data for a specific date
function getStockDataByDate($pdo, $date) {
  $select = $pdo->prepare("
        SELECT
            Product.pid,
            Product.barcode,
            Product.product,
            Category.category,
            Product.description,
            IncomingStock.stock,
            IncomingStock.purchaseprice,
            IncomingStock.saleprice,
            IncomingStock.date_time
        FROM Product
        INNER JOIN Category ON Product.catid = Category.catid
        INNER JOIN Incoming_Stock AS IncomingStock ON Product.pid = IncomingStock.pid
        WHERE DATE(IncomingStock.date_time) = :date
        ORDER BY IncomingStock.date_time DESC, Product.pid ASC
    ");
  $select->execute([':date' => $date]);
  return $select->fetchAll(PDO::FETCH_OBJ);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date'])) {
  $date = $_POST['date'];
  $stockData = getStockDataByDate($pdo, $date);
  // Output the JSON data
  header('Content-Type: application/json');
  echo json_encode($stockData);
  exit;
}
?>
