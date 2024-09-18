<?php
session_start();
include('db_connection.php'); // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: Login.php'); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'];

// Fetch user data from the database
$query = "SELECT name, username, email, is_admin FROM customer WHERE username='$username'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $name = htmlspecialchars($user['name']);
    $email = htmlspecialchars($user['email']);
    $is_admin = $user['is_admin'] ? 'Yes' : 'No';
} else {
    // Handle error or show default message
    $name = 'N/A';
    $email = 'N/A';
    $is_admin = 'No';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="../CSS/navBar.css">
  <link rel="stylesheet" href="../CSS/profile.css">
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



  <div class="profile-container">
        <header class="profile-header">
            <h1 class="profile-name"><?php echo $name; ?></h1><br>
            <button class="edit-button" onclick="document.getElementById('update-form').style.display='block'">Edit Profile</button>
        </header>
        <section class="profile-info">
            <h2>Profile Information</h2>
            <div class="info-item">
                <strong>Name:</strong>
                <span id="profile-name"><?php echo $name; ?></span>
            </div>
            <div class="info-item">
                <strong>Username:</strong>
                <span id="profile-username"><?php echo $username; ?></span>
            </div>
            <div class="info-item">
                <strong>Email:</strong>
                <span id="profile-email"><?php echo $email; ?></span>
            </div>
            <div class="info-item">
                <strong>Admin:</strong>
                <span id="profile-admin"><?php echo $is_admin; ?></span>
            </div>
        </section>
        <div id="error_message" class="error_message" style="display: none;"></div>
        <div id="success_message" class="success_message" style="display: none;"></div>
        <!-- Update form -->
        <section id="update-form" style="display:none;">
            <h2>Update Profile</h2>
            <form action="" method="post">
                <div class="info-item">
                    <label for="current-password">Current Password:</label>
                    <input type="password" id="current-password" name="current_password" required>
                </div>
                <div class="info-item">
                    <label for="new-email">New Email:</label>
                    <input type="email" id="new-email" name="new_email">
                </div>
                <div class="info-item">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new_password">
                </div>
                <div class="info-item">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm_password">
                </div>
                <div class="info-item">
                    <input type="submit" value="Update Profile" id="Update">
                </div>
            </form>
        </section>
        <footer class="profile-footer">
            <p>&copy; 2024 Car Rental Website. All rights reserved.</p>
        </footer>
    </div>

    <script src="../JS/profile.js"></script>
    <script src="../JS/loggOut.js"></script>
    </body>
</html>
