<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Car Rental</title>
    <link rel="stylesheet" href="../CSS/about.css">
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


    <!-- Main Content -->
    <div class="content">
        <section class="ceo-section">
            <div class="ceo-photo">
                <img src="../BASH/ZIad.jpg" alt="CEO Photo">
            </div>
            <div class="ceo-info">
                <h1>Meet Our CEO</h1>
                <p>Welcome to Car Rental! Our CEO, Ziad Mohammad Abdelhakam, is dedicated to providing you with the best car rental experience. With years of industry expertise, Ziad ensures that every vehicle in our fleet is of the highest quality and that our service exceeds your expectations.</p>
                <p>Feel free to contact us if you have any questions or need assistance. We're here to make your car rental experience smooth and enjoyable.</p>
            </div>
        </section>

        <section class="about-info">
            <h2>About Us</h2>
            <p>At Car Rental, we offer a wide range of vehicles to suit your needs, from compact cars to luxury vehicles. Our mission is to provide reliable, affordable, and convenient car rental services to make your journey as comfortable as possible.</p>
            <p>Our team is passionate about cars and customer service. We continuously strive to improve our services and make sure you have a memorable experience every time you rent a car with us.</p>
        </section>
    </div>

    <script src="script.js"></script>
</body>
</html>
