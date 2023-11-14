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

          <?php
          // Get distinct order dates
          $dates = $pdo->query("SELECT DATE(date_time) as order_date, SUM(total) as day_total FROM invoice GROUP BY DATE(date_time) ORDER BY date_time DESC")->fetchAll(PDO::FETCH_ASSOC);

          foreach ($dates as $date) {
            $dateStr = $date['order_date'];
            $dayTotal = $date['day_total']; // This will hold the sum of the totals for each day

            // Now create a table for each date
            ?>
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

                  $dailyProfit = 0;

                  // Get the orders for the current date
                  $select = $pdo->prepare("
                    SELECT
                      invoice.*,
                      COUNT(invoice_details.id) as product_count,
                      SUM((invoice_details.unit_price - product_stock.purchaseprice) * invoice_details.qty) as profit
                    FROM invoice
                    LEFT JOIN invoice_details ON invoice.invoice_id = invoice_details.invoice_id
                    LEFT JOIN product_stock ON invoice_details.stock_id = product_stock.id
                    WHERE DATE(invoice.date_time) = :orderDate
                    GROUP BY invoice.invoice_id
                    ORDER BY invoice.invoice_id ASC
                  ");
                  $select->execute([':orderDate' => $dateStr]);

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                    // Add the profit from each invoice to the daily profit
                    $dailyProfit += $row->profit;

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
                  echo "<p style='font-weight: bold; line-height: 0'>Total Sales: Rs " . number_format($dayTotal, 2) . "</p>";

                  echo "<p style='font-weight: bold'>Profit: Rs " . number_format($dailyProfit, 2) . "</p>";

                  ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php
          } // end foreach
          ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once "footer.php";
?>
