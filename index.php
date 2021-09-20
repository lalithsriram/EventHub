<?php
require_once('connect.inc.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Event Hall</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- suggestions css -->
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
  <style>
    body{
      background-color: #4ED5BB;
      overflow-x: hidden;
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
      margin-top: -95px;
      border-right: 5px solid #fff;
      height: 100%;
    }
    .hidden-logo{
      padding: 25px 0px 13px 0;
       background-color: #fff;
       color: #4ED5BB;
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
    a,a:hover,a:visited{
      color: black;
      text-decoration: none;
    }
  </style>
</head>
<body>
<header>
  <nav><center><h1>Event Halls</h1></center></nav>
</header>
  <div class="container-fluid" id="nav-bottom">
  <div class="row" >
    <div class="col-8" id="home">
      <ul><li>Home</li></ul>
    </div>
    
    <div class="col-4" id="register">
      <a href="user.php">Login\Register</a>
    </div>
  </div>
</div>

<div class="container-fluid" id="main">
  <div class="row">
  <div class="col-3" id="main-left">
      <div class="hidden-logo">
    <center><h1>Event Halls</h1></center>
    </div>
  <div class="main-left-body">

  <form class="form-inline" method="post">
    <center><p>Find Halls by Name</p></center>
  <div class="form-group mx-sm-2 mb-2">
    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Hall name"> &nbsp;
    <button style="margin-top: 10px;" name="namesearch" type="submit" class="btn btn-primary mb-2">Find Halls</button>
  </div>
</form><br>
    <form class="form-inline" method="post">
      <center><p>Search Halls by City</center>
  <div class="form-group mx-sm-2 mb-2">
    <label for="inputPassword2" class="sr-only">Password</label>
    <input type="text" name="city" class="form-control" id="city" placeholder="Search by city name"> &nbsp;
    <button style="margin-top: 10px;" name="citysearch" type="submit" class="btn btn-primary mb-2">Find Halls</button>
  </div>
</form>
  </div>
  
    <?php
    echo '<div class="container" style="background-color: #fff">
  <div class="row">
    <div class="col-sm">';
    if(isset($_POST['namesearch'])){
      $query = "SELECT * FROM halls WHERE name = '".$_POST["name"]."' ";
      echo '<center><p>Filtered by Name: '.$_POST["name"].'</p></center><center><a href="?show=all" style="text-decoration: underline; color: #4ED5BB;" >Show all</a></center>';
    }
    else if(isset($_POST['citysearch'])){
      $query = "SELECT * FROM halls WHERE city = '".$_POST["city"]."' ";
      echo '<center><p>Filtered by City: '.$_POST["city"].'</p></center><center><a href="?show=all" style="text-decoration: underline; color: #4ED5BB;" >Show all</a></center>';
    }else {
      $query = "SELECT * FROM halls";
    echo 'Filter: None';}
    echo '</div>
  </div>
</div>
</div>
  <div class="col-9">';
      $result = mysqli_query($conn,$query);
      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
          $query = "SELECT phone,email from users WHERE id='".$row["user_id"]."' ";
          $response = mysqli_query($conn,$query);
          $user = mysqli_fetch_array($response);
        echo '<div class="card mb-3">';
        if($row['image'])
  echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode($row['image'] ).'" alt="Card image cap">';
  echo '<div class="card-body">
    <h5 class="card-title">'.$row["name"].'</h5>
    <p class="card-text">'.$row["information"].'</p>
    <p class="card-text"><small class="text-muted">Seating Capacity: </small>'.$row["seating"].' &ensp; <small class="text-muted">Address: </small>'.$row["city"].', '.$row["state"].'-'.$row["pincode"].' &ensp;  &ensp;  &ensp; <small class="text-muted">Contact-info: </small>'.$user["phone"].' &ensp; '.$user["email"].'</p>
  </div>
</div>';
      }
  }
    ?>


  </div>
</div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Associate suggestions using jquery -->
<script src="jquery.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">
  $(function(){
    $("#city").autocomplete({
        source: "suggestions.php"
    });
    $("#name").autocomplete({
        source: "suggestionsname.php"
    });
  });
</script>
</body>
</html>