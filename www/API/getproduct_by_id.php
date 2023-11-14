<?php

include_once 'connectdb.php';
$productid = $_GET["id"];

$select = $pdo->prepare("select * from Product where pid=:productid");
$select->bindParam(':productid', $productid);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);


if ($row) {
  $response = array('status' => 'success', 'data' => $row);
} else {
  $response = array('status' => 'error', 'message' => 'Product not found');
}

header('Content-Type: application/json');
echo json_encode($response);
?>
