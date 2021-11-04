<?php
  include("./config/config.php");

if($con){
    session_start();


  // * Check the login fields
  if(isset($_POST["login"]))
  {
    $username=$_POST["username"];
    $password=$_POST["password"];
    $encpassword=md5($password);
    $i=mysqli_query($con,"SELECT * from users where u_name='$username'");
    $data=mysqli_fetch_array($i);
    if($data['u_pass']==$encpassword)
    {
        // user email id is use for session
        $_SESSION['username']=$username;
        header("location:product.php");
    }
    else
            echo"<script>alert('User Name and Password is incorrect');</script>";
  }


  // * signup and data is added to database
  if(isset($_POST['signup'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $name = $_POST['fname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $encpassword=md5($pass);
    
    $query = "INSERT INTO users(f_name,l_name,gender,address,u_name,u_pass) VALUES('$fname','$lname','$gender','$address','$email','$encpassword')";
    if(mysqli_query($con,$query)){
      header("location:login.html");
    }
  }

  // * add product to my cart
  if(isset($_POST['order'])){
    if(!(isset($_SESSION['username'])))
    {
      echo "login error";
    }
    else{
      $pname= $_POST['p_name'];
      $pprice= (int)$_POST['p_price'];
      $pcount= (int)$_POST['p_count'];
      $uname = $_SESSION['username'];             
      // echo "add";
      $user_query=mysqli_query($con,"SELECT * from users where u_name='$uname'");
      $data=mysqli_fetch_array($user_query);
      $uid = (int)$data['user_id'];
      if($uid!=0){
      $date = date("Y-m-d");
      $i_query = "INSERT INTO orders(u_id,product_name,quantity,price,date) VALUES ('$uid','$pname','$pcount','$pprice','$date')";
      mysqli_query($con,$i_query);
      // echo "add";
      $s_query=mysqli_query($con,"SELECT * from orders where u_id='$uid' and status='no'");
      echo mysqli_num_rows($s_query);
      }
      else{
        echo 0;
      }
      // echo ""
    }
  }

  // * it return the no of products are in my cart
  if(isset($_POST['cart_no'])){
    if(isset($_SESSION['username'])){
      $uname = $_SESSION['username'];   
      $s_query=mysqli_query($con,"SELECT * from users where u_name='$uname'");
      $data=mysqli_fetch_array($s_query);
      $uid = (int)$data['user_id'];
      $name = $data['f_name']." ".$data['l_name'];
      $s_query=mysqli_query($con,"SELECT * from orders where u_id='$uid' and status='no'");
      echo mysqli_num_rows($s_query)." ".$name;
    }
    else{
      echo "0 none ";
    }
  }

  if(isset($_POST['delete_cart'])){
    $order_id = $_POST['order_id'];
    $d_query=mysqli_query($con,"DELETE from orders where o_id='$order_id'");
    if($d_query){
      echo "deleted";
    }
  }

  if(isset($_POST['pay'])){
    $uname = $_SESSION['username'];
    $s_query=mysqli_query($con,"SELECT * from users where u_name='$uname'");
    $data=mysqli_fetch_array($s_query);
    $uid = (int)$data['user_id'];  
    $result = mysqli_query($con,"SELECT * FROM orders where u_id='$uid' and status='no'");
    if(mysqli_num_rows($result)){
      $date = date("Y-m-d");
      $d_query=mysqli_query($con,"UPDATE orders SET status='yes' and date='$date' where u_id='$uid' and status='no'");
      if($d_query){
        echo "pay";
      }
      else{
        echo "error in payment";
      }
    }
    else{
      echo "No item in Cart";
    }
  }

  if(isset($_POST['logout'])){
    unset($_SESSION['username']);
    echo "logout successfuly";
  }
}

?>