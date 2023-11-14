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
              <h5 class="m-0" style="font-weight: bold">Current Stock</h5>
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
                  <td>Stock</td>
                  <td>PurchasePrice</td>
                  <td>SalePrice</td>
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
                      Product.description,
                      ProductStock.id as stock_id,
                      ProductStock.stock,
                      ProductStock.purchaseprice,
                      ProductStock.saleprice
                  FROM Product
                  INNER JOIN Category ON Product.catid = Category.catid
                  LEFT JOIN Product_Stock AS ProductStock ON Product.pid = ProductStock.pid
                  ORDER BY Product.pid ASC
              ");

                $select->execute();
                $rows = $select->fetchAll(PDO::FETCH_OBJ);


                if ($rows) {

                  // Step 2: Group by barcode
                  $groupedData = [];
                  foreach ($rows as $row) {
                    $groupedData[$row->barcode][] = $row;
                  }


                  // Step 3: Generate table
                  foreach ($groupedData as $barcode => $data) {
                    $rowspan = count($data);
                    $isBarcodeDisplayed = false;

                    foreach ($data as $item) {
                      echo '<tr>';

                      // Display barcode, product, category, description only once and use rowspan
                      if (!$isBarcodeDisplayed) {
                        echo '<td rowspan="' . $rowspan . '">' . $item->barcode . '</td>';
                        echo '<td rowspan="' . $rowspan . '">' . $item->product . '</td>';
                        echo '<td rowspan="' . $rowspan . '">' . $item->category . '</td>';
                        echo '<td rowspan="' . $rowspan . '">' . $item->description . '</td>';
                        $isBarcodeDisplayed = true;
                      }

                      // Display stock, purchase price, sale price, and action icons/buttons for each entry
                      echo '<td>' . $item->stock . '</td>';
                      echo '<td>' . $item->purchaseprice . '</td>';
                      echo '<td>' . $item->saleprice . '</td>';
                      echo '<td>';
                      // Your action icons/buttons go here
                      echo '<div class="btn-group">';
                      echo '<a href="printbarcode.php?stock_id=' . $item->stock_id . '" class="btn btn-dark btn-xs" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>';
                      echo '<a href="viewproduct.php?stock_id=' . $item->stock_id . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>';

                      if ($_SESSION['role'] == "Admin") {
                        echo '<a href="editstock.php?stock_id=' . $item->stock_id . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>';
                      }
//                    echo '<button stock_id="' . $item->stock_id . '" class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>';
                      echo '</div>';
                      echo '</td>';
                      echo '</tr>';
                    }
                  }
                } else {
                  // Display a message when there are no products
                  echo "<tr><td colspan='8'>No products found in the database.</td></tr>";
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

  function populateTable(groupedData) {
    let tbody = $('#table_product tbody');
    tbody.empty(); // Clear existing rows

    for (let barcode in groupedData) {
      let data = groupedData[barcode];
      let rowspan = data.length;
      let isBarcodeDisplayed = false;

      data.forEach(function (item) {
        let tr = $('<tr></tr>');

        if (!isBarcodeDisplayed) {
          tr.append('<td rowspan="' + rowspan + '">' + item.barcode + '</td>');
          tr.append('<td rowspan="' + rowspan + '">' + item.product + '</td>');
          tr.append('<td rowspan="' + rowspan + '">' + item.category + '</td>');
          tr.append('<td rowspan="' + rowspan + '">' + item.description + '</td>');
          isBarcodeDisplayed = true;
        }

        tr.append('<td>' + item.stock + '</td>');
        tr.append('<td>' + item.purchaseprice + '</td>');
        tr.append('<td>' + item.saleprice + '</td>');

        let userRole = <?php echo json_encode($_SESSION['role']); ?>;

        if (userRole === "Admin") {

          let actionButtons = '<div class="btn-group">' +
            '<a href="printbarcode.php?stock_id=' + item.stock_id + '" class="btn btn-dark btn-xs" role="button">' +
            '<span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>' +
            '<a href="viewproduct.php?stock_id=' + item.stock_id + '" class="btn btn-warning btn-xs" role="button">' +
            '<span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>' +
            '<a href="editstock.php?stock_id=' + item.stock_id + '" class="btn btn-success btn-xs" role="button">' +
            '<span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>' +
            '</div>';

          tr.append('<td>' + actionButtons + '</td>');
        } else {
          let actionButtons = '<div class="btn-group">' +
            '<a href="printbarcode.php?stock_id=' + item.stock_id + '" class="btn btn-dark btn-xs" role="button">' +
            '<span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>' +
            '<a href="viewproduct.php?stock_id=' + item.stock_id + '" class="btn btn-warning btn-xs" role="button">' +
            '<span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>' +
            '</div>';

          tr.append('<td>' + actionButtons + '</td>');
        }
        tbody.append(tr);
      });
    }
  }

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

  $(document).ready(function () {

    function generateTable(data) {
      let tbody = $('#table_product tbody');
      tbody.empty(); // Clear existing rows

      tbody.css("backgroundColor", "#f7f5f5");  // Light Gray background color

      let groupedData = [];
      data.forEach(function (row) {
        groupedData[row.barcode] = groupedData[row.barcode] || [];
        groupedData[row.barcode].push(row);
      });

      let rowIndex = 0; // Initialize the counter for row index

      for (let barcode in groupedData) {
        let data = groupedData[barcode];
        let rowspan = data.length;
        let isBarcodeDisplayed = false;

        data.forEach(function (item) {
          let tr = $('<tr></tr>');

          if (!isBarcodeDisplayed) {
            tr.append('<td rowspan="' + rowspan + '">' + item.barcode + '</td>');
            tr.append('<td rowspan="' + rowspan + '">' + item.product + '</td>');
            tr.append('<td rowspan="' + rowspan + '">' + item.category + '</td>');
            tr.append('<td rowspan="' + rowspan + '">' + item.description + '</td>');
            isBarcodeDisplayed = true;
          }

          tr.append('<td>' + item.stock + '</td>');
          tr.append('<td>' + item.purchaseprice + '</td>');
          tr.append('<td>' + item.saleprice + '</td>');

          // Add your action buttons here
          let actionButtons = '<div class="btn-group">' +
            '<a href="printbarcode.php?stock_id=' + item.stock_id + '" class="btn btn-dark btn-xs" role="button">' +
            '<span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="PrintBarcode"></span></a>' +
            '<a href="viewproduct.php?stock_id=' + item.stock_id + '" class="btn btn-warning btn-xs" role="button">' +
            '<span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>' +
            '<a href=' + item.stock_id + '"editstock.php?stock_id=" class="btn btn-success btn-xs" role="button">' +
            '<span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>' +
            // '<button stock_id="' + item.stock_id + '" class="btn btn-danger btn-xs btndelete">' +
            // '<span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>' +
            '</div>';

          tr.append('<td>' + actionButtons + '</td>');
          tbody.append(tr);
        });
      }
    }

    $('#customSearchBox').on('keyup', debounce(function () {
      let searchTerm = $(this).val();
      $.ajax({
        method: "GET",
        url: "../API/getFilteredProducts.php",
        data: {search: searchTerm}
      }).done(function (data) {
        console.log(data);
        if (typeof data === 'string') {
          data = JSON.parse(data);
        }
        // Group by barcode
        let groupedData = [];
        data.forEach(function (row) {
          groupedData[row.barcode] = groupedData[row.barcode] || [];
          groupedData[row.barcode].push(row);
        });

        populateTable(groupedData);
      });
    }, 300)); // 300ms debounce
  });


</script>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


<script>
  $(document).ready(function () {
    $('.btndelete').click(function () {
      let tdh = $(this);
      let stock_id = $(this).attr("stock_id");

      Swal.fire({
        title: 'Do you want to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'productdelete.php',
            type: 'post',
            data: {
              stock_id: stock_id
            },
            success: function (data) {
              if (data === "success") {
                tdh.parents('tr').hide();
                location.reload();

              } else {
                Swal.fire(
                  'Error!',
                  'There was an error deleting the product.',
                  'error'
                )
              }
            },
            error: function () {
              Swal.fire(
                'Error!',
                'There was an error communicating with the server.',
                'error'
              )
            }
          });
        }
      });
    });
  });

</script>
