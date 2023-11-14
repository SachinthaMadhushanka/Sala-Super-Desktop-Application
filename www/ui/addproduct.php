<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../API/connectdb.php';
session_start();


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {

  header('location:../index.php');

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


if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {

  include_once 'headeruser.php';
}


if (isset($_POST['btnsave'])) {
  try {
    // Start the transaction
    $pdo->beginTransaction();

    $barcode = $_POST['txtbarcode'];
    $product = $_POST['txtproductname'];
    $catid = isset($_POST['txtproductcategoryselect']) ? $_POST['txtproductcategoryselect'] : -1;
    $description = $_POST['txtdescription'];
    $stock = $_POST['txtstock'];
    $purchaseprice = $_POST['txtpurchaseprice'];
    $saleprice = $_POST['txtsaleprice'];

    if ($purchaseprice > $saleprice) {
      // Set error message and redirect back to form
      $_SESSION['status'] = "Purchase price cannot be greater than sale price.";
      $_SESSION['status_code'] = "error";
//      echo '<script type="text/javascript">window.location.href="addproduct.php";</script>';
      exit;
    }


    // When the barcode is not given
    if (empty($barcode)) {
      // Compare product name in the database
      $query = $pdo->prepare("SELECT * FROM Product WHERE LOWER(product) LIKE LOWER(:product)");
      $query->bindParam(':product', $product);
      $query->execute();
      if ($query->rowCount() == 0) { // No matching product found by name
        // Insert the product
        $insert = $pdo->prepare("INSERT INTO Product (product, catid, description) VALUES (:product, :catid, :description)");
        $insert->bindParam(':product', $product);
        $insert->bindParam(':catid', $catid);
        $insert->bindParam(':description', $description);
        $insert->execute();
        $pid = $pdo->lastInsertId();

        // Set default timezone to India Standard Time
        date_default_timezone_set("Asia/Kolkata");
        $newbarcode = $pid . date('his');
        // Update product with new barcode
        $update = $pdo->prepare("UPDATE Product SET barcode = :newbarcode WHERE pid = :pid");
        $update->bindParam(':newbarcode', $newbarcode);
        $update->bindParam(':pid', $pid);
        $update->execute();

        // Insert into Product_Stock
        $insertStock = $pdo->prepare("INSERT INTO Product_Stock (pid, stock, purchaseprice, saleprice) VALUES (:pid, :stock, :purchaseprice, :saleprice)");
        $insertStock->bindParam(':pid', $pid);
        $insertStock->bindParam(':stock', $stock);
        $insertStock->bindParam(':purchaseprice', $purchaseprice);
        $insertStock->bindParam(':saleprice', $saleprice);
        $insertStock->execute();

        // Insert into incoming_stock after updating Product_Stock (Barcode not given)
        $insertIncomingStock = $pdo->prepare("INSERT INTO incoming_stock (pid, stock, purchaseprice, saleprice, date_time) VALUES (:pid, :added_stock, :purchaseprice, :saleprice, NOW())");
        $insertIncomingStock->bindParam(':pid', $pid);
        $insertIncomingStock->bindParam(':added_stock', $stock); // Notice we're inserting the added stock, not the new total
        $insertIncomingStock->bindParam(':purchaseprice', $purchaseprice);
        $insertIncomingStock->bindParam(':saleprice', $saleprice);
        $insertIncomingStock->execute();


        // If we reach this point, all operations were successful
        $pdo->commit();
        $_SESSION['status'] = "Product Inserted Successfully";
        $_SESSION['status_code'] = "success";
      } else {
        // Product name already exists, roll back transaction
        $pdo->rollback();
        $_SESSION['status'] = "Product name already exists in the database.";
        $_SESSION['status_code'] = "error";
      }
    } else {
      // When barcode is given
      // Check if the given barcode already exists in the database
      $checkBarcode = $pdo->prepare("SELECT * FROM Product WHERE barcode = :barcode");
      $checkBarcode->bindParam(':barcode', $barcode);
      $checkBarcode->execute();

      if ($checkBarcode->rowCount() == 0) { // No matching barcode found
        // Check if the product name exists
        $checkProduct = $pdo->prepare("SELECT * FROM Product WHERE LOWER(product) = LOWER(:product)");
        $checkProduct->bindParam(':product', $product);
        $checkProduct->execute();

        if ($checkProduct->rowCount() == 0) { // No matching product found by name
          // Insert the product
          $insert = $pdo->prepare("INSERT INTO Product (barcode, product, catid, description) VALUES (:barcode, :product, :catid, :description)");
          $insert->bindParam(':barcode', $barcode);
          $insert->bindParam(':product', $product);
          $insert->bindParam(':catid', $catid);
          $insert->bindParam(':description', $description);
          $insert->execute();
          $pid = $pdo->lastInsertId();

          // Insert into Product_Stock
          $insertStock = $pdo->prepare("INSERT INTO Product_Stock (pid, stock, purchaseprice, saleprice) VALUES (:pid, :stock, :purchaseprice, :saleprice)");
          $insertStock->bindParam(':pid', $pid);
          $insertStock->bindParam(':stock', $stock);
          $insertStock->bindParam(':purchaseprice', $purchaseprice);
          $insertStock->bindParam(':saleprice', $saleprice);
          $insertStock->execute();

          // Insert into incoming_stock after updating Product_Stock (Barcode given, but it is new barcode)
          $insertIncomingStock = $pdo->prepare("INSERT INTO incoming_stock (pid, stock, purchaseprice, saleprice, date_time) VALUES (:pid, :added_stock, :purchaseprice, :saleprice, NOW())");
          $insertIncomingStock->bindParam(':pid', $pid);
          $insertIncomingStock->bindParam(':added_stock', $stock); // Notice we're inserting the added stock, not the new total
          $insertIncomingStock->bindParam(':purchaseprice', $purchaseprice);
          $insertIncomingStock->bindParam(':saleprice', $saleprice);
          $insertIncomingStock->execute();

          // Commit the transaction
          $pdo->commit();
          $_SESSION['status'] = "Product Inserted Successfully";
          $_SESSION['status_code'] = "success";
        } else {
          // Product name already exists, roll back transaction
          $pdo->rollback();
          $_SESSION['status'] = "Product name already exists in the database.";
          $_SESSION['status_code'] = "error";
        }
      } else {
        // Barcode exists in the database
        $barcodeRow = $checkBarcode->fetch(PDO::FETCH_ASSOC);
        $pid = $barcodeRow['pid'];

        $checkStock = $pdo->prepare("SELECT * FROM Product_Stock WHERE pid = :pid AND purchaseprice = :purchaseprice AND saleprice = :saleprice");
        $checkStock->bindParam(':pid', $pid);
        $checkStock->bindParam(':purchaseprice', $purchaseprice);
        $checkStock->bindParam(':saleprice', $saleprice);
        $checkStock->execute();

        if ($checkStock->rowCount() > 0) {
          // Matching PID with the same purchase price and sale price exists, update the stock
          $row = $checkStock->fetch(PDO::FETCH_ASSOC);
          $newStock = $row['stock'] + $stock;

          $updateStock = $pdo->prepare("UPDATE Product_Stock SET stock = :stock WHERE id = :id");
          $updateStock->bindParam(':stock', $newStock);
          $updateStock->bindParam(':id', $row['id']);
          $updateStock->execute();

          // Insert into incoming_stock after updating Product_Stock (Barcode given, it exists, stock exists with same purchase and sale price)
          $insertIncomingStock = $pdo->prepare("INSERT INTO incoming_stock (pid, stock, purchaseprice, saleprice, date_time) VALUES (:pid, :added_stock, :purchaseprice, :saleprice, NOW())");
          $insertIncomingStock->bindParam(':pid', $pid);
          $insertIncomingStock->bindParam(':added_stock', $stock); // Notice we're inserting the added stock, not the new total
          $insertIncomingStock->bindParam(':purchaseprice', $purchaseprice);
          $insertIncomingStock->bindParam(':saleprice', $saleprice);
          $insertIncomingStock->execute();

          // Commit the transaction
          $pdo->commit();
          $_SESSION['status'] = "Stock Updated Successfully";
          $_SESSION['status_code'] = "success";
        } else {
          // No matching PID with the given purchase and sale price, insert new stock entry
          $insertStock = $pdo->prepare("INSERT INTO Product_Stock (pid, stock, purchaseprice, saleprice) VALUES (:pid, :stock, :purchaseprice, :saleprice)");
          $insertStock->bindParam(':pid', $pid);
          $insertStock->bindParam(':stock', $stock);
          $insertStock->bindParam(':purchaseprice', $purchaseprice);
          $insertStock->bindParam(':saleprice', $saleprice);
          $insertStock->execute();

          // Insert into incoming_stock after updating Product_Stock (Barcode given, it exists, stock does not exist with same purchase and sale price)
          $insertIncomingStock = $pdo->prepare("INSERT INTO incoming_stock (pid, stock, purchaseprice, saleprice, date_time) VALUES (:pid, :added_stock, :purchaseprice, :saleprice, NOW())");
          $insertIncomingStock->bindParam(':pid', $pid);
          $insertIncomingStock->bindParam(':added_stock', $stock); // Notice we're inserting the added stock, not the new total
          $insertIncomingStock->bindParam(':purchaseprice', $purchaseprice);
          $insertIncomingStock->bindParam(':saleprice', $saleprice);
          $insertIncomingStock->execute();

          // Commit the transaction
          $pdo->commit();
          $_SESSION['status'] = "New Stock Inserted Successfully";
          $_SESSION['status_code'] = "success";
        }
      }
    }
  } catch (Exception $e) {
    // An error occurred, roll back the transaction
    $pdo->rollback();
    $_SESSION['status'] = "Transaction Failed: " . $e->getMessage();
    $_SESSION['status_code'] = "error";
  }

  // Redirect after operation
  echo '<script type="text/javascript">window.location.href="addproduct.php";</script>';
  exit;
}


?>

<style type="text/css">
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type="number"] {
    -moz-appearance: textfield;
  }

  /* Error styling for inputs */
  input.error {
    border: 2px solid red;
  }

  /* Specificity for focused inputs with error */
  input.error:focus {
    border: 2px solid red;
    /* Add any additional styling you need for a focused input with an error */
  }

  /* General active (focused) input styling */
  input:focus {
    /* Define active styles, which will be overridden by the error style if both classes are present */
    border: 2px solid blue;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Product</h1>
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
              <h5 class="m-0">Product</h5>
            </div>


            <form action="" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">

                    <div class="form-group">
                      <label>Barcode</label>
                      <input type="number" class="form-control" placeholder="Enter Barcode" name="txtbarcode"
                             id="txtbarcode_id" autocomplete="off" autofocus>
                    </div>

                    <!--                    <div class="form-group">-->
                    <!--                      <label>Product ID</label>-->
                    <!--                      <input type="text" class="form-control" placeholder="Enter Product ID" name="txtproduct"-->
                    <!--                             id="txtproduct_id" autocomplete="off">-->
                    <!--                    </div>-->

                    <div class="form-group">
                      <label>Search Product (Optional)</label>
                      <select class="form-control" data-dropdown-css-class="select2-purple"
                              style="width: 100%;" name="txtproductselect">
                        <option value="-1">New Product</option><?php echo fill_product($pdo); ?>

                      </select>
                    </div>


                    <div class="form-group">
                      <label>Product Name</label>
                      <input type="text" class="form-control" placeholder="Enter Name" name="txtproductname"
                             autocomplete="off" id="txtproductname_id" required>
                    </div>

                    <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="txtproductcategoryselect" required>
                        <option value="" disabled selected>Select Category</option>

                        <?php
                        $select = $pdo->prepare("select * from Category order by catid desc");
                        $select->execute();

                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);

                          ?>
                          <option value="<?php echo $row['catid'] ?>"><?php echo $row['category']; ?></option>

                          <?php

                        }

                        ?>


                      </select>
                    </div>


                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4"
                                id="txtdescription_id"></textarea>
                    </div>


                  </div>


                  <div class="col-md-6">


                    <div class="form-group">
                      <label>Stock Quantity</label>
                      <input type="number" min="1" step="any" class="form-control" placeholder="Enter Stock"
                             name="txtstock" autocomplete="off" required onblur="stockOnBlur()">
                    </div>


                    <div class="form-group">
                      <label>Purchase Price</label>
                      <input type="number" min="0" step="any" class="form-control" placeholder="Enter Purchase Price"
                             name="txtpurchaseprice" autocomplete="off" required oninput="validatePrices()"
                             onblur="purchasePriceOnBlur()">
                    </div>

                    <div class="form-group">
                      <label>Selling Price</label>
                      <input type="number" min="1" step="any" class="form-control" placeholder="Enter Selling Price"
                             name="txtsaleprice" autocomplete="off" required oninput="validatePrices()"
                             onblur="salePriceOnBlur()">
                    </div>

                  </div>


                </div>


              </div>

              <div class="card-footer">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="btnsave" disabled>Save Product</button>
                </div>
              </div>

            </form>


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
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })


  function onBarcodeChange() {
    console.log("changed barcode");

    var barcode = $("#txtbarcode_id").val();
    console.log(barcode);

    $.ajax({
      url: "../API/getproduct_by_barcode.php",
      method: "get",
      dataType: "json",
      data: {id: barcode},
      success: function (response) {


        console.log(response);

        $('select[name="txtproductselect"]').off('change', onProductSelectChange);

        // Check the status of the response
        if (response.status === 'success') {
          $('select[name="txtproductselect"]').val(response.data.pid.toString()).trigger('change').trigger('change.select2');
          $('#txtproductname_id').val(response.data.product).prop('readonly', true);
          $('select[name="txtproductcategoryselect"]').val(response.data.catid).prop('disabled', true);
          $('#txtdescription_id').val(response.data.description).prop('readonly', true);


        } else if (response.status === 'error') {
          // Clear the product ID field if the product is not found
          $('select[name="txtproductselect"]').val('-1').trigger('change').trigger('change.select2');
          $('#txtproductname_id').val('').prop('readonly', false);
          $('select[name="txtproductcategoryselect"]').val('').prop('disabled', false);
          $('#txtdescription_id').val('').prop('readonly', false);
        }

        $('select[name="txtproductselect"]').on('change', onProductSelectChange);

        $('[name="txtstock"]').focus();


      }

    });
  }

  function onProductSelectChange() {
    console.log("changed product select");
    console.log($('select[name="txtproductselect"]').val())

    let pid = $('select[name="txtproductselect"]').val();

    $.ajax({
      url: "../API/getproduct_by_id.php",
      method: "get",
      dataType: "json",
      data: {id: pid},
      success: function (response) {

        console.log(response);

        // Check the status of the response
        if (response.status === 'success') {
          $("#txtbarcode_id").val(response.data.barcode);
          $('#txtproductname_id').val(response.data.product).prop('readonly', true);
          $('select[name="txtproductcategoryselect"]').val(response.data.catid).prop('disabled', true);
          $('#txtdescription_id').val(response.data.description).prop('readonly', true);


        } else if (response.status === 'error') {
          // Clear the product ID field if the product is not found
          $("#txtbarcode_id").val('');
          $('#txtproductname_id').val('').prop('readonly', false);
          $('select[name="txtproductcategoryselect"]').val('').prop('disabled', false);
          $('#txtdescription_id').val('').prop('readonly', false);

        }

        $('[name="txtstock"]').focus();

      }
    });
  }

  $(function () {
    $('#txtbarcode_id').on('change', onBarcodeChange);
    $('select[name="txtproductselect"]').on('change', onProductSelectChange);

  });


</script>


<!-- Key Mappings-->
<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    // Function to find next input field, skipping disabled fields and the "Search Product" select box
    function findNextInput(currentInput, reverse = false) {
      let inputs = Array.from(document.querySelectorAll('input:not([disabled]), select:not([disabled]), textarea:not([disabled])'));
      let currentIndex = inputs.indexOf(currentInput);
      let nextIndex = currentIndex;

      do {
        nextIndex = reverse ? nextIndex - 1 : nextIndex + 1; // Determine next index
        // Wrap around if out of bounds
        if (nextIndex >= inputs.length) nextIndex = 0;
        if (nextIndex < 0) nextIndex = inputs.length - 1;
      } while (inputs[nextIndex].name === 'txtproductselect') // Skip the "Search Product" select box

      return inputs[nextIndex];
    }


    // Event listener for arrow up/down keys
    document.addEventListener('keydown', function (e) {
      if (e.target.tagName.match(/INPUT|SELECT|TEXTAREA/)) {
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
          e.preventDefault(); // Prevent default arrow key behavior
          let nextInput = findNextInput(e.target, e.key === 'ArrowUp');
          nextInput.focus();
        }
      }
    });

    // Event listener for Enter key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && e.target.tagName.match(/INPUT|SELECT/)) {
        e.preventDefault(); // Prevent default Enter key behavior
        // Find next input, skipping if it's the "Search Product" field
        let nextInput = findNextInput(e.target);
        // Move focus to next input
        nextInput.focus();
      }
    });

    // Event listener for Ctrl + Enter key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && e.ctrlKey) {
        e.preventDefault(); // Prevent default Ctrl+Enter key behavior
        document.querySelector('button[name="btnsave"]').click(); // Trigger the save button
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && e.ctrlKey) {
        e.preventDefault(); // Prevent default Ctrl+Enter key behavior
        document.querySelector('button[name="btnsave"]').click();
      }
    });
  });
</script>

<script type="text/javascript">
  function validatePrices() {
    var purchasePrice = document.getElementsByName('txtpurchaseprice')[0].value;
    var salePrice = document.getElementsByName('txtsaleprice')[0].value;

    var salePriceField = document.getElementsByName('txtsaleprice')[0];

    // Remove error class first
    salePriceField.classList.remove('error');

    if (parseFloat(purchasePrice) > parseFloat(salePrice)) {
      // Apply error class
      salePriceField.classList.add('error');
    }
  }


  function purchasePriceOnBlur() {
    if (document.getElementsByName('txtpurchaseprice')[0].value < 0) {
      document.getElementsByName('txtpurchaseprice')[0].value = 1;
    }
  }

  function salePriceOnBlur() {
    if (document.getElementsByName('txtsaleprice')[0].value <= 0) {
      document.getElementsByName('txtsaleprice')[0].value = 1;
    }
  }

  function stockOnBlur() {
    if (document.getElementsByName('txtstock')[0].value <= 0) {
      document.getElementsByName('txtstock')[0].value = 1;
    }
  }

</script>

<!-- Disable add product button -->
<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    const btnSave = document.getElementsByName('btnsave')[0];
    const stockInput = document.getElementsByName('txtstock')[0];
    const purchasePriceInput = document.getElementsByName('txtpurchaseprice')[0];
    const sellingPriceInput = document.getElementsByName('txtsaleprice')[0];
    const productsSelect = document.getElementsByName('txtproductselect')[0];

    function validateInputs() {
      const stock = parseFloat(stockInput.value);
      const purchasePrice = parseFloat(purchasePriceInput.value);
      const sellingPrice = parseFloat(sellingPriceInput.value);

      console.log(stock, purchasePrice, sellingPrice);

      // Check if any of the values are negative or purchase price is greater than selling price
      if (isNaN(stock) || stock < 0 || isNaN(purchasePrice) || purchasePrice < 0 || isNaN(sellingPrice) || sellingPrice < 0 || purchasePrice > sellingPrice) {
        btnSave.disabled = true;
      } else {
        btnSave.disabled = false;
      }
    }


    // Add event listeners for when the user types in the input fields
    stockInput.addEventListener('input', validateInputs);
    purchasePriceInput.addEventListener('input', validateInputs);
    sellingPriceInput.addEventListener('input', validateInputs);


    $(document).ready(function () {
      // Initialize select2 if not already initialized (optional)
      $('select[name="txtproductselect"]').select2();

      // Event when select2 is opened
      $('select[name="txtproductselect"]').on('select2:open', function (e) {
        // Focus the search input after the dropdown is opened
        $('.select2-search__field').focus();
      });

      // ... your other code ...
    });

  });

</script>
