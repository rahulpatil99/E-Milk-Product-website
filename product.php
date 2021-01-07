<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script>
    $(function () {
      $("#header").load("header.html");
    });
    $(document).ready(function () {
      $("button").click(function () {
        // alert(event.target.className);
        // alert(this.id);
        var p_name = $("#product_" + event.target.className).text();
        var p_price = $("#price_" + event.target.className).text().replace('₹', '');
        var p_count = $("#count_" + event.target.className).val();
        $("#count_" + event.target.className).val(1); //reset value
        // alert(p_count);
        $.ajax({
          url: 'root.php',
          type: 'post',
          data: {
            'order': 1,
            'p_name': p_name,
            'p_price': p_price,
            'p_count': p_count,
          },
          success: function (response) {
            if (response == "login error") {
              alert("Please Login first");
            } else {
              $('span').text(response);
              // alert(p_name+" add to cart");
            }

            // if(response == "order add"){alert("added");}
          }
        });
      });
    });
  </script>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      /* background: #3498db; */
      margin: 0 auto 0 auto;
      width: 100%;
      text-align: center;
      margin: 20px 0px 20px 0px;
    }

    .products {
      /* display: flex; */
      display: flex;
      flex-wrap: wrap;
      margin: 0 auto;
      justify-content: space-around;
    }

    .card {
      margin: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
      width: 260px;
      height:400px;
      /* margin: auto; */
      text-align: center;
      font-family: arial;
      padding: 10px;
    }

    .card:hover {
      box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.7);
    }

    .price {
      color: grey;
      font-size: 20px;
    }

    img {
      max-width: 100%;
    }

    .card button {
      border: none;
      outline: 0;
      padding: 12px;
      color: white;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }

    .card button:hover {
      opacity: 0.7;
    }

    .card .details {
      padding: 10px;
    }

    .count {
      text-align: center;
      width: 100px;
      height: 30px;
      border-radius: 20px;
      border: 1px solid black;
    }
    .count:focus{
      outline: none;
      border: 2px solid blue;
    }
  </style>
</head>

<body>
  <div id="header"></div>

  <section class="products">

    <?php
    include("config.php");
    $i=mysqli_query($con,"SELECT * FROM products");
    while($row = mysqli_fetch_assoc($i)){
      ?>

    <div class="card">
      <img height="150" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['img']); ?>" />
      <?php
                echo "<h1 id='product_{$row["product_id"]}'>{$row["p_name"]}</h1>";
                echo "<div id='price_{$row["product_id"]}' class='details'>₹{$row["price"]}</div>";
                echo "<div class='details'>{$row["weight"]}</div>";
                echo "<input type='text' class='count' id='count_{$row["product_id"]}' value='1'>";
                echo "<div class='details'><button class='{$row["product_id"]}'>Add to Cart</button></div>";
                echo "</div>"; 
              }
?>

  </section>
</body>

</html>



<!-- @media (max-width: 920px) {
  .product-card {
    flex: 1 21%;
  }
} -->