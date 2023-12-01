<?php
ob_start();
include_once '../API/connectdb.php';
session_start();

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {

  header('location:../index.php');

}

if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {

  include_once 'headeruser.php';
}


function fill_product($pdo)
{

  $output = '';
  $select = $pdo->prepare("select * from Product order by product asc");

  $select->execute();

  $result = $select->fetchAll();

  foreach ($result as $row) {
    $output .= '<option value="' . $row["pid"] . '">' . $row["product"] . '</option>';

  }

  return $output;

}


ob_end_flush();

?>


<style type="text/css">

  .tableFixHead {
    overflow: scroll;
    height: 400px;
  }

  .tableFixHead thead th {
    position: sticky;
    top: 0;
    z-index: 1;
  }

  table {
    border-collapse: collapse;
    width: 100px;
  }

  th, td {
    padding: 8px 16px;
  }

  th {
    background: #eee;
  }


</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Point Of Sale</h1> -->
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
            <div class="card-header">
              <h5 class="m-0" style="font-weight: bold">Discounts</h5>
            </div>


            <div class="card-body">

              <div class="row">
                <div class="col-md-9">

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Scan Barcode" autocomplete="off"
                           name="txtbarcode" id="txtbarcode_id" autofocus>
                  </div>


                  <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;"
                          id="productsearch_id">


                    <option>Select OR Search</option><?php echo fill_product($pdo); ?>

                  </select>
                </div>

                <div class="col-md-3">
                  <div class="card-footer"
                       style="height: 90px; display: flex; justify-content: center; align-items: center; background-color: transparent;">
                    <button type="submit" class="btn btn-success" name="updatediscountsbtn" id="updatediscountsbtn"
                            style="height: 50px">
                      Update Discounts
                    </button>
                  </div>
                </div>


              </div>

              </br>
              <div class="row">
                <div class="col-md-12">
                  <div class="tableFixHead">
                    <table id="producttable" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Our Price</th>
                        <th>Discount</th>
                        <th>Delete</th>
                      </tr>
                      </thead>
                      <tbody class="details" id="itemtable">
                      <tr data-widget="expandable-table" aria-expanded="false">

                      </tr>
                      </tbody>
                    </table>


                  </div>
                </div>
              </div>

            </div>

            <div class="card-header d-flex">
              <h5 class="m-0" style="font-weight: bold">Stocks With Discounts</h5>
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
                  <td>OurPrice</td>
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
                      ProductStock.saleprice,
                      ProductStock.ourprice
                  FROM Product
                  INNER JOIN Category ON Product.catid = Category.catid
                  RIGHT JOIN Product_Stock AS ProductStock ON Product.pid = ProductStock.pid
                  WHERE ProductStock.saleprice != ProductStock.ourprice
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
                      echo '<td>' . $item->ourprice . '</td>';
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

        </form>

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

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {

  ?>
  <script>


    Swal.fire({
      icon: '<?php echo $_SESSION['status_code'];?>',
      title: '<?php echo $_SESSION['status'];?>'
    });

  </script>
  <?php
  unset($_SESSION['status']);
}
?>

<script>
  //Initialize Select2 Elements
  $('.select2').select2();

  //Initialize Select2 Elements with Bootstrap 4 theme
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  function handleEnter(event, stock_id) {
    if (event.key === "Enter") {
      event.preventDefault();

      // Logic to determine the next element's ID
      let nextElementId = 'txtbarcode_id';
      document.getElementById(nextElementId).focus();
    }
  }

  // When lose focus from our price field
  function handleBlurOurPrice(event, stock_id) {
    let ourPrice = parseFloat($('#our_price_id' + stock_id).val());
    let purchasePrice = parseFloat($('#purchase_price_id' + stock_id).val());
    let sellingPrice = parseFloat($('#selling_price_id' + stock_id).val());

    if (!ourPrice) {
      Swal.fire("WARNING!", "SORRY! Our Price Cannot Be Empty", "warning").then((result) => {
        $('#our_price_id' + stock_id).val(sellingPrice).select().trigger('change');
      });
    }
    if (ourPrice < purchasePrice) {
      Swal.fire("WARNING!", "SORRY! Our Price Cannot Be Less Than Purchase Price", "warning").then((result) => {
        $('#our_price_id' + stock_id).val(purchasePrice).select().trigger('change');
      });
    } else if (ourPrice > sellingPrice) {
      Swal.fire("WARNING!", "SORRY! Our Price Cannot Be Greater Than Selling Price", "warning").then((result) => {
        $('#our_price_id' + stock_id).val(sellingPrice).select().trigger('change');
      });
    }
  }

  let customSearchBoxEnable = false;

  $(document).on('keypress', function (event) {


    let key = event.key;
    let select2Element = $('#productsearch_id'); // This is your Select2 element

    // Check if the key is an alphabetic character, space, or comma

    if (customSearchBoxEnable)
      return;

    if (key.match(/^[A-Za-z ,]$/)) {
      $('.select2-selection').focus();
      disableKeyListeners = true;
      event.preventDefault(); // Prevent any default action

      // Open the Select2 dropdown
      select2Element.select2('open');
      // select2Element.trigger('click');

      // Wait for the dropdown to open
      setTimeout(() => {
        let searchInput = $('.select2-search__field');
        if (searchInput.length > 0) {
          // Set the value and focus
          let currentValue = searchInput.val();
          searchInput.val(currentValue + key);

          // Trigger input event and focus after setting the value
          setTimeout(() => {
            searchInput.trigger('input').focus();
          }, 10);
        }
      }, 50);
    }
  });


  // Handle backspace separately
  $(document).on('keydown', function (event) {
    if (event.key === 'Backspace') {
      let select2Element = $('#productsearch_id'); // This is your Select2 element
      // select2Element.select2('open');

      setTimeout(() => {
        let searchInput = $('.select2-search__field');
        if (searchInput.length > 0 && searchInput.val().length > 0) {
          // Remove the last character from the search input
          let currentValue = searchInput.val();
          searchInput.val(currentValue.slice(0, -1)).focus().trigger('input');
        }
      }, 50);
    }
  });


  $(function () {
    productarr = []; // Keep track of products (by stock_id) added to the table

    $('#txtbarcode_id').on('change', function () {
      let barcode = $("#txtbarcode_id").val();

      $.ajax({
        url: "../API/posGetProductsByBarcode.php",
        method: "get",
        dataType: "json",
        data: {barcode: barcode},
        success: function (response) {

          $.each(response.data, function (index, item) {
            let stock_id = item.stock_id;

            if (jQuery.inArray(stock_id, productarr) === -1) {
              let discount = item.saleprice - item.ourprice;
              addrow(item.pid, item.product, item.stock, item.purchaseprice, item.saleprice, item.ourprice, discount, stock_id);
              productarr.push(stock_id);
            }
            autoFocusOnElementById("our_price_id" + stock_id);

            // updateOrderButtonState();

            // autoFocusOnElementById("qty_id" + stock_id);
          });

          $("#txtbarcode_id").val("");
        }
      });
    });


    $('#productsearch_id').on('change', function () {
        let selectedID = $(this).val();
        if (selectedID) {
          $.ajax({
            url: "../API/posGetProductById.php",
            method: "get",
            dataType: "json",
            data: {pid: selectedID},
            success: function (response) {

              $.each(response.data, function (index, item) {
                let stock_id = item.stock_id;

                if (jQuery.inArray(stock_id, productarr) === -1) {
                  let discount = item.saleprice - item.ourprice;
                  addrow(item.pid, item.product, item.stock, item.purchaseprice, item.saleprice, item.ourprice, discount, stock_id);
                  productarr.push(stock_id);

                  // updateOrderButtonState();
                  // autoFocusOnElementById("qty_id" + stock_id);
                }
                autoFocusOnElementById("our_price_id" + stock_id);

              })

              $("#productsearch_id").val("").trigger('change');

            }
          });
        }
      }
    )


    function autoFocusOnElementById(elementId) {
      document.getElementById(elementId).focus();
    }


    function addrow(pid, product, stock, purchase_price, selling_price, our_price, discount, stock_id) {
      let tr =
        '<tr>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-dark">' + product + '</span><input type="hidden" class="form-control pid" value="' + pid + '" ><input type="hidden" class="form-control product" value="' + product + '" >  </td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary stocklbl" id="stock_qty_id' + stock_id + '">' + stock + '</span><input type="hidden" class="form-control stock_id" id="stock_qty_id' + stock_id + '" value="' + stock_id + '"><input type="hidden" class="form-control stock_qty" id="stock_qty' + stock_id + '" value="' + stock + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning price">' + purchase_price + '</span><input type="hidden" class="form-control" id="purchase_price_id' + stock_id + '" value="' + purchase_price + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning price">' + selling_price + '</span><input type="hidden" class="form-control" id="selling_price_id' + stock_id + '" value="' + selling_price + '"></td>' +
        '<td><input style="width: 120px" type="number" required class="form-control price our_price_input" id="our_price_id' + stock_id + '" value="' + our_price + '" min="' + purchase_price + '" size="1" onkeydown="handleEnter(event, ' + stock_id + ')" onblur="handleBlurOurPrice(event, ' + stock_id + ')"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning qty" id="discount_id' + stock_id + '">' + discount.toFixed(2) + '</span><input type="hidden" class="form-control" id="discount_id' + stock_id + '" value="' + discount + '"></td>' +
        '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove" data-id="' + stock_id + '"><span class="fas fa-trash"></span></button></center></td>' +
        '</tr>';


      $('.details').append(tr);

      let ourPriceInput = $('#our_price_id' + stock_id);
      ourPriceInput.focus();
      ourPriceInput.select();

      let isMultiple = $('#itemtable .pid[value="' + pid + '"]').length > 1;
      if (isMultiple) {
        $('#itemtable .pid[value="' + pid + '"]').closest('tr').css('background-color', '#FFCCCC');
      }

      // Add event listener for changes in our price input
      $('#our_price_id' + stock_id).on('keyup change', function () {
        let ourPrice = parseFloat($(this).val());
        let sellingPrice = parseFloat($('#selling_price_id' + stock_id).val());
        let discountValue = sellingPrice - ourPrice;

        $('#discount_id' + stock_id).text(discountValue.toFixed(2));
        $('#discount_input_id' + stock_id).val(discountValue.toFixed(2));
      });
      // updateOrderButtonState();
    }

    // updateOrderButtonState();

  });


  // Press delete icon
  $(document).on('click', '.btnremove', function () {
    // Find the stock_id of the row being removed
    let row = $(this).closest('tr');
    let stock_id = row.find('input[id^="stock_qty_id"]').val(); // Assuming stock_id is stored in a hidden input field

    console.log(stock_id);
    console.log(typeof stock_id);
    // Remove the stock_id from the productarr array
    productarr = productarr.filter(item => item != stock_id);


    // Remove the row
    row.remove();

    // Focus on the 'our price' input of the latest row, if it exists
    let lastRowStockId = $('.details tr:last .our_price_input').attr('id');
    if (lastRowStockId) {
      $('#' + lastRowStockId).focus().select();
    }

    console.log(productarr);
  });


  let addPressed = false;
  let enterPressed = false;
  let addEnterUsed = false; // Flag to indicate + (NumpadAdd) + Enter combination was used
  let disableKeyListeners = false; // Global flag to disable specific key listeners
  let onBarcodeEntry = false;

  // Detect when + (NumpadAdd) or Enter is pressed down
  document.addEventListener('keydown', function (e) {
    console.log("disableKeyListeners value:", disableKeyListeners);

    if (disableKeyListeners) {
      if (e.key === "Enter") {
        disableKeyListeners = false;
      }
      return;
    }

    if (e.code === "NumpadAdd") {
      addPressed = true;
      // Prevent the default '+' character from being inputted
      e.preventDefault();
    }

    if (e.key === "Enter") {
      if (!onBarcodeEntry) {

        enterPressed = true;
        // If + is already pressed, we prevent the Enter key from doing its default action
        if (addPressed) {
          e.preventDefault();
        }
      }
      onBarcodeEntry = false;

    }

    // Check for + (NumpadAdd) + Enter combination
    if (addPressed && enterPressed) {
      addEnterUsed = true; // Set flag indicating + (NumpadAdd) + Enter was used
      document.querySelector('button[name="updatediscountsbtn"]').click();
      // Prevent the default '+' character from being inputted
      e.preventDefault();
    }
  });

  // Perform actions on keyup
  document.addEventListener('keyup', function (e) {
    if (disableKeyListeners) {
      if (e.key === "Enter") {
        disableKeyListeners = false;
      }
      return;
    }


    // Skip other actions if + (NumpadAdd) + Enter was used
    if (addEnterUsed) {
      addEnterUsed = false; // Reset the flag
      addPressed = false; // Reset the + (NumpadAdd) pressed flag
      enterPressed = false; // Reset the Enter pressed flag
      return; // Exit the function
    }

    // Action for Enter only
    if (enterPressed && e.key === "Enter") {
      if (!onBarcodeEntry) {
        $('#txtbarcode_id').focus(); // Focus on the barcode entry
        enterPressed = false; // Reset the Enter pressed flag
      }
      onBarcodeEntry = false;
    }
  });


  document.getElementById('txtbarcode_id').addEventListener('change', (event) => {
    onBarcodeEntry = true;
  });


</script>


<script>
  $(document).ready(function () {
    $('#updatediscountsbtn').click(function (e) {
      e.preventDefault(); // Prevents the default form submit action

      let discountData = $('.stock_id').map(function () {
        let stock_id = $(this).val();
        let ourprice_id = '#our_price_id' + stock_id;
        let ourprice = $(ourprice_id).val();

        // Return an object containing the stock ID, sale price, and quantity for each item
        return {
          stock_id: stock_id,
          our_price: (ourprice - 0).toFixed(2),
        };
      }).get();

      console.log(discountData);

      // AJAX request to your API endpoint
      $.ajax({
        url: '../API/updateDiscounts.php', // Replace with the actual URL to your API
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({data: discountData}),
        success: function (response) {
          // Handle success - you can show a message or update the UI as needed
          console.log(response);


          Swal.fire({
            icon: "success",
            title: "Order Processed Successfully"
          }).then((result) => {
            window.location.reload();

          });
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error(error);
          Swal.fire("Error!", "An error occurred while updating discounts.", "error");
        }
      });
    });
  });
</script>


<script>
  //-------------------------------------------------------------------------------------
  // Stocks with discounts
  //-------------------------------------------------------------------------------------

  $(document).ready(function () {
    $('#customSearchBox').on('focus', function () {
      customSearchBoxEnable = true;
    });

    $('#customSearchBox').on('blur', function () {
      customSearchBoxEnable = false;
    });
  });


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
        tr.append('<td>' + item.ourprice + '</td>');


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
    $('#customSearchBox').on('keyup', debounce(function () {
      let searchTerm = $(this).val();
      $.ajax({
        method: "GET",
        url: "../API/getDiscountedProducts.php",
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



