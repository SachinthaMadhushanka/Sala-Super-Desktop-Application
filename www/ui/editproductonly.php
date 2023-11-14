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


$product_id = $_GET['product_id'];

// Prepare a SQL statement to fetch the product details based on the stock ID.
// The query joins Product, Product_Stock, and Category tables together to gather all necessary details.
$select = $pdo->prepare("
    SELECT
        Product.pid,
        Product.barcode,
        Product.product,
        Product.catid,
        Category.category,
        Product.description
    FROM Product
    INNER JOIN Category ON Product.catid = Category.catid
    WHERE Product.pid = :product_id
");

$select->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$pid = $row['pid'];
$barcode_db = $row['barcode'];
$product_db = $row['product'];
$category_db = $row['category'];
$catid_db = $row['catid'];
$description_db = $row['description'];

if (isset($_POST['btneditproduct'])) {
  try {
    $product = $_POST['txtproductname'];
    $catid = $_POST['txtproductcategoryselect'];
    $description = $_POST['txtdescription'];

    // Begin the transaction
    $pdo->beginTransaction();

    // Check if the product exists and is not the same as the one being updated
    $query = $pdo->prepare("SELECT * FROM Product WHERE LOWER(product) = LOWER(:product) AND pid != :product_id");
    $query->bindParam(':product', $product);
    $query->bindParam(':product_id', $product_id);
    $query->execute();

    if ($query->rowCount() == 0) { // No matching product found with the same name
      // Update the product
      $update = $pdo->prepare("UPDATE Product SET product = :product, catid = :catid, description = :description WHERE pid = :product_id");
      $update->bindParam(':product', $product);
      $update->bindParam(':catid', $catid);
      $update->bindParam(':description', $description);
      $update->bindParam(':product_id', $product_id);
      $update->execute();

      // Commit the transaction
      $pdo->commit();
      $_SESSION['status'] = "Product Updated Successfully";
      $_SESSION['status_code'] = "success";
      echo '<script type="text/javascript">window.location.href="editproductonly.php?product_id=' . $product_id . '";</script>';
      exit;
    } else {
      // A product with the same name already exists
      $pdo->rollBack();
      $_SESSION['status'] = "Product name already exists in the database.";
      $_SESSION['status_code'] = "error";
      echo '<script type="text/javascript">window.location.href="editproductonly.php?product_id=' . $product_id . '";</script>';
      exit;

    }

  } catch (Exception $e) {
    $pdo->rollback();
    $_SESSION['status'] = "Transaction Failed: " . $e->getMessage();
    $_SESSION['status_code'] = "error";
    echo '<script type="text/javascript">window.location.href="editproductonly.php?product_id=' . $product_id . '";</script>';
    exit;

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
              <h5 class="m-0">Edit Product</h5>
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
                             placeholder="Enter Name" name="txtproductname" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="txtproductcategoryselect" required>
                        <option value="" disabled>Select Category</option>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM Category ORDER BY catid DESC");
                        $select->execute();
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                          $selected = ($catid_db == $row['catid']) ? 'selected' : '';
                          echo '<option value="' . $row['catid'] . '" ' . $selected . '>' . $row['category'] . '</option>';
                        }
                        ?>
                      </select>

                    </div>


                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" placeholder="Enter Description" name="txtdescription"
                                rows="4"><?php echo $description_db; ?> </textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
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
