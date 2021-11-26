<?php
  include "../config/config.php";
  include "../config/session.php";

  if(!isset($_SESSION['admin'])){
    header("url=index.php");
  }
  else{
    $product_id = $_GET['p_id'];
    if (isset($_GET['operation'])) {
      if ($_GET['operation']=='delete') {
          $query = mysqli_query($con, "DELETE FROM products WHERE product_id='$product_id'");
          if ($query) {
              echo "success";
          } else {
              echo "Not deleted";
          }
          die();
      } elseif ($_GET['operation']=='visible') {
          $query = mysqli_query($con, "UPDATE  products set active=1 WHERE product_id='$product_id'");
          if ($query) {
              echo "success";
          } else {
              echo "Not deleted";
          }
          die();
      } elseif ($_GET['operation']=='invisible') {
          $query = mysqli_query($con, "UPDATE  products set active=0 WHERE product_id='$product_id'");
          if ($query) {
              echo "success";
          } else {
              echo "Not deleted";
          }
          die();
      }
    }
    else if (isset($_POST['logout'])) {
        unset($_SESSION['admin']);
        header("url=index.html");
    }
    else{
      $query = mysqli_query($con,"SELECT * FROM products where product_id='$product_id'");
      $rows = array();
      while($r = mysqli_fetch_assoc($query)) {
          $rows[] = $r;
      }
      if($query){

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($rows);
      }
      else{
        echo "not success";
      }
    }
  }
  ?>
