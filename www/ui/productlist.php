<?php
include_once '../API/connectdb.php';
session_start();
if ($_SESSION['useremail'] == "") {

  header('location:../index.php');

}


if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {

  include_once 'headeruser.php';
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">


          <div class="card card-primary card-outline">
            <div class="card-header d-flex">
              <h5 class="m-0" style="font-weight: bold">Product List</h5>
              <input type="text" id="customSearchBox" placeholder="Search Product" class="ml-auto"
                     style="height: 35px; padding-left: 10px; padding-right: 10px" autofocus>
            </div>

            <div class="card-body">

              <table class="table table-hover " id="table_product">
                <thead>
                <tr style="font-weight: bold">
                  <td>Barcode</td>
                  <td>Product</td>
                  <td>Category</td>
                  <td>Description</td>
                  <td>ActionIcons</td>

                </tr>

                </thead>


                <tbody style="background-color:#f7f5f5 ">

                <?php

                $select = $pdo->prepare("
                  SELECT
                      Product.pid,
                      Product.barcode,
                      Product.product,
                      Category.category AS category,
                      Product.description
                  FROM Product
                  INNER JOIN Category ON Product.catid = Category.catid
                  ORDER BY Product.pid ASC
              ");

                $select->execute();
                $rows = $select->fetchAll(PDO::FETCH_OBJ);


                if ($rows) {
                  foreach ($rows as $item) {
                    echo '<tr>';
                    echo '<td>' . $item->barcode . '</td>';
                    echo '<td>' . $item->product . '</td>';
                    echo '<td>' . $item->category . '</td>';
                    echo '<td>' . $item->description . '</td>';
                    echo '<td>';
                    echo '<div class="btn-group">';
                    echo '<a href="viewproductonly.php?product_id=' . $item->pid . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>';
                    if ($_SESSION['role'] == "Admin") {
                      echo '<a href="editproductonly.php?product_id=' . $item->pid . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>';
                    }
                    // Uncomment the line below if you want to include a delete button
                    // echo '<button stock_id="' . $item->stock_id . '" class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                  }
                } else {
                  echo "<tr><td colspan='5'>No products found in the database.</td></tr>";
                }
                ?>

                </tbody>

              </table>


            </div>
          </div>


        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";


?>

<script>
  $(document).ready(function () {
    // Search function with debounce to prevent excessive AJAX calls
    $('#customSearchBox').on('keyup', debounce(function () {
      let searchTerm = $(this).val();
      $.ajax({
        method: "GET",
        url: "../API/getFilteredProducts.php",
        data: {search: searchTerm}
      }).done(function (data) {
        if (typeof data === 'string') {
          data = JSON.parse(data);
        }
        populateTable(data);
      });
    }, 300)); // 300ms debounce

    // Function to populate the table with product data
    function populateTable(data) {
      let tbody = $('#table_product tbody');
      tbody.empty(); // Clear existing rows

      data.forEach(function (item) {
        let tr = $('<tr></tr>');
        tr.append('<td>' + item.barcode + '</td>');
        tr.append('<td>' + item.product + '</td>');
        tr.append('<td>' + item.category + '</td>');
        tr.append('<td>' + item.description + '</td>');
        tr.append('<td>' + generateActionButtons(item) + '</td>');
        tbody.append(tr);
      });
    }


    // Function to generate action buttons HTML
    function generateActionButtons(item) {

      let userRole = <?php echo json_encode($_SESSION['role']); ?>;

      if (userRole === "Admin") {

        return '<div class="btn-group">' +
          '<a href="viewproductonly.php?product_id=' + item.pid + '" class="btn btn-warning btn-xs" role="button">' +
          '<span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>' +
          '<a href="editproductonly.php?product_id=' + item.pid + '" class="btn btn-success btn-xs" role="button">' +
          '<span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>' +
          '</div>';
      } else {
        return '<div class="btn-group">' +
          '<a href="viewproductonly.php?product_id=' + item.pid + '" class="btn btn-warning btn-xs" role="button">' +
          '<span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>' +
          '</div>';
      }
    }

    // Debounce function to limit the rate at which a function can fire
    function debounce(func, wait, immediate) {
      let timeout;
      return function () {
        let context = this, args = arguments;
        let later = function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        let callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    }
  });


</script>
