<?php
    session_start(); 

    $username = '';
    $email = '';
    $Success_Message = '';
    $Error_Message = '';
    $link = "http://localhost/Blog_Website/PHP/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include('db_connect.php');
        
        if(!$_SESSION['username']){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $rePassword = $_POST['re-password'];


            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            if (!preg_match("/^[a-zA-Z_]*$/", $username)) {
                $_SESSION['error_message'] = "User Name must consist of only alphabetic characters (both uppercase and lowercase) and underscores.";
            } else if ($password != $rePassword) {
                $_SESSION['error_message'] = "Passwords do not match.";
            } else {
                $query = "SELECT Name FROM user WHERE Name = '$username'";
                $is_username_exist = mysqli_query($connection, $query);
                if (mysqli_num_rows($is_username_exist) > 0) {
                    $_SESSION['error_message'] = "This Username is already used.";
                } else {
                    $query = "INSERT INTO user (Name, email, password) VALUES ('$username', '$email', '$password')";
                    $is_username_exist = mysqli_query($connection, $query);
                    if ($is_username_exist) {
                        $_SESSION['success_message'] = "You have been signed up successfully. You can <a class='login-button' href='{$link}LogIn.php'>Log In</a> now.";
                    } else {
                        $_SESSION['error_message'] = "An error occurred during registration.";
                    }
                }
            }

            mysqli_close($connection);
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
            exit();
        }else{
            $_SESSION['error_message'] = "You are Already logged in";
        }
    }


    $Error_Message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
    
    $Success_Message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
    $username = isset($_SESSION['username'])? $_SESSION['username'] :NULL;
    $email = isset($_SESSION['email'])? $_SESSION['email'] : '';
    unset($_SESSION['error_message']);
    unset($_SESSION['success_message']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/SignUp.css">
    <link rel="icon" href="../icon.webp" type="image/png">
    <title>Sign Up | Pulse Blog</title>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="" method="POST">
            <?php if($Error_Message): ?>
                <div class='error'><?php echo ($Error_Message); ?></div>
            <?php endif;?>

            <?php if($Success_Message): ?>
                <div class='success'><?php echo ($Success_Message); ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required minlength="8">
            </div>

            <div class="form-group">
                <label for="re-password">Re-enter Password</label>
                <input type="password" name="re-password" id="re-password" placeholder="Re-enter your password" minlength="1" required>
            </div>

            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>
