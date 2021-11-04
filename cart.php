<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>
    $(document).ready(function () {
      $("#header").load("header.html");


      $(".delete").click(function () {
        var div_id = "#row_" + this.id; // Use # here
        var parent_div = $(div_id);
        $.ajax({
          url: "root.php",
          type: "post",
          data: {
            delete_cart: 1,
            order_id: this.id
          },
          success: function (response) {
            if (response == "deleted") {
              // parent_div.remove();
              // $("span").text(parseInt($("span").text())-1);
              // // alert(parseInt($("span").text())-1);
              // // $("span").text(100);
              location.reload(true);
            } else {
              alert("not deleted");
            }
          },
        });
      });

      $("#pay").click(function () {
        // alert("ok");
        $.ajax({
          url: "root.php",
          type: "post",
          data: {
            pay: 1,
          },
          success: function (response) {
            if (response == "pay") {
              alert("Thank you Buy from us..");
              location.reload(true);
            } else {
              alert(response);
            }
          },
        });
      });
    });
  </script>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: #3498db;
      margin: 0 auto 0 auto;
      width: 100%;
      text-align: center;
      margin: 20px 0px 20px 0px;
    }

    .carts {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .card {
      margin: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
      background: white !important;
      width: auto;
      height: auto;
      border-radius: 15px;
      border: none;
      font-family: arial;
      padding: 30px;
      padding-top: 50px;
    }

    #bill {
      width: 300px;
      height: 180px;
    }

    td,
    th {
      padding: 10px;
      height: 30px;
      width: 100px;
      text-align: center;
    }

    button {
      border-radius: 25px;
      padding: 5px;
      width: 100px;
      height: 30px;
      background: #ffcccb;
      border: 1px solid #FF0000;
    }

    #pay {
      height: 40px;
      width: 150px;
      background: #FFFFCC;
      border: 1px solid #FFFF00;
    }

    #cart_name {
      float: left;
      margin-top: -30px;
      margin-left: -15px;
    }
  </style>
</head>

<body>
  <div id="header"></div>
  <center>
    <section class="carts">



      <?php
    include("./config/config.php");
    session_start();
    if(isset($_SESSION['username'])){
      $username = $_SESSION['username'];
      $s_query=mysqli_query($con,"select * from users where u_name='$username'");
      $data=mysqli_fetch_array($s_query);
      $uid = (int)$data['user_id'];
      // echo $uid;
      $query = mysqli_query($con,"select * from orders where u_id='$uid' and status='no'");
      $num = mysqli_num_rows($query);
      if($num > 0){
        $total = 0;
        // $sum = 0;
        echo "<div class='card'>";
        echo "<p id='cart_name'>My Cart</p>";
        echo "<table><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
        while($row = mysqli_fetch_assoc($query)){
          $sum = (int)$row['price']*(int)$row['quantity'];
          $total += $sum;
          echo "<tr id='row_{$row['o_id']}'><td>{$row['product_name']}</td>";
          echo "<td>{$row['quantity']}</td>";
          echo "<td>{$row['price']}</td>";
          echo "<td>{$sum}</td>";
          echo "<td><button class='delete' id='{$row['o_id']}'>Delete</button></td></tr>";
          $sum = 0;
        }
        echo "</table></div>";

        echo "<div class='card' id='bill'>";
        echo "<table><tr><td>Total item </td><td>{$num} ";
        ($num>1)? print "items" : print "item";
        echo "</td></tr>";
        echo "<tr><td>Total Amount </td><td>₹{$total}</td></tr>";
        echo "<tr><td colspan=2><center><button id='pay'>Pay Now</button></center></td><tr>";
        echo "</table></div>";
      }
      else{
        echo "<div class='card'>No item in cart</div>";
      }
    }
      // }
    else{
      echo "<script>alert('please login');window.location.href='product.php';</script>";
      // header("location:product.php");
    }
    ?>

    </section>
  </center>
</body>

</html>