<?php
  include("../config/config.php");

  if (isset($_POST["addProduct"])) {
      $productName = $_POST['productname'];
      $productimg = $_FILES['productimg'];
      $price = $_POST["price"];
      $quantity = $_POST["quantity"];
    
    
      if ($productimg!='') {
          $productimg = date("YmdHis")+rand(1000, 9999);
          $file_t = $_FILES['productimg']['tmp_name'];
          move_uploaded_file($file_t, "../images/".$productimg);
      }
      $query = "INSERT INTO products (p_name,img,price,weight) VALUES ('$productName','$productimg','$price','$quantity')";
      $i=mysqli_query($con, $query);
  }
?>

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
  <title>Document</title>
</head>

<body>
  <form action="#" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td><label for="productname">Product Name</label></td>
        <td><input type="text" name="productname" id="productname"></td>
      </tr>
      <tr>
        <td><label for="productimg">Image</label></td>
        <td><input type="file" name="productimg" id="productimg"></td>
      </tr>
      <tr>
        <td><label for="price">Price</label></td>
        <td><input type="text" name="price" id="price"></td>
      </tr>
      <tr>
        <td><label for="quantity">Quantity</label></td>
        <td><input type="text" name="quantity" id="quantity"></td>
      </tr>
      <tr>
        <td><input type="reset" value="Clear"></td>
        <td><input type="submit" value="Add" name="addProduct"></td>
      </tr>
    </table>
  </form>


  <?php
                $i=mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC");
                if (mysqli_num_rows($i)) {
                    echo "
                  <form action='aevents.php' method='post'>
                    <table class='content-table'>
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
                        echo "
                      <tr>
                      <td>{$count}</td>
                      <td>{$row["p_name"]}</td>
                      <td><img width='75px' src='../images/{$row["img"]}' alt=''></td>
                      <td>{$row["price"]}</td>
                      <td>{$row["weight"]}</td>
                      <td>{$row["active"]}</td>
                      <td></td>
                      <td>
                      <button class='btn btn-danger btn-sm rounded-0' type='submit' value='{$row["product_id"]}' data-toggle='tooltip' data-placement='top' name='delete_event'>
                      <i class='fa fa-trash'></i></button>
                      </td>
                      </tr>";
                    }
                    echo "</tbody></table></form>";
                } else {
                    echo "No data";
                }
              ?>
</body>

</html>