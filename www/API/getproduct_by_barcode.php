<?php

include_once 'connectdb.php';
$barcode = $_GET["id"];

$select = $pdo->prepare("select * from Product where barcode=:barcode");
$select->bindParam(':barcode', $barcode);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

if($row) {
  $response = array('status' => 'success', 'data' => $row);
} else {
  $response = array('status' => 'error', 'message' => 'Product not found');
}

header('Content-Type: application/json');
echo json_encode($response);
?>
