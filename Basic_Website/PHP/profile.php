<?php
session_start();
include('db_connect.php');
    $message = '';
    $message_type = '';
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = '';
}

// Handle Password Change
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $username = $_SESSION['username'];
    
    // Fetch current password from database
    $password_query = "SELECT password FROM user WHERE Name = '$username'";
    $result = mysqli_query($connection,$password_query);
    $row = mysqli_fetch_assoc($result);
    $password = $row['password'];

    if ($password && $current_password === $password) {
        if ($new_password === $confirm_password) {
            // Update password
            $update_password = "UPDATE user SET password = ? WHERE Name = ?";
            $statement = $connection->prepare($update_password);
            $statement->bind_param('ss', $new_password, $username);
            $statement->execute();
            
            if ($statement->affected_rows > 0) {
                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Your password has been updated successfully.';
            } else {
                $_SESSION['message_type'] = 'fail';
                $_SESSION['message'] = 'An error occurred while updating your password.';
            }
        } else {
            $_SESSION['message_type'] = 'fail';
            $_SESSION['message'] = "The new passwords do not match.";
        }
    } else {
        $_SESSION['message_type'] = 'fail';
        $_SESSION['message'] = 'The current password is incorrect.';
    }
    header("Location: ".$_SESSION['link'].'profile.php');
    exit;
}

// Clear messages after displaying
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="icon" href="../icon.webp" type='image/jpg'>
    <link rel="stylesheet" href="../CSS/profile.css">
</head>
<body>
    <!-- Show the Messages after Change the password -->
    <?php if (isset($message)): ?>
        <div class="message-<?php echo htmlspecialchars($message_type); ?>" id="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

        <script>
            // Show the message
            const messageElement = document.getElementById('message');
            messageElement.style.display = 'block';

            // Add a class for fade-out
            setTimeout(function() {
                messageElement.classList.add('fade-out');
                // Hide the message completely after the fade-out
                setTimeout(function() {
                    messageElement.style.display = 'none';
                }, 500); // Match this with the CSS transition duration
            }, 4000); // 4000 milliseconds = 4 seconds
        </script>
    <?php endif; ?>

    <div class="profile-container">
        <h1>Profile</h1>
        
        <div class='user-data'>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
        </div>
        
        <h2>Change Password</h2>
        <form action="" method="post">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Change Password">
        </form>
    </div>
</body>
</html>
