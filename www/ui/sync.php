<?php

session_start();


if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {

  header('location:../index.php');

}


if ($_SESSION['role'] == "Admin") {
  include_once "header.php";
} else {
  include_once "headeruser.php";
}

if (isset($_POST['exportDbBtn'])) {
  echo "Executing";
  // The path to the batch file
  $backupScript = 'C:\\xampp\\htdocs\\sala\\db_export.bat';

// Run the batch file
  exec($backupScript, $output, $returnVar);

  echo "<pre>";
  print_r($output);
  echo "</pre>";

// Check if the backup was successful
  if ($returnVar === 0) {
    echo "Database backup successful.";
  } else {
    echo "Database backup failed.";
  }

//  echo '<script type="text/javascript">window.location.href="sync.php";</script>';

}

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Sync Database</h1>
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


      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Sync Database</h5>
        </div>
        <div class="card-body">

          <div class="row">

            <form action="" method="post" enctype="multipart/form-data">
              <button type="submit" id="exportDbBtn" class="btn btn-primary" name="exportDbBtn">
                <span id="buttonText">Sync</span>
                <i id="loadingIcon" class="fa fa-spinner fa-spin" style="display: none;"></i>
              </button>

            </form>
          </div>


        </div>
      </div>


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
  <script
    Swal.fire({
    icon: '<?php echo $_SESSION['status_code']; ?>',
  title: '<?php echo $_SESSION['status']; ?>'
  });
  </script>
  <?php
  unset($_SESSION['status']);
}
?>

