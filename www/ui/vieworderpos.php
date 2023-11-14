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


ob_end_flush();

if (isset($_GET['id'])) {
  $invoice_id = $_GET['id'];

  $invoice_query = $pdo->prepare("SELECT * FROM Invoice WHERE invoice_id = :invoice_id");
  $invoice_query->bindParam(':invoice_id', $invoice_id);
  $invoice_query->execute();

  $invoice_details = $invoice_query->fetch(PDO::FETCH_ASSOC);

  $invoice_items_query = $pdo->prepare("
    SELECT *
    FROM Invoice_Details
    LEFT JOIN Product_Stock
        ON Invoice_Details.stock_id = Product_Stock.id
    LEFT JOIN Product
        ON Product_Stock.pid = Product.pid
    WHERE Invoice_Details.invoice_id = :invoice_id
");
  $invoice_items_query->bindParam(':invoice_id', $invoice_id);
  $invoice_items_query->execute();

  $invoice_items = $invoice_items_query->fetchAll(PDO::FETCH_ASSOC);

//  echo $invoice_details;
//  echo $invoice_items;

}


?>


<style type="text/css">

  .tableFixHead {
    overflow: scroll;
    height: 520px;
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
              <h5 class="m-0" style="font-weight: bold">View Order</h5>
            </div>


            <div class="card-body">

              <div class="row">


                <div class="col-md-8">


                  </br>
                  <div class="tableFixHead">


                    <table id="producttable" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>price</th>
                        <th>QTY</th>
                        <th>Total</th>
                      </tr>

                      </thead>


                      <tbody class="details" id="itemtable">
                      <tr data-widget="expandable-table" aria-expanded="false">

                      </tr>
                      </tbody>
                    </table>


                  </div>


                </div>


                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">SUBTOTAL(Rs) </span>
                    </div>
                    <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Rs</span>
                    </div>
                  </div>


                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">DISCOUNT(%)</span>
                    </div>
                    <input value="0.0" type="number" class="form-control" name="txtdiscount_p" id="txtdiscount_p"
                           readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">%</span>
                    </div>
                  </div>


                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">DISCOUNT(Rs)</span>
                    </div>
                    <input type="text" class="form-control" id="txtdiscount" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Rs</span>
                    </div>
                  </div>


                  <div class="input-group mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text">TOTAL(Rs)</span>
                    </div>
                    <input type="text" class="form-control form-control total" name="txttotal" id="txttotal"
                           readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Rs</span>
                    </div>
                  </div>

                  <hr style="height:2px; border-width:0; color:black; background-color:black;">

                  <div class="icheck-success d-inline">
                    <input type="radio" name="rb" value="Cash" checked id="cashRadioButton" disabled>
                    <label for="cashRadioButton">
                      CASH
                    </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" name="rb" value="Card" id="cardRadioButton" disabled>
                    <label for="cardRadioButton">
                      CARD
                    </label>
                  </div>
                  <div class="icheck-danger d-inline">
                    <input type="radio" name="rb" value="Check" id="checkRadioButton" disabled>
                    <label for="checkRadioButton">
                      CHECK
                    </label>
                  </div>
                  <hr style="height:2px; border-width:0; color:black; background-color:black;">


                  <div class="input-group mb-3 mt-1">
                    <div class="input-group-prepend">
                      <span class="input-group-text">DUE(Rs)</span>
                    </div>
                    <input type="text" class="form-control" name="txtdue" id="txtdue" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Rs</span>
                    </div>
                  </div>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">PAID(Rs)</span>
                    </div>
                    <input type="number" class="form-control" name="txtpaid" id="txtpaid" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Rs</span>
                    </div>
                  </div>
                  <hr style="height:2px; border-width:0; color:black; background-color:black;">


                </div>

              </div>

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

<script>
  let productCount = 0;

  //Initialize Select2 Elements
  $('.select2').select2();

  //Initialize Select2 Elements with Bootstrap 4 theme
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });


  function addrow(pid, product, stock, saleprice, qty, barcode, stock_id) {
    let tr =
      '<tr>' +
      '<input type="hidden" class="form-control barcode" name="barcode_arr[]" id="barcode_id' + stock_id + '" value="' + barcode + '" >' +
      '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-dark">' + product + '</span><input type="hidden" class="form-control pid" name="pid_arr[]" value="' + pid + '" ><input type="hidden" class="form-control product" name="product_arr[]" value="' + product + '" >  </td>' +
      '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary stocklbl" name="stock_arr[]" id="stock_id' + stock_id + '">' + stock + '</span><input type="hidden" class="form-control stock_id" name="stock_id_arr[]" id="stock_id' + stock_id + '" value="' + stock_id + '"><input type="hidden" class="form-control stock_qty" name="stock_qty_arr[]" id="stock_qty' + stock_id + '" value="' + stock + '"></td>' +
      '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning price" name="price_arr[]" id="price_id' + stock_id + '">' + saleprice + '</span></td>' +
      '<td><input disabled style="width: 80px" type="number" class="form-control qty" name="quantity_arr[]" id="qty_id' + stock_id + '" value="' + qty + '" size="1" min="1"></td>' +
      '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-success totalamt" name="netamt_arr[]" id="total_raw_price_id' + stock_id + '">' + saleprice*qty + '</span><input type="hidden" class="form-control saleprice" name="saleprice_arr[]" id="saleprice_idd' + stock_id + '" value="' + saleprice*qty + '"></td>' +
      '</tr>';

    $('.details').append(tr);
  }

  <?php if (isset($invoice_items) && !empty($invoice_items) && isset($invoice_details) && !empty($invoice_details)): ?>
  let invoiceItems = <?php echo json_encode($invoice_items); ?>;
  let invoiceDetails = <?php echo json_encode($invoice_details); ?>;

  console.log(invoiceDetails);
  console.log(invoiceItems);

  for (let item of invoiceItems) {
    console.log(item.qty);
    addrow(item.pid, item.product, item.stock, item.saleprice, item.qty, item.barcode, item.stock_id);
  }
  <?php endif; ?>

  document.getElementById('txtsubtotal').value = invoiceDetails['subtotal']
  document.getElementById('txtdiscount_p').value = (invoiceDetails['discount'] * 100 / invoiceDetails['subtotal']).toFixed(2);
  document.getElementById('txtdiscount').value = invoiceDetails['discount'];
  document.getElementById('txttotal').value = invoiceDetails['total'];
  document.getElementById('txtdue').value = invoiceDetails['due'];
  document.getElementById('txtpaid').value = invoiceDetails['paid'];

  let paymentMethod = invoiceDetails['payment_type'];
  if (paymentMethod === "Cash") {
    document.getElementById('cashRadioButton').checked = true;
  } else if (paymentMethod === "Card") {
    document.getElementById('cardRadioButton').checked = true;
  } else if (paymentMethod === "Check") {
    document.getElementById('checkRadioButton').checked = true;
  }
</script>




