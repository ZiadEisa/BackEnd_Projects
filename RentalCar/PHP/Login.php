<?php
session_start();
$link = "http://localhost/RentalCar/PHP/";
// Check if the user is logged in
if (isset($_SESSION['username'] )) {
  header('Location: index.php'); // Redirect to login page if not logged in
  exit();
}  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../Images/icon.jpeg" type="image/x-icon">
  <link rel="stylesheet" href="../CSS/navBar.css">
  <link rel="stylesheet" href="../CSS/login.css">
  <title>Car Rental | Login</title>
  <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous">
  </script>
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
            <li><button id="loggout_btn">Logout</button></li>
        <?php } else { ?>
            <li><a href="login.php">Log in</a></li>
        <?php } ?>
        </ul>
    </div>

  <div id="background"></div>
  <div id="message"></div>
  <div class="login-form-container">
    <h2 class="login-title">Log in to Car Rental</h2> 

    <form id="login-form" method="post" class="login-form">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required placeholder="Enter Your Username">

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required placeholder="Enter Your Password">

      <a href='SignUp.php'>Create an account</a><br>
      <input type="submit" value="Login" class="login-btn" id="login-button">
    </form>

    <script src="../JS/login.js"></script>
  </div>
</body>
</html>
