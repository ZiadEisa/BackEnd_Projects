<?php 

    session_start();
    $username = isset($_SESSION['username'])? $_SESSION['username'] : NULL; 
    $link = "http://localhost/Blog_Website/PHP/";
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
            include ('db_connect.php');
            if(!$username){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $_SESSION['username'] = $username;
                $query_username_exist = "SELECT Name , password , email FROM user WHERE Name = '$username'";
                $is_username_exist = mysqli_query($connection,$query_username_exist);
                if(mysqli_num_rows($is_username_exist) > 0){
                    $result_row = mysqli_fetch_assoc($is_username_exist);
                    if($password == $result_row['password'] ){
                        $_SESSION['email'] = $result_row['email'];
                        header("Location: ${link}index.php");
                    }else{
                        $_SESSION['error_message'] = "Password is not correct.";
                        unset($_SESSION['username']);
                        $username =  NULL;
                    }
                }else{
                    $username =  NULL;
                    unset($_SESSION['username']);
                    $_SESSION['error_message'] = "Username is not Signed up before.<br>Would You like to <a class='SignUp-button' href='${link}SignUp.php'> Sign Up</a>.";
                }
            }else{
                $_SESSION['error_message'] = "You are Already logged in";
            }
    }
    $Error_Message = (isset($_SESSION['error_message'])? $_SESSION['error_message'] : '' );
    $username = (isset($_SESSION['username'])? $_SESSION['username']: NULL);
    unset($_SESSION['error_message']);
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../icon.webp" type="image/png">
    <link rel="stylesheet" href="../CSS/login.css">
    <title>Log In | Pulse Blog</title>
</head>
<body>
    <form action="" class="login-form" method='POST'>
        <h2>Log In</h2>
        <?php if ($Error_Message) : ?>
            <div class="error-message"><?php echo $Error_Message; ?></div>
        <?php endif; ?>
        <div class="username">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="password">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <input type="submit" value="Log In">
    </form>
</body>
</html>
