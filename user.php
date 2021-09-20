<?php
  session_start();
  require_once('connect.inc.php');
  $register = 0;
  $login = 0;
    if(isset($_POST['register'])){
    $query = "INSERT INTO users(name,password,email,phone,dob) VALUES('".$_POST['username']."','".$_POST['password']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['dob']."')";
    if(mysqli_query($conn, $query))
      $register = 1;
    else $register = 0;
  }
  else if(isset($_POST['login'])){
    $query = "SELECT id,name FROM users WHERE email='".$_POST['email']."' AND password='".$_POST['password']."' ";
    if($result = mysqli_query($conn, $query)){
       $row = mysqli_fetch_array($result);
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        header('Location: hall.php');
    }
    else $login = -1;  
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Event Hall</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <style>
    body{
      background-color: #4ED5BB;
      overflow-x: hidden;
    }
    a,a:hover,a:visited{
      color: #4ED5BB;
      text-decoration: none;
    }
    nav{
      padding: 20px 0px 20px 0px;
      background-color: #fff;
      color: #4ED5BB;
    }
    #nav-bottom{
      padding: 0px 0 1px 0;
      border-top: 0.5px solid white;
      background-color: #fff;
      position: -webkit-sticky;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    #home, #login, #register{
      background-color: #4ed5bb73 !important; 
      padding-top: 10px;
    }
    #login, #register{
      text-align: center;   
    }
    ul li{
      list-style-type: none;
    }
    /*#main-left{
      position: fixed;
    }*/
    header{
      position: relative;
      width: 100%;
      z-index: 100;
    }
    #main-left{
      position: fixed;
      width: 25%;
      margin-top: 0px;
      border-right: 5px solid #fff;
      height: 100%;
    }

    .main-left-body{
      margin-top: 50px;
    }
    .col-9{
      margin-top: 25px;
      margin-left: 25%;
      
    }
    form > center{
      font-weight: 400;
    }
    .login{
      padding: 20px 0 20px 0;
      background-color: #fff;
    }
    .register{
      background-color: #fff;
      padding: 20px 0 20px 0;
      margin-top: -25px;
      margin-bottom: 50px;
    }
  </style>
</head>
<body>
<header>
  <nav><center><h1><a href="home.php">Event Halls</a></h1></center></nav>
</header>
    

<div class="container-fluid" id="main">
  <div class="row">
  <div class="col-3" id="main-left">
  <div class="w-100 login"><center>Login</center></div>
  <div class="main-left-body">
    <form method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary" name="login">Login</button>
</form>

  </div>
</div>
  <div class="col-9">
    <div class="w-100 register">
      <?php
        if($register==1)
          echo '<center style="background-color: #4ED5BB !important;"">Registration done!</center>';
        else echo "<center>Register</center>";
      ?></div>
   <form method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name="password" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" name="email"  id="inputAddress" placeholder="JohnDoe@hotmail.com">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Phone</label>
    <input type="text" name="phone" class="form-control" id="inputAddress2" placeholder="10 digit number">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Date of Birth</label>
      <input type="date" name="dob" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-6">
      <br>
      &ensp; &ensp; &ensp; <button style="margin-top: 8px !important;" type="submit" class="btn btn-primary" name="register">Register</button>
    </div>
  </div>

  
</form> 

  </div>
</div>
  </div>
</body>
</html>