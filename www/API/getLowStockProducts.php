<?php
include_once '../API/connectdb.php';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query with search term
$query = "
    SELECT
        Product.pid,
        Product.barcode,
        Product.product,
        Category.category AS category,
        Product.description,
        COALESCE(SUM(Product_Stock.stock), 0) AS total_stock
    FROM Product
    INNER JOIN Category ON Product.catid = Category.catid
    LEFT JOIN Product_Stock ON Product.pid = Product_Stock.pid
    WHERE Product.product LIKE :searchTerm OR Product.barcode LIKE :searchTerm OR Product.description LIKE :searchTerm
    GROUP BY Product.pid, Product.barcode, Product.product, Category.category, Product.description
    HAVING COALESCE(SUM(Product_Stock.stock), 0) < 5
    ORDER BY COALESCE(SUM(Product_Stock.stock), 0) ASC
";

$select = $pdo->prepare($query);
$select->bindValue(':searchTerm', '%' . $searchTerm . '%');
$select->execute();
$products = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);
?>
