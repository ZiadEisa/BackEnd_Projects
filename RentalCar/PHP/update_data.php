<?php 

include('db_connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: Login.php'); // Redirect to login page if not logged in
  exit();
}

$response = [];  // Initialize an array to collect response data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $password = isset($_POST['password']) ? $_POST['password'] : null;
  $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : null;
  $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $username = $_SESSION['username'];

  // Trim the input fields
  $email = trim($email);
  $password = trim($password);
  $newPassword = trim($newPassword);
  $confirmPassword = trim($confirmPassword);

  // Fetch the current hashed password from the database
  $pass_q = "SELECT password FROM customer WHERE username = '$username'";
  $res = mysqli_query($connection, $pass_q);
  
  if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $current_hashed_password = $row['password'];
    
    // Verify the provided current password
    if (password_verify($password, $current_hashed_password)) {

      if ($newPassword === $confirmPassword) {
        $new_hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare the update query based on inputs
        if ($email && $newPassword) {
          // Update both email and password
          $update_q = "UPDATE customer SET password='$new_hashed_password', email='$email' WHERE username='$username'";
        } elseif ($email) {
          // Update only the email
          $update_q = "UPDATE customer SET email='$email' WHERE username='$username'";
        } elseif ($newPassword) {
          // Update only the password
          $update_q = "UPDATE customer SET password='$new_hashed_password' WHERE username='$username'";
        }

        // Execute the update query
        $res_update = mysqli_query($connection, $update_q);

        if ($res_update) {
          if ($email && $newPassword) {
            $response = [
              "status" => "success",
              "message" => "Your email and password were updated successfully."
            ];
          } elseif ($email) {
            $response = [
              "status" => "success",
              "message" => "Your email was updated successfully."
            ];
          } elseif ($newPassword) {
            $response = [
              "status" => "success",
              "message" => "Your password was updated successfully."
            ];
          }
        } else {
          $response = [
            "status" => "error",
            "message" => "Failed to update your details."
          ];
        }
      } else {
        $response = [
          "status" => "error",
          "message" => "New passwords do not match."
        ];
      }
    } else {
      $response = [
        "status" => "error",
        "message" => "Current password is incorrect."
      ];
    }
  } else {
    $response = [
      "status" => "error",
      "message" => "User not found."
    ];
  }

  // Send the response as JSON
  echo json_encode($response);
}
?>
