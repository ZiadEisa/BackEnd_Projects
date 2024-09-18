<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'] )) {
  header('Location: Login.php'); // Redirect to login page if not logged in
  exit();
}

if(!$_SESSION['is_admin']){
  header('Location: index.php'); // Redirect to index page if not logged in
  exit();
}
$link = "http://localhost/RentalCar/PHP/";
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../Images/icon.jpeg" type="image/x-icon">
  <link rel="stylesheet" href="../CSS/navBar.css">
  <link rel="stylesheet" href="../CSS/addCar.css"> <!-- Link to your CSS file -->
  
  <title>Car Rental | Add Car</title>
</head>
<body>
  

      <!-- Navigation Bar -->
      <div class="nav-bar">
            <div class="logo">Car Rental</div>
            <ul class="nav-list">
            <li><a href="index.php">Cars</a></li>
            <li><a href="about.php">About Us</a></li>
            <?php if(isset($_SESSION['username'])){ ?>
                <li><a href="profile.php"><?php echo $_SESSION['username']?></a></li>
                <?php if(isset($_SESSION['is_admin'])&&$_SESSION['is_admin'] ){?>
                <li><a href="AddCars.php">Add Car</a></li>
                <?php } ?>
                <li><button id="loggout_btn">Logout</button></li>
            <?php } else { ?>
                <li><a href="Login.php">Log in</a></li>
            <?php } ?>
            </ul>
        </div>

  <div class="add-car">
    <form method="post" class="add-car-form" id="add-car-form" enctype="multipart/form-data">
      <div class="title">Add a Car</div>
      <!-- Car Brand input -->
      <label for="carType" class="carType">Car brand name</label>
      <input type="text" class="carType" id="carType" name="carType" required placeholder="brand name like Mercedes-Benz ... ">

      <!-- Car Name input -->
      <label for="car-name" class="car-name">Car name</label>
      <input type="text" class="car-name" id="car-name" name="car-name"required placeholder="for Mercedes : C-Class, CLA, GLA, GLC ">

      <!-- Car Speed input -->
      <label for="car-speed" class="car-speed">Car speed</label>
      <input type="text" class="car-speed" id="car-speed" name="car-speed"required placeholder="456 km/h or 545 m/s">

      <!-- Car Rent Price input -->
      <label for="car-rent-price" class="car-rent-price">Rent Price per day</label>
      <input type="text" class="car-rent-price" id="car-rent-price" name="car-rent-price"required>

      <!-- Car Image input -->
      <label for="car-image" class="custom-file-upload">Car Image</label>
      <input type="file" class="custom-file-input" id="car-image" name="car-image" accept="image/jpeg, image/png, image/jpg,image/webp" required>

      <!-- Car detailed images input -->
      <label for="car-detailed-images" class="custom-file-upload">Inner car images</label>
      <input type="file" id="car-detailed-images" name="car-detailed-images[]" multiple accept="image/jpeg, image/png, image/jpg ,image/webp" class="custom-file-input"required>
      
      
      <input type="hidden" name="username" value="<?php echo (isset($_SESSION['username'])? $_SESSION['username'] : '__Mohammed'); ?>">
      <div id="choosen-files"></div>
      
      <script>
        

      </script>
      <!-- Optional submit button -->
      <input type="submit" value="Add Car">
    </form>
  </div>
  
  <div id="error_message"></div>
  <div id="success_message"></div>

  <script src="../JS/addCar.js"></script>
  <script src="../JS/loggOut.js"></script>
  <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous">
  </script>
  </body>
</html>
