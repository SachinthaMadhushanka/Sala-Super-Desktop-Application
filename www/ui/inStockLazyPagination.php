<?php
include_once '../API/connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:../index.php');
}

if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {
  include_once 'headeruser.php';
}
?>

<style>
  .pagination {
    display: flex;
    flex-wrap: wrap; /* Allows pagination items to wrap onto the next line */
    justify-content: center;
    margin: 20px 0;
  }

  .pagination a {
    margin: 5px; /* Increased margin for spacing on wrap */
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
    background-color: #f4f4f4;
    flex: 0 0 auto; /* Prevents flex items from growing or shrinking */
  }

  .pagination a.active {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
  }

  .pagination a:hover:not(.active) {
    background-color: #ddd;
  }

</style>

<?php
$max_pages = 30;

// Get the count of unique dates, limited to the most recent 30 dates
// Get the count of unique dates, limited to the most recent 30 dates
$stmt = $pdo->prepare("SELECT DISTINCT DATE(date_time) as date_only FROM incoming_stock ORDER BY DATE(date_time) DESC LIMIT :max_pages");
$stmt->bindValue(':max_pages', $max_pages, PDO::PARAM_INT);
$stmt->execute();
$dates = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);


$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$current_date = $dates[$current_page] ?? $dates[0]; // Fallback to the most recent date

$select = $pdo->prepare("
                        SELECT
                            Product.pid,
                            Product.barcode,
                            Product.product,
                            Category.category AS category,
                            Product.description,
                            IncomingStock.id as stock_id,
                            IncomingStock.stock,
                            IncomingStock.purchaseprice,
                            IncomingStock.saleprice,
                            IncomingStock.date_time
                        FROM Product
                        INNER JOIN Category ON Product.catid = Category.catid
                        RIGHT JOIN Incoming_Stock AS IncomingStock ON Product.pid = IncomingStock.pid
                        WHERE DATE(date_time) = :current_date
                        ORDER BY IncomingStock.date_time DESC, Product.pid ASC
                    ");

$select->bindParam(':current_date', $current_date);
$select->execute();
$rows = $select->fetchAll(PDO::FETCH_OBJ);


//          // Now retrieve the data for just the current date
//          $stmt = $pdo->prepare("SELECT * FROM incoming_stock WHERE date_time = :current_date");
//          $stmt->bindParam(':current_date', $current_date);
//          $stmt->execute();
//          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group products by date
$groupedByDate = [];
foreach ($rows as $row) {
  $date = (new DateTime($row->date_time))->format('Y-m-d');
  $groupedByDate[$date][] = $row;
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Incoming Stock</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <!-- Dynamic tables will be inserted here -->
          <?php


          // Generate a table for each date
          foreach ($groupedByDate as $date => $products) {
            $totalPayment = 0; // Initialize total payment for the date

            echo '<div class="card card-primary card-outline">';

            echo '<div class="card-header"><h5 class="m-0" style="font-weight: bold">Stock Date: ' . $date . '</h5></div>';
            echo '<div class="card-body">';
            echo '<table class="table table-hover">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Barcode</th>';
            echo '<th>Product</th>';
            echo '<th>Category</th>';
            echo '<th>Description</th>';
            echo '<th>Date Time</th>';
            echo '<th>Stock</th>';
            echo '<th>PurchasePrice</th>';
            echo '<th>SalePrice</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($products as $product) {
              // Calculate the total for each product
              $productTotal = $product->stock * $product->purchaseprice;
              // Add to the total payment for the date
              $totalPayment += $productTotal;

              echo '<tr>';
              echo '<td>' . htmlspecialchars($product->barcode) . '</td>';
              echo '<td>' . htmlspecialchars($product->product) . '</td>';
              echo '<td>' . htmlspecialchars($product->category) . '</td>';
              echo '<td>' . htmlspecialchars($product->description) . '</td>';
              echo '<td>' . htmlspecialchars($product->date_time) . '</td>';
              echo '<td>' . htmlspecialchars($product->stock) . '</td>';
              echo '<td>' . htmlspecialchars($product->purchaseprice) . '</td>';
              echo '<td>' . htmlspecialchars($product->saleprice) . '</td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            // Display the total payment for the date
            echo '<div class="card-footer">';
            echo '<h5 class="text-right" style="font-weight: bold">Total Payment: ' . htmlspecialchars(number_format($totalPayment, 2)) . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';


          }

          echo '<div class="pagination">';
          for ($i = 1; $i <= count($dates) && $i <= $max_pages; $i++) {
            $activeClass = ($current_page + 1) == $i ? 'active' : ''; // Adjusting for zero index
            echo "<a href='?page=" . ($i - 1) . "' class='" . $activeClass . "'>" . $i . "</a> "; // Adjusting for zero index
          }
          echo '</div>';
          ?>
        </div><!-- /.col-md-6 -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>


  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once "footer.php"; ?>

<!-- Put your scripts here -->
