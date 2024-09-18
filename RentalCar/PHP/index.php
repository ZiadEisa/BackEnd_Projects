<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental</title>
  <link rel="stylesheet" href="../CSS/index.css">
  <link rel="stylesheet" href="../CSS/navBar.css">
  <link rel="shortcut icon" href="../Images/icon.jpeg" type="image/x-icon">
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

  <main>
    <?php 
      include('db_connection.php');

      // Get all car types
      $get_car_types_query = "SELECT DISTINCT car_type FROM car";
      $car_types_res = mysqli_query($connection, $get_car_types_query);

      // Loop through each car type
      while($type_row = mysqli_fetch_assoc($car_types_res)) {
        $car_type = $type_row['car_type'];

        echo "<h2 class='car-type-header'>$car_type</h2>"; // Car type header

        // Get all cars for the car type
        $get_cars_query = "SELECT * FROM car WHERE car_type='$car_type'";
        $get_cars = mysqli_query($connection, $get_cars_query);

        echo "<div class='car-category'>";
        while($car_row = mysqli_fetch_assoc($get_cars)){
          $car_id = $car_row['car_id'];
          $car_name = $car_row['car_name'];
          $car_image = $car_row['car_image'];

          // Display each car under the category
          echo "<div class='car-item'>";
          echo "<img src='$car_image' alt='$car_name' class='car-image'>";
          echo "<button class='details-button' onclick=\"window.location.href='car_details.php?car_id=$car_id'\">Show Details</button>";
          echo "</div>";
        }
        echo "</div>";
      }
    ?>
  </main>
  <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous">
  </script>
  <script src="../JS/loggOut.js"></script>
  </body>
</html>
