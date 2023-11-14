<?php

include_once 'connectdb.php';

$search = $_GET["term"];

$select = $pdo->prepare("SELECT pid, product FROM Product WHERE product LIKE :product ORDER BY product LIMIT 10");
$select->execute(array(':product' => '%' . $search . '%'));

$data = array();

while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
  $data[] = array(
    'id' => $row['pid'],
    'label' => $row['product'],
    'value' => $row['product']
  );
}

echo json_encode($data);
?>
