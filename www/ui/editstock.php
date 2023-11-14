<?php
include_once '../API/connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] != "Admin") {

  header('location:../index.php');

}


if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {

  include_once 'headeruser.php';
}


$stock_id = $_GET['stock_id'];

// Prepare a SQL statement to fetch the product details based on the stock ID.
// The query joins Product, Product_Stock, and Category tables together to gather all necessary details.
$select = $pdo->prepare("
    SELECT
        Product.pid,
        Product.barcode,
        Product.product,
        Category.category,
        Product.description,
        Product_Stock.stock,
        Product_Stock.purchaseprice,
        Product_Stock.saleprice
    FROM Product
    INNER JOIN Product_Stock ON Product.pid = Product_Stock.pid
    INNER JOIN Category ON Product.catid = Category.catid
    WHERE Product_Stock.id = :stock_id
");

$select->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$pid = $row['pid'];
$barcode_db = $row['barcode'];
$product_db = $row['product'];
$category_db = $row['category'];
$description_db = $row['description'];
$stock_db = $row['stock'];
$purchaseprice_db = $row['purchaseprice'];
$saleprice_db = $row['saleprice'];


if (isset($_POST['btneditproduct'])) {
  $saleprice_txt = $_POST['txtsaleprice'];
  if ($purchaseprice_db > $saleprice_txt) {
    // Set session variable to indicate error and prevent DB update
    $_SESSION['status'] = "Selling Price Cannot be Less Than Purchase Price";
    $_SESSION['status_code'] = "error";
  } else {
    try {
      // Begin the transaction
      $pdo->beginTransaction();

      // Prepare the update statement
      $updateStock = $pdo->prepare("UPDATE Product_Stock SET saleprice=:sprice WHERE id=:stock_id");

      // Bind the parameters
      $updateStock->bindParam(':sprice', $saleprice_txt);
      $updateStock->bindParam(':stock_id', $stock_id);

      // Execute the update
      $updateStock->execute();

      // If we reach this point, it means that no exception was thrown
      // and the update was successful, so we can commit the transaction
      $pdo->commit();

      $_SESSION['status'] = "Product Stock Updated Successfully";
      $_SESSION['status_code'] = "success";

      echo '<script type="text/javascript">window.location.href="editstock.php?stock_id=' . $stock_id . '";</script>';
      exit;

    } catch (Exception $e) {
      // An exception has been thrown
      // Rollback the transaction to ensure data integrity
      $pdo->rollBack();

      $_SESSION['status'] = "Product Stock Update Failed";
      $_SESSION['status_code'] = "error";
      echo '<script type="text/javascript">window.location.href="editstock.php?stock_id=' . $stock_id . '";</script>';
      exit;
    }
  }
}


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
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


          <div class="card card-success card-outline">
            <div class="card-header">
              <h5 class="m-0">Edit Stock</h5>
            </div>

            <form action="" method="post" name="formeditproduct" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">

                    <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" class="form-control" value="<?php echo $barcode_db; ?>"
                             placeholder="Enter Barcode" name="txtbarcode" autocomplete="off" disabled>
                    </div>

                    <div class="form-group">
                      <label>Product Name</label>
                      <input type="text" class="form-control" value="<?php echo $product_db; ?>"
                             placeholder="Enter Name" name="txtproductname" autocomplete="off" disabled>
                    </div>

                    <div class="form-group">
                      <label>Category</label>
                      <input type="text" class="form-control" value="<?php echo $category_db; ?>"
                             placeholder="Enter Name" name="txtproductname" autocomplete="off" disabled>
                    </div>


                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4"
                                disabled><?php echo $description_db; ?> </textarea>
                    </div>


                  </div>


                  <div class="col-md-6">


                    <div class="form-group">
                      <label>Stock Quantity</label>
                      <input type="number" min="1" step="any" class="form-control" value="<?php echo $stock_db; ?>"
                             placeholder="Enter Stock" name="txtstock" autocomplete="off" required disabled>
                    </div>


                    <div class="form-group">
                      <label>Purchase Price</label>
                      <input type="number" min="1" step="any" class="form-control"
                             value="<?php echo $purchaseprice_db; ?>" placeholder="Enter Stock"
                             name="txtpurchaseprice" autocomplete="off" required disabled>
                    </div>

                    <div class="form-group">
                      <label>Selling Price</label>
                      <input type="number" min="1" step="any"
                             class="form-control"
                             value="<?php echo $saleprice_db; ?>" placeholder="Enter Selling Price" name="txtsaleprice"
                             autocomplete="off" required autofocus onfocus="this.select()">

                    </div>


                  </div>


                </div>


              </div>

              <div class="card-footer">
                <div class="text-center">
                  <button type="submit" class="btn btn-success" name="btneditproduct">Update Product</button>
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
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && e.ctrlKey) {
      e.preventDefault(); // Prevent default Ctrl+Enter key behavior
      document.querySelector('button[name="btneditproduct"]').click();
    }
  });
</script>
