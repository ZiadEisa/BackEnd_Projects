<?php
session_start();
$error_message = '';
$success_message = '';
$link = "http://localhost/RentalCar/PHP/";
include('db_connection.php');


if (isset($_SESSION['username'] )) {
  header('Location: index.php'); // Redirect to login page if not logged in
  exit();
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : NULL;
    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $password = isset($_POST['password']) ? $_POST['password'] : NULL;
    $ConfirmPassword = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : NULL;
    $isAdmin = isset($_POST['is-admin']) && $_POST['is-admin'] === 'yes' ? 1 : 0;

    $password = trim($password);
    $ConfirmPassword = trim($ConfirmPassword);

    $Valid = 1;
    for ($i = 0; $i < strlen($username); $i++) {
        if ($username[$i] >= 'a' && $username[$i] <= 'z' ||
            $username[$i] >= 'A' && $username[$i] <= 'Z' ||
            $username[$i] >= '0' && $username[$i] <= '9' || $username[$i] == '_') {
            $Valid = 1;
        } else {
            $Valid = 0;
            break;
        }
    }

    if (!$Valid) {
        $error_message = 'Username should only contain letters, numbers, or underscores';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($password != $ConfirmPassword) {
            $error_message = "Passwords do not match";
        } else {
            // Check if the username is already taken
            $is_username_used_Query = "SELECT * FROM customer WHERE username='$username'";
            $is_username_used = mysqli_query($connection, $is_username_used_Query);
            if (mysqli_num_rows($is_username_used) > 0) {
                $error_message = "This username is already taken";
            } else {
              
                $add_user_Query = "INSERT INTO customer (username, name, is_admin, password, email) 
                                   VALUES ('$username', '$name', $isAdmin, '$hashed_password', '$email')";
                $add_user_res = mysqli_query($connection, $add_user_Query);
                if ($add_user_res) {
                    $success_message = 'Your account has been created successfully.';
                } else {
                    $error_message = 'An error occurred while creating your account.';
                }
            }
        }
    }
    header("Location: " . "http://localhost/RentalCar/PHP/SignUp.php");
    exit();
}
?>














<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/SignUp.css">
  <link rel="stylesheet" href="../CSS/navBar.css">
  <link rel="shortcut icon" href="../Images/icon.jpeg" type="image/x-icon">
  <title>Car Rental | Sign Up</title>
</head>
<body>

  <!-- Background -->
  <div id="background"></div>

  <!-- Navigation Bar -->
  <div class="nav-bar">
          <div class="logo">Car Rental</div>
          <ul class="nav-list">
          <li><a href="index.php">Cars</a></li>
          <li><a href="about.php">About Us</a></li>
          <?php if(isset($_SESSION['username'])){ ?>
              <li><a href="profile.php"><?php echo $_SESSION['username']?></a></li>
              <?php if(isset($_SESSION['is_admin'])&&$_SESSION['is_admin'] ){?>
              <li><a href="AddCars.php"></a></li>
              <?php } ?>
              <li><button id="loggout_btn">Logout</button></li>
          <?php } else { ?>
              <li><a href="Login.php">Log in</a></li>
          <?php } ?>
          </ul>
      </div>

  <!-- Error & Success Messages -->
  <?php if(!empty($error_message)){ ?>
    <div class="error" id="error"><?php echo $error_message ?></div>
  <?php } ?>
  <?php if(!empty($success_message)){ ?>
    <div class="success" id="success"><?php echo $success_message ?></div>
  <?php } ?>

  <!-- Sign-Up Form -->
  <div class="sign-up-form-container">
    <h2 class="form-title">Create Your Account</h2>
    <form method="post" class="sign-up-form">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Your Name" required>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>

        <label>Admin Account</label>
        <div class="radio-group">
            <input type="radio" name="is-admin" id="is-admin-yes" value="yes"> 
            <label for="is-admin-yes">Yes</label>
        </div>

        <input type="submit" value="Create Account" class="submit-btn">
        <input type="reset" value="Discard" class="reset-btn">
    </form>
  </div>
  <script src="../JS/SignUp.js"></script>
</body>
</html>
