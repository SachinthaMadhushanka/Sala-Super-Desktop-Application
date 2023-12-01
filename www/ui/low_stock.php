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

<!-- HTML Structure -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
    </div><!-- /.container-fluid -->
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header d-flex">
              <h5 class="m-0" style="font-weight: bold">Low Stock Products</h5>
              <input type="text" id="customSearchBox" placeholder="Search Product" class="ml-auto"
                     style="height: 35px; padding-left: 10px; padding-right: 10px" autofocus>
            </div>
            <div class="card-body">
              <table class="table table-hover" id="table_product">
                <thead>
                <tr style="font-weight: bold">
                  <td>Barcode</td>
                  <td>Product</td>
                  <td>Category</td>
                  <td>Description</td>
                  <td>Stock</td>
                </tr>
                </thead>
                <tbody style="background-color:#f7f5f5 "></tbody>
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

<?php include_once "footer.php"; ?>

<!-- JavaScript -->
<script>
  $(document).ready(function () {
    loadProductData();

    // Debounce function to limit the rate at which a function can fire
    function debounce(func, wait, immediate) {
      let timeout;
      return function () {
        const context = this, args = arguments;
        const later = function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    }

    // Event listener for search input with debounce
    $('#customSearchBox').on('keyup', debounce(function () {
      loadProductData(this.value);
    }, 300)); // Adjust debounce time as needed

    function loadProductData(searchTerm = '') {
      $.ajax({
        url: '../API/getLowStockProducts.php', // Replace with the path to your PHP file that retrieves product data
        method: 'GET',
        data: {search: searchTerm},
        success: function (data) {
          let products = JSON.parse(data);
          populateTable(products);
        }
      });
    }

    function populateTable(products) {
      let tbody = $('#table_product tbody');
      tbody.empty();

      products.forEach(function (product) {
        let tr = $('<tr></tr>');
        // Color coding based on stock level
        if (product.total_stock <= 0) {
          tr.addClass('table-danger'); // Red for no stock
        } else if (product.total_stock < 5) {
          tr.addClass('table-warning'); // Yellow for low stock
        }

        tr.append(`<td>${product.barcode}</td>`);
        tr.append(`<td>${product.product}</td>`);
        tr.append(`<td>${product.category}</td>`);
        tr.append(`<td>${product.description}</td>`);

        // Format total_stock based on whether it is a whole number or a float
        let formattedStock = (product.total_stock % 1 === 0)
          ? parseInt(product.total_stock)
          : parseFloat(product.total_stock).toFixed(2);

        tr.append(`<td>${formattedStock}</td>`); // Stock value with or without decimal places
        // Add action buttons here based on your logic
        tbody.append(tr);
      });
    }
  });
</script>
