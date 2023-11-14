<?php
include_once '../API/connectdb.php';
session_start();

$response = [];

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $delete = $pdo->prepare("DELETE FROM User WHERE userid = :id");
  $delete->bindParam(':id', $id, PDO::PARAM_INT);

  if ($delete->execute()) {
    $response['status'] = 'success';
    $response['message'] = "Account deleted successfully";
  } else {
    $response['status'] = 'error';
    $response['message'] = "Account Is Not Deleted";
  }
} else {
  $response['status'] = 'error';
  $response['message'] = "Invalid request";
}
echo json_encode($response);
