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

if (isset($_POST['btnsave'])) {

  $category = $_POST['txtcategory'];

  if (empty($category)) {

    $_SESSION['status'] = "Category Field is Empty";
    $_SESSION['status_code'] = "warning";


  } else {

    try {
      $pdo->beginTransaction();

      $check = $pdo->prepare("SELECT COUNT(*) FROM Category WHERE category = :cat");
      $check->bindParam(':cat', $category);
      $check->execute();

      $exists = $check->fetchColumn();

      if ($exists == 0) {
        $insert = $pdo->prepare("INSERT INTO Category (category) VALUES (:cat)");
        $insert->bindParam(':cat', $category);

        if ($insert->execute()) {
          $_SESSION['status'] = "Category Added successfully";
          $_SESSION['status_code'] = "success";
        } else {
          $_SESSION['status'] = "Category Addition Failed";
          $_SESSION['status_code'] = "warning";
        }
      } else {
        $_SESSION['status'] = "Category already exists";
        $_SESSION['status_code'] = "info";
      }

      $pdo->commit();
    } catch (Exception $e) {
      $pdo->rollBack();
      $_SESSION['status'] = "An error occurred: " . $e->getMessage();
      $_SESSION['status_code'] = "error";
    }

  }

  echo '<script type="text/javascript">window.location.href="category.php";</script>';
  exit;
}


if (isset($_POST['btnupdate'])) {

  $category = $_POST['txtcategory'];
  $id = $_POST['txtcatid'];

  if (empty($category)) {

    $_SESSION['status'] = "Category Feild is Empty";
    $_SESSION['status_code'] = "warning";


  } else {

    try {
      $pdo->beginTransaction();

      // Check if the category already exists but exclude the current row by its id
      $check = $pdo->prepare("SELECT COUNT(*) FROM Category WHERE category = :cat AND catid != :id");
      $check->bindParam(':cat', $category);
      $check->bindParam(':id', $id, PDO::PARAM_INT);
      $check->execute();

      $exists = $check->fetchColumn();

      if ($exists == 0) {
        $update = $pdo->prepare("UPDATE Category SET category=:cat WHERE catid=:id");
        $update->bindParam(':cat', $category);
        $update->bindParam(':id', $id, PDO::PARAM_INT);

        if ($update->execute()) {
          $_SESSION['status'] = "Category Updated successfully";
          $_SESSION['status_code'] = "success";
        } else {
          $_SESSION['status'] = "Category Update Failed";
          $_SESSION['status_code'] = "warning";
        }
      } else {
        $_SESSION['status'] = "Category already exists";
        $_SESSION['status_code'] = "info";
      }

      $pdo->commit();
    } catch (Exception $e) {
      $pdo->rollBack();
      $_SESSION['status'] = "An error occurred: " . $e->getMessage();
      $_SESSION['status_code'] = "error";
    }

  }

  // Redirect after operation
  echo '<script type="text/javascript">window.location.href="category.php";</script>';
  exit;
}


# Deleting a category
if (isset($_POST['btndelete'])) {
  $catid = $_POST['btndelete'];

  // Check if there are products associated with this category
  $check = $pdo->prepare("SELECT COUNT(*) FROM Product WHERE catid = :catid");
  $check->bindParam(':catid', $catid, PDO::PARAM_INT);
  $check->execute();
  $productCount = $check->fetchColumn();

  if ($productCount > 0) {
    // There are products associated with this category, do not delete
    $_SESSION['status'] = "Deletion Failed: There are products associated with this category";
    $_SESSION['status_code'] = "warning";
  } else {
    // No products are associated with this category, proceed to delete
    $delete = $pdo->prepare("DELETE FROM Category WHERE catid = :catid");
    $delete->bindParam(':catid', $catid, PDO::PARAM_INT);

    if ($delete->execute()) {
      $_SESSION['status'] = "Deleted";
      $_SESSION['status_code'] = "success";
    } else {
      $_SESSION['status'] = "Delete Failed";
      $_SESSION['status_code'] = "warning";
    }
  }

  // Redirect after operation
  echo '<script type="text/javascript">window.location.href="category.php";</script>';
  exit;
}


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Category</h1>
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

      <div class="card card-warning card-outline">
        <div class="card-header">
          <h5 class="m-0">Category Form</h5>
        </div>


        <form action="" method="post">
          <div class="card-body">


            <div class="row">


              <?php

              if (isset($_POST['btnedit'])) {

                $select = $pdo->prepare("select * from Category where catid =" . $_POST['btnedit']);

                $select->execute();

                if ($select) {
                  $row = $select->fetch(PDO::FETCH_OBJ);

                  echo '<div class="col-md-4">



<div class="form-group">
  <label for="exampleInputEmail1">Category</label>

  <input type="hidden" class="form-control" placeholder="Enter Category"  value="' . $row->catid . '" name="txtcatid" >

  <input type="text" class="form-control" placeholder="Enter Category"  value="' . $row->category . '" name="txtcategory" id="txtcategory_id" autofocus>
</div>


<div class="card-footer">
<button type="submit" class="btn btn-info" name="btnupdate">Update</button>
</div>



</div>';


                }


              } else {

                echo '<div class="col-md-4">



<div class="form-group">
  <label for="exampleInputEmail1">Category</label>
  <input type="text" class="form-control" placeholder="Enter Category"  name="txtcategory" id="txtcategory_id" autofocus>
</div>


<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>



</div>';


              }


              ?>


              <div class="col-md-8">

                <table id="table_category" class="table table-striped table-hover ">
                  <thead>
                  <tr>
                    <td>#</td>
                    <td>Category</td>
                    <td>Edit</td>
                    <td>Delete</td>

                  </tr>

                  </thead>


                  <tbody>

                  <?php

                  $select = $pdo->prepare("select * from Category order by catid ASC");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
<tr>
<td>' . $row->catid . '</td>
<td>' . $row->category . '</td>

<td>

<button type="submit" class="btn btn-primary" value="' . $row->catid . '" name="btnedit">Edit</button>

</td>

<td>

<button type="submit" class="btn btn-danger" value="' . $row->catid . '" name="btndelete">Delete</button>

</td>

</tr>';

                  }

                  ?>

                  </tbody>


                  <tfoot>
                  <tr>
                    <td>#</td>
                    <td>Category</td>
                    <td>Edit</td>
                    <td>Delete</td>

                  </tr>


                  </tfoot>


                </table>


              </div>


            </div>


          </div>
        </form>
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

  $(document).ready(function () {
    $('#table_category').DataTable();
  });


</script>
