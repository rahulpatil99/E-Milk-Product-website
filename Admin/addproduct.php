<?php
  include("../config/config.php");
  include "../config/session.php";

  if (!isset($_SESSION['admin'])) {
      echo "<script>alert('Please login');</script>";
      header("refresh:0; url=index.php");
  } else {
      if (isset($_POST["addProduct"])) {
          $productName = $_POST['productname'];
          $productimg = $_FILES['productimg']['name'];
          $price = $_POST["price"];
          $quantity = $_POST["quantity"];
    
    
          if ($productimg!='') {
              $ex_temp = explode('.', $_FILES['productimg']['name']);
              $extension = end($ex_temp);
              $productimg = date("YmdHis")+rand(1000, 9999).".".$extension;

              $file_t = $_FILES['productimg']['tmp_name'];
              move_uploaded_file($file_t, "../images/".$productimg);
          }
          if(isset($_POST['update_p_id'])){
            $id = $_POST['update_p_id'];
            $img = $productimg!='' ? ",img='".$productimg."'" : "";
            $query = "UPDATE products set p_name='$productName' ".$img.",price='$price',weight='$quantity' where product_id='$id'";
            
          }
          else{
            $query = "INSERT INTO products (p_name,img,price,weight) VALUES ('$productName','$productimg','$price','$quantity')";
          }

          $i=mysqli_query($con, $query);
      } ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS only -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <title>Admin</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>
  $(function () {
      $("#header").load("header.html");
      $("#footer").load("footer.html");
    });
  </script>
  </head>
<body>
  <div id="header"></div>
  <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newcreate">
      Add new
    </button>
  </div>
  <center>

  <?php
                $i=mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC");
      if (mysqli_num_rows($i)) {
          echo "   <table class='content-table'>
          <center>
                  <thead>
                  <tr>
                  <th>Sr no.</th>
                  <th>Title</th>
                  <th>Image</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Display</th>
                  <th></th>
                  <th></th>
                  </tr></thead><tbody>";
          $count=0;
          while ($row = mysqli_fetch_assoc($i)) {
              $count++;
              $active = $row['active']==1?'checked':'';
              echo "
                    <tr>
                      <td>{$count}</td>
                      <td>{$row['p_name']}</td>
                      <td><img width='75px' src='../images/{$row['img']}' alt=''></td>
                      <td>{$row['price']}</td>
                      <td>{$row['weight']}</td>
                      <td><input type='checkbox' class='toggle' {$active} name='visible' id='{$row['product_id']}'></td>
                      <td>
                      <button class='btn btn-success btn-sm rounded-0' data-toggle='modal' value='{$row['product_id']}' name='edit_event' data-target='#update'>
                      <i class='fa fa-edit'></i>
                      </button>
                      </td>
                      <td>
                      <button class='btn btn-danger btn-sm rounded-0' type='submit'  value='{$row['product_id']}' name='delete_event'>
                      <i class='fa fa-trash'></i></button>
                      </td>
                      </tr>";
          }
          echo "</tbody></center></table>";
      } else {
          echo "No data";
      } ?>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="newcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="addproduct.php" method="post" enctype="multipart/form-data">
      <div class="modal-body">
    <table>
      <tr>
        <td><label for="productname">Product Name</label></td>
        <td><input type="text" class="form-control input_box" name="productname" id="productname"></td>
      </tr>
      <tr>
        <td><label for="productimg">Image</label></td>
        <td><input type="file" class="form-control input_box" name="productimg" id="productimg"></td>
      </tr>
      <tr>
        <td><label for="price">Price</label></td>
        <td><input type="text" class="form-control input_box" name="price" id="price"></td>
      </tr>
      <tr>
        <td><label for="quantity">Quantity</label></td>
        <td><input type="text"  class="form-control input_box" name="quantity" id="quantity"></td>
      </tr>
    </table>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="addProduct">Add</button>
  </div>
</form>
    </div>
  </div>
</div>

<!-- update -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="addproduct.php" method="post" enctype="multipart/form-data">
      <div class="modal-body">
    <table>
      <tr>
        <td><label for="productname">Product Name</label></td>
        <td><input type="text" class="form-control input_box" name="productname" id="update_p_name"></td>
      </tr>
      <tr>
        <td><label for="productimg">Image</label></td>
        <td><input type="file" class="form-control input_box" name="productimg" id="update_p_img"></td>
      </tr>
      <tr>
        <td><label for="price">Price</label></td>
        <td><input type="text" class="form-control input_box" name="price" id="update_p_price"></td>
      </tr>
      <tr>
        <td><label for="quantity">Quantity</label></td>
        <td><input type="text"  class="form-control input_box" name="quantity" id="update_p_weight"></td>
      </tr>
      
    </table>
    <input type="hidden" name="update_p_id" id="update_p_id">
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="addProduct">Save changes</button>
  </div>
</form>
    </div>
  </div>
</div>


<div id="footer"></div>
</body>

<script>
  $(".toggle").change(function() {
    var id = this.id;
    var url_path;
    if ($(this).is(':checked')){ 
      url_path = 'route.php?operation=visible&&p_id=' + id;
    }
    else{
     url_path=  'route.php?operation=invisible&&p_id=' + id;
    }
    
    $.ajax({
      url: url_path,
      type: 'GET',
      success: function(response) {
        if (response != 'success') {
          alert(response);
        }
      }
    });
  });


  $("button[name=delete_event]").click(function() {
    
    var id = this.value;
    $.ajax({
      url: 'route.php?operation=delete&&p_id=' + id,
      type: 'GET',
      success: function(response) {
        if (response == 'success') {
          location.reload();
        } else {
          alert(response);
        }
      }
    });
  });


    $("button[name=edit_event]").click(function() {
      var id = this.value;
    $.ajax({
      url: 'route.php?p_id='+id,
      type: 'GET',
      success: function(response) {
        if (response != 'not success') {
            $("#update_p_name").val(response[0].p_name);
            $("#update_p_price").val(response[0].price);
            $("#update_p_weight").val(response[0].weight);
            $("#update_p_id").val(response[0].product_id);
        }else{
            alert("Update Failed");
          }
      }
    });
  });
</script>

</html>


<?php
  }
  ?>
