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

// Pagination settings
$recordsPerPage = 1; // Display one day's data per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$startFrom = ($page - 1) * $recordsPerPage;

// Calculate total pages (max 7 days)
$totalPages = min(30, ceil($pdo->query("SELECT COUNT(DISTINCT DATE(date_time)) as total FROM invoice")->fetch(PDO::FETCH_ASSOC)['total']));

// Fetch data for the current page
$currentDateQuery = $pdo->prepare("SELECT DATE(date_time) as order_date FROM invoice GROUP BY DATE(date_time) ORDER BY date_time DESC LIMIT :limit OFFSET :offset");
$currentDateQuery->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
$currentDateQuery->bindValue(':offset', $startFrom, PDO::PARAM_INT);
$currentDateQuery->execute();
$currentDate = $currentDateQuery->fetch(PDO::FETCH_ASSOC);

$dateStr = $currentDate['order_date'];

// Query to get total sales and profit for the current day
$dayTotalQuery = $pdo->prepare("
    SELECT
        SUM(i.total) as day_total,
        IFNULL(SUM(d.profit), 0) as profit
    FROM invoice i
    LEFT JOIN (
        SELECT
            invoice_id,
            SUM(profit * qty) as profit
        FROM invoice_details
        GROUP BY invoice_id
    ) d ON i.invoice_id = d.invoice_id
    WHERE DATE(i.date_time) = :orderDate
");
$dayTotalQuery->execute([':orderDate' => $dateStr]);
$dayTotalResult = $dayTotalQuery->fetch(PDO::FETCH_ASSOC);

$dayTotal = $dayTotalResult['day_total'];
$dailyProfit = $dayTotalResult['profit'];

?>

<!-- Styling for pagination (You can modify as per your theme) -->
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

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Order List By Date</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0" style="font-weight: bold"><?php echo $dateStr; ?></h5>
            </div>
            <div class="card-body">
              <table class="table table-striped table-hover ">
                <thead>
                <tr>
                  <td>Invoice ID</td>
                  <td>Date Time</td>
                  <td>Total</td>
                  <td>Paid</td>
                  <td>Due</td>
                  <td>Payment Type</td>
                  <td>Product Count</td>
                  <td>Profit</td>
                  <td>Action</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $select = $pdo->prepare("
                                        SELECT
                                          invoice.*,
                                          COUNT(invoice_details.id) as product_count,
                                          SUM(invoice_details.profit * invoice_details.qty) as profit
                                        FROM invoice
                                        LEFT JOIN invoice_details ON invoice.invoice_id = invoice_details.invoice_id
                                        WHERE DATE(invoice.date_time) = :orderDate
                                        GROUP BY invoice.invoice_id
                                        ORDER BY invoice.invoice_id ASC
                                      ");
                $select->execute([':orderDate' => $dateStr]);

                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                  echo '
                                          <tr>
                                              <td>' . $row->invoice_id . '</td>
                                              <td>' . $row->date_time . '</td>
                                              <td>' . $row->total . '</td>
                                              <td>' . $row->paid . '</td>
                                              <td>' . $row->due . '</td>';

                  if ($row->payment_type == "Cash") {
                    echo '<td><span class="badge badge-warning">' . $row->payment_type . '</span></td>';
                  } elseif ($row->payment_type == "Card") {
                    echo '<td><span class="badge badge-success">' . $row->payment_type . '</span></td>';
                  } else {
                    echo '<td><span class="badge badge-danger">' . $row->payment_type . '</span></td>';
                  }

                  echo '<td>' . $row->product_count . '</td>';
                  echo '<td>' . number_format($row->profit, 2) . '</td>';

                  echo '
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="printbill.php?id=' . $row->invoice_id . '" class="btn btn-warning" role="button" target="_blank"><span class="fa fa-print" style="color:#ffffff" data-toggle="tooltip" title="Print Bill"></span></a>
                                                        <a href="vieworderpos.php?id=' . $row->invoice_id . '" class="btn btn-info" role="button"><span class="fa fa-desktop" style="color:#ffffff" data-toggle="tooltip" title="View Order"></span></a>
                                                    </div>
                                                </td>
                                              </tr>';
                }
                ?>
                </tbody>
              </table>
              <p style='font-weight: bold;'>Total Sales: Rs <?php echo number_format($dayTotal, 2); ?></p>
              <p style='font-weight: bold;'>Profit: Rs <?php echo number_format($dailyProfit, 2); ?></p>
            </div>
          </div>

          <!-- Pagination links -->
          <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
              $activeClass = $page == $i ? 'active' : '';
              echo "<a href='?page=" . $i . "' class='" . $activeClass . "'>" . $i . "</a> ";
            }

            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once "footer.php";
?>
