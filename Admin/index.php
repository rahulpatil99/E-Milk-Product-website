<?php
  include "../config/config.php";
  include "../config/session.php";

  if(isset($_POST["login"]))
  {
    $username=$_POST["username"];
    $password=$_POST["password"];
    $encpassword=md5($password);
    $i=mysqli_query($con,"SELECT * from admin where admin_name='$username'");
    $data=mysqli_fetch_array($i);
    if($data['admin_pass']==$encpassword)
    {
        $_SESSION['admin']=$username;
        
        header("location:addproduct.php");
    }
    else
            echo"<script>alert('User Name and Password is incorrect');</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/style.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>

  <script>
    $(function () {
      $("#header").load("header.html");
    });
  </script>
  <style>
    body{
      background: #3498db;
      margin: 0 0 0 0;
    }
    .outerbox {
      display: flex;
      align-items: center;
      font-family: 'Open Sans', sans-serif;
      justify-content: center;
      width: 100%;
      text-align: center;
      margin: 20px 0px 20px 0px;
    }

    .box {
      background: white;
      width: 300px;
      height: 300px;
      border-radius: 6px;
      padding: 10px;
      box-shadow: 10px 10px 5px #2980b9;
    }

    .btn {
      background: #2ecc71;
      width: 125px;
      padding-top: 5px;
      padding-bottom: 5px;
      color: white;
      border-radius: 4px;
      border: #27ae60 1px solid;
      text-align: center;
      margin: 0 auto;
      margin-top: 20px;
      margin-bottom: 20px;
      /* float: left; */
      margin-left: 16px;
      font-weight: 800;
      font-size: 0.8em;
    }

    input {
      padding: 10px;
      width: 250px;
      margin: 10px 0;
      text-align: center;
    }
  </style>
</head>

<body>
  <div id="header"></div>
  <div class="outerbox">
  <form method="post" action="#">
    <div class="box">
      <h1>Admin Login</h1>

      <input type="text" name="username" placeholder="UserName" />

      <input type="password" name="password" placeholder="password" />

      <input type="submit" name="login" value="Login" class="btn">


    </div> <!-- End Box -->

  </form>
  </div>
</body>

</html>