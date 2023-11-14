<?php
include_once '../API/connectdb.php';

$response = array();

// Check if barcode is set in the request
if (isset($_GET['barcode'])) {
  $barcode = $_GET['barcode'];

  // SQL query to fetch product and stock details based on barcode
  $sql = "
        SELECT
            Product.pid,
            Product.barcode,
            Product.product,
            Product.description,
            Product.catid,
            Category.category AS category,
            Product_Stock.id AS stock_id,
            Product_Stock.stock,
            Product_Stock.purchaseprice,
            Product_Stock.saleprice
        FROM Product
        LEFT JOIN Category ON Product.catid = Category.catid
        LEFT JOIN Product_Stock ON Product.pid = Product_Stock.pid
        WHERE Product.barcode = :barcode
    ";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':barcode', $barcode);
  $stmt->execute();

  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($products) {
    // Success: Products found
    $response['status'] = 'success';
    $response['message'] = 'Products fetched successfully.';
    $response['data'] = $products;
  } else {
    // Error: No products found for given barcode
    $response['status'] = 'error';
    $response['message'] = 'No products found for the provided barcode.';
  }

} else {
  // Error: Barcode not provided in the request
  $response['status'] = 'error';
  $response['message'] = 'Barcode not provided.';
}

// Send the response as a JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
