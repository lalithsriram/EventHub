<?php 
session_start();
include_once('connect.inc.php');
  if(!isset($_SESSION['id']))
    header("Location: home.php");
  $name = $_SESSION['name'];
  if(isset($_POST["create"]))  
   {  
        $file = "";
        if($_FILES["image"]["tmp_name"]!=''){
           $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"])); 
        } 
        $query = "INSERT INTO halls(user_id,image,name,information,seating,landmark,city,state,pincode) VALUES ('".$_SESSION["id"]."','$file','".$_POST["name"]."','".$_POST["information"]."','".intval($_POST["seating"])."','".$_POST["landmark"]."','".$_POST["city"]."','".$_POST["state"]."','".$_POST['pincode']."')"; 

        if(mysqli_query($conn, $query))  
        {    
             header('location:'.$_SERVER['PHP_SELF']);
             die();
        } 
        else echo '<script>alert("Hall creation failed")</script>';
        
   }
 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Event Hall</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
      
      margin-top: 0px;
      border-right: 5px solid #fff;
      height: 100%;
    }

    .main-left-body{
      margin-top: 50px;
    }
    /*.col-9{
      margin-top: 25px;
      margin-left: 25%;
      
    }*/
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

    #addEvent{
      display: none;
    }
    .card{
      float: left;
      margin-right: 6px;
    }
    a:hover{
      color: #4ED5BB !important;
      cursor: pointer;
    }
  </style>
</head>
<body>
<header>
  <nav><center><h1>Event Halls</h1></center></nav>
  <?php
      $query = "SELECT * FROM halls WHERE user_id = '".$_SESSION['id']."'";
      $result = mysqli_query($conn,$query);
      $count = mysqli_num_rows($result);
      echo '<div class="container-fluid" style="background-color: #e9ecef;">
  <div class="row">
    <div class="col-5">Total events: '.$count.'</div>
    <div class="col-5" > &ensp; &ensp; &ensp; &ensp; &ensp; Hello <span style="text-transform:capitalize;">'.$_SESSION["name"].'</span></div>
    <div class="col-2">
    <button type="button" id="view" class="btn btn-sm">view <i class="fa fa-plus-square"></i></button>
    <button type="button" id="add" class="btn btn-sm">add <i class="fa fa-plus-square"></i></button> &ensp; &ensp; &nbsp; 
    <a id="logout">Logout</a></div>
  
  </div>

  </div>';
  ?>
</header>
<div class="container-fluid" id="main">
  <div class="row">
    <div class="col-12" style="border-right: 5px solid #fff;">
      <?php
      if($count>0){
        echo '<div class="container-fluid" style="margin-top: 25px;">';
        while($row = mysqli_fetch_array($result)){
      echo 
        '<div class="card" style="width: 18rem;">';
        if($row['image']!=''){
          echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode($row['image'] ).'" alt="Card image cap">';
        }
         echo '<div class="card-body">
            <h5 class="card-title">'.$row["name"].'</h5>
            <p class="card-text">'.$row["information"].'</p>
            
          </div>
        </div>';
      }
      echo '</div>';
      }else echo '  <div class="container" id="viewEvents">

    <center><p>No event halls created to view</p></center>

  </div>';

    ?>
  <div id="addEvent" style="margin-top: 25px;" display: block; class="jumbotron jumbotron-fluid">
  <div class="container" >
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
    <div class="row">
    <div class="col">
      <div class="custom-file">
  <input type="file" name="image" class="custom-file-input" id="customFile">
  <label class="custom-file-label" for="customFile">Hall Image</label>
</div>
      
    </div>
    <div class="col">
      <input type="text" name="name" class="form-control" placeholder="Hall name">
    </div>
  </div>
  </div>

  <div class="form-group">
    <label for="exampleFormControlTextarea1"> Hall Information</label>
    <textarea class="form-control" name="information" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Seating capcaity</label>
      <input type="type" class="form-control" name="seating" id="inputEmail4" placeholder="ex: 500">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Landmark</label>
      <input type="type" class="form-control" name="landmark" id="inputEmail4" placeholder="Landmark near the hall">
    </div>
  </div>
    <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputEmail4">city</label>
      <input type="type" class="form-control" name="city" id="inputEmail4" placeholder="city name (important)">
    </div>
    <div class="form-group col-md-4">
      <label for="inputEmail4">state</label>
      <input type="type" class="form-control" name="state" id="inputEmail4" placeholder="State name">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Pincode</label>
      <input type="text" class="form-control" name="pincode" id="inputPassword4" placeholder="area pincode">
    </div>
  </div>
  <button class="btn btn-primary" name="create" type="submit">create Hall</button>
</form>
  </div>

</div>
    </div>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  document.getElementById('view').style.backgroundColor = '#4ed5bb';
$(document).ready(function(){
  $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });
  $("#add").click(function() {
    $("#view").css('background-color','#fff');
    $(this).css('background-color','#4ed5bb');
    $('.card').css('display','none');
    $('#addEvent').css('display','block');
  });
  $("#view").click(function() {
    $("#add").css('background-color','#fff');
    $(this).css('background-color','#4ed5bb');
    $('.card').css('display','block');
    $('#addEvent').css('display','none');
  });
  $("#logout").click(function(){
    $.post("back.php",{logout:true}, function(data, status){
        if(status==0)
          alert('logout failed');
        else location.reload();
    });
  });
});
</script>
</html>