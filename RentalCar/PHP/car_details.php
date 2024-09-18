<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['car_id'])) {
        $car_id = $_GET['car_id'];


        $sql = "UPDATE car SET rented_to = NULL , rented_from = NULL ,is_rented = 0 , rented_by = NULL WHERE rented_to < CURDATE()";
        $done = mysqli_query($connection , $sql);
        // Query to get car data based on car_id
        $get_car_data_query = "SELECT * FROM car WHERE car_id='$car_id'";
        $car_data = mysqli_query($connection, $get_car_data_query);

        if ($car_data && mysqli_num_rows($car_data) > 0) {
            $row = mysqli_fetch_assoc($car_data);

            $car_name = $row['car_name'];
            $car_type = $row['car_type'];
            $car_speed = $row['car_speed'];
            $car_rent_price = $row['car_rent_rate'];
            $car_image = $row['car_image'];
            $is_rented = $row['is_rented'];
            $rented_from = $row['rented_from'];
            $rented_to = $row['rented_to'];

            // Query to get inner images for the car
            $car_inner_images_query = "SELECT car_inner_image FROM car_inner_images WHERE car_id='$car_id'";
            $car_inner_images = mysqli_query($connection, $car_inner_images_query);
        } else {
            echo "No car found for this ID.";
            return;
        }
    } else {
        echo "No car ID provided.";
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Details</title>
  <link rel="shortcut icon" href="../Images/icon.jpeg" type="image/x-icon">
  <link rel="stylesheet" href="../CSS/car_details.css">
  <link rel="stylesheet" href="../CSS/navBar.css">
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



<!-- Show Cars -->
<div class="container">
  <div class="car-details">
    <div class="car-header">
      <h1><?php echo htmlspecialchars($car_name); ?></h1>
      <h2>Type: <?php echo htmlspecialchars($car_type); ?></h2>
    </div>

    <div class="car-image">
      <img src="<?php echo htmlspecialchars($car_image); ?>" alt="Car Image">
    </div>

    <div class="car-info">
      <div>
        <p>Speed: <?php echo htmlspecialchars($car_speed); ?></p>
        <p>Rent Price: <?php echo htmlspecialchars($car_rent_price); ?>$ per day</p>
      </div>
      <div class="availability">
        <!-- Check if the car is rented or available -->
        <?php if ($is_rented): ?>
          <p><strong>Rented</strong> from <?php echo htmlspecialchars($rented_from); ?> to <?php echo htmlspecialchars($rented_to); ?></p>
          <a href="#" class="button waiting-list">Add to Waiting List</a>
        <?php else: ?>
          <p><strong>Available for Rent</strong></p>

          <!-- Hidden elements -->
          <input type="hidden" name="username" data-username="<?php echo htmlspecialchars((isset($_SESSION['username']) ? $_SESSION['username'] : null)); ?>">
          <input type="hidden" name="car-id" id="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
          
          <!-- Messages -->
          <div id="error_message" class="message"></div>
          <div id="success_message" class="message"></div>

          <button class="button" id="rent_button">Rent Car</button>

          <!-- Date Form for renting-->
          <form method="get" id="rent-form" style="display:none;">
            <label for="rent-from">From:</label>
            <input type="date" id="rent-from" name="rent-from" required>
            <label for="rent-to">To:</label>
            <input type="date" id="rent-to" name="rent-to" required>
            <button type="submit" class="button" id="date_form_button">Submit Rental</button>
          </form>

          <button id="waitingList-btn" style="display:none;">Add to Waiting List</button>

        <?php endif; ?>
      </div>
    </div>

    <!-- Display car inner images -->
    <div class="car-inner-images">
      <h3>Car Inner Images</h3>
      <div class="inner-images-wrapper">
        <?php while ($image = mysqli_fetch_assoc($car_inner_images)): ?>
          <img src="<?php echo htmlspecialchars($image['car_inner_image']); ?>" alt="Car Inner Image">
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>


<script src="../JS/car_details.js"></script>
<script src="../JS/loggOut.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
</body>
</html>
