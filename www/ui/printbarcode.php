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


          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0"><b>Generate Barcode Stickers</b></h5>
            </div>
            <div class="card-body">

              <form class="form-horizontal" method="post" action="barcode/barcode.php" target="_blank">


                <?php
                $stock_id = $_GET['stock_id'];
                $select = $pdo->prepare("
                  SELECT
                      Product.pid, Product.barcode, Product.product, Product.description,
                      Product_Stock.stock, Product_Stock.purchaseprice, Product_Stock.saleprice
                  FROM Product
                  INNER JOIN Product_Stock ON Product.pid = Product_Stock.pid
                  WHERE Product_Stock.id = :stock_id
              ");

                $select->bindParam(':stock_id', $stock_id);
                $select->execute();


                while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                  echo '
<div class="row">
  <div class="col-md-12">
    <ul class="list-group col-md-7">
      <center><p class="list-group-item list-group-item-info"><b>PRODUCT DETAILS</b></p></center>

      <div class="form-group pb-2">

        <label class="control-label" for="product">Product:</label>
        <div class="col-sm-12">
          <input autocomplete="OFF" type="text" class="form-control" value="' . $row->product . '" id="product"
                 name="product" readonly>
        </div>
      </div>
      <div class="form-group pb-2">
        <label class="control-label" for="product_id">Barcode:</label>
        <div class="col-sm-12">
          <input autocomplete="OFF" type="text" class="form-control" value="' . $row->barcode . '" id="barcode"
                 name="barcode" readonly>
        </div>
      </div>
      <div class="form-group  pb-2">
        <label class="control-label" for="rate">Price</label>
        <div class="col-sm-12">
          <input autocomplete="OFF" type="text" class="form-control" value="' . $row->saleprice . '" id="rate"
                 name="rate" readonly>
        </div>
      </div>

      <div class="form-group  pb-2">
        <label class="control-label" for="rate">Stock QTY</label>
        <div class="col-sm-12">
          <input autocomplete="OFF" type="text" class="form-control" value="' . $row->stock . '" id="stock" name="stock"
                 readonly>
        </div>
      </div>


      <div class="form-group pb-2">
        <label class="control-label" for="print_qty">Barcode Quantity</label>
        <div class="col-sm-12">
          <input autocomplete="OFF" type="print_qty" class="form-control" id="print_qty" name="print_qty">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Generate Barcode</button>
        </div>
      </div>

    </ul>
  </div>


</div>
';
                }
                ?>
              </form>
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
