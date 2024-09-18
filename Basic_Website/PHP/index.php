<?php 
    session_start();
    include ('db_connect.php');
    $username = isset($_SESSION['username'])? $_SESSION['username'] : NULL ;
    $_SESSION['link'] = 'http://localhost/Blog_Website/PHP/';
    $get_all_posts_query = "SELECT * FROM blog ";
    $Blogs = mysqli_query($connection , $get_all_posts_query);
    // $posts = mysqli_fetch_assoc($get_all_posts);
    // Get User ID
    
    function Get_username($ID){
        global $connection;
        $Query = "SELECT Name FROM user WHERE userID = '$ID'";
        $result = mysqli_query($connection,$Query);
        $UID = mysqli_fetch_assoc($result);
        return $UID['Name'];
    }
    function Get_user_ID($Name){
        global $connection;
        $Query = "SELECT UserID FROM user WHERE Name = '$Name'";
        $result = mysqli_query($connection,$Query);
        $UID = mysqli_fetch_assoc($result);
        return $UID['UserID'];
    }
    // Functions For Handeling the Likes and Dislikes With the Blog
                
    function Is_user_like_or_dislike_before($USER_ID, $BLOG_ID) {
        global $connection;
        $query = "SELECT * FROM reacts WHERE userID = '$USER_ID' AND blogID = '$BLOG_ID'";
        $result = mysqli_query($connection, $query);
        return mysqli_fetch_assoc($result) ? true : false;
    }
    
    function Add_one_React($react_type, $USER_ID, $BLOG_ID) {
        global $connection;
        $query = "INSERT INTO reacts (userID, blogID, $react_type) VALUES ('$USER_ID', '$BLOG_ID', 1)
                  ON DUPLICATE KEY UPDATE $react_type = 1";
        mysqli_query($connection, $query);
    
        // Update the blog table with the incremented count
        $react_type = ($react_type=="likes"? "likes" : "Dlikes");
        $update_blog_query = "UPDATE blog SET $react_type = $react_type + 1 WHERE blogID = '$BLOG_ID'";
        mysqli_query($connection, $update_blog_query);
    }
    
    function remove_React($react_type,$USER_ID, $BLOG_ID) {
        global $connection;
        $query = "DELETE FROM reacts WHERE userID = '$USER_ID' AND blogID = '$BLOG_ID'";
        mysqli_query($connection, $query);
    
        // Decrement the count in the blog table
        $query = "UPDATE blog SET $react_type = $react_type - 1 WHERE blogID = '$BLOG_ID' ";
        mysqli_query($connection, $query);
    }
    
    function Decrease_the_number_of_reactsByOne($USER_ID, $BLOG_ID) {
        global $connection;
        $query = "SELECT likes, dislikes FROM reacts WHERE userID = '$USER_ID' AND blogID = '$BLOG_ID'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
    
        if ($row['dislikes'] == 1) {
            return -1; // Indicate that the user disliked before
        } else if ($row['likes'] == 1) {
            return 1; // Indicate that the user liked before
        }
        return 0; // No previous reaction
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($username){
            $action = $_POST['action'];
            $username = $_SESSION['username'];
            $userID = Get_user_ID($username);
            switch ($action) {
                case 'Post':
                    
                    $content = trim($_POST['content']);
                    
                    if (empty($content)) {
                        $_SESSION['message'] = "At least one character is required in your blog.";
                        $_SESSION['message_type'] = 'fail';
                    } else {
                        if (isset($_FILES['BlogImage']) && $_FILES['BlogImage']['error'] == UPLOAD_ERR_OK) {
                            $image_name = $_FILES['BlogImage']['name'];
                            $image_temp_name = $_FILES['BlogImage']['tmp_name'];
                            $folder = '../Images/' . $image_name;
                            $query = "INSERT INTO blog (BlogContent, image, userID) VALUES ('$content', '$image_name', '$userID')";
                            $result = mysqli_query($connection, $query);
        
                            if (move_uploaded_file($image_temp_name, $folder)) {
                                $_SESSION['message'] = "Your blog was posted successfully.";
                                $_SESSION['message_type'] = 'success';
                            } else {
                                $_SESSION['message'] = "An error occurred while posting your blog.";
                                $_SESSION['message_type'] = 'fail';
                            }
                        } else {
                            $query = "INSERT INTO blog (BlogContent, userID) VALUES ('$content', '$userID')";
                            $result = mysqli_query($connection, $query);
        
                            if ($result) {
                                $_SESSION['message'] = "Your blog was posted successfully.";
                                $_SESSION['message_type'] = 'success';
                            } else {
                                $_SESSION['message'] = "An error occurred while posting your blog.";
                                $_SESSION['message_type'] = 'fail';
                            }
                        }
                    }
                    break;
        
                case 'comment':
                    $comment = trim($_POST['CommentContent']);
                    $blogID = $_POST['blogId'];
            
                    if (empty($comment)) {
                        $_SESSION['message'] = "Comment cannot be empty.";
                        $_SESSION['message_type'] = 'fail';
                    } else {
                        $blogID = $_POST['blogId'];
                        $query = "INSERT INTO comment (blogID , Content, userID) VALUES ( '$blogID' ,'$comment', '$userID')";
                        $result = mysqli_query($connection, $query);

                        if ($result) {
                            $_SESSION['message'] = "Your comment has been posted successfully.";
                            $_SESSION['message_type'] = 'success';
                        } else {
                            $_SESSION['message'] = "An error occurred while posting your comment.";
                            $_SESSION['message_type'] = 'fail';
                        }
                    }
                    break;
        
                case 'like':
                    // Handel if User like or Dis-like this Before
                    $blogID = $_POST['blogId'];
                    
                    if(Is_user_like_or_dislike_before($userID , $blogID)){
                        $result = Decrease_the_number_of_reactsByOne($userID , $blogID);

                        if($result == -1)//Mean he react with Dislike before 
                        {   
                            remove_React("Dlikes",$userID , $blogID);
                            Add_one_React("likes",$userID , $blogID);
                        }else{
                            remove_React("likes", $userID , $blogID);
                        }
                        
                    }else{
                        Add_one_React("likes",$userID , $blogID);
                    }
                    break;
        
                case 'dislike':
                    $blogID = $_POST['blogId'];
                    // Handle dislike action
                    // Handel if User like or Dis-like this Before
                    if(Is_user_like_or_dislike_before($userID , $blogID)){
                        $result = Decrease_the_number_of_reactsByOne($userID , $blogID);

                        if($result == 1)//Mean he react with like before 
                        {   
                            remove_React("likes",$userID , $blogID);
                            Add_one_React("Dislikes",$userID , $blogID);
                        }else{
                            remove_React("Dlikes",$userID , $blogID);
                        }
                        
                    }else{
                        Add_one_React("Dislikes",$userID , $blogID);
                    }
                    break;
                case 'Log-out':
                    $username = NULL;
                    session_destroy();
                    break;

                case 'delete-blog':
                    $blogID = $_POST['blogId'];
                    $query = "DELETE FROM comment WHERE BlogID = '$blogID'";
                    $result = mysqli_query($connection , $query);

                    $query = "DELETE FROM blog WHERE BlogID = '$blogID' AND userID = '$userID'";
                    $result = mysqli_query($connection , $query);

                    $_SESSION['message'] = "Your Blog Deleted successfully.";
                    $_SESSION['message_type'] = 'success';
                    break;
                case 'delete-comment':
                    $CommentID = $_POST['CommentID'];

                    $query = "DELETE FROM comment WHERE CommentID = '$CommentID'";
                    $result = mysqli_query($connection , $query);
                    break;
                default:
                    $_SESSION['message'] = "Unknown action.";
                    $_SESSION['message_type'] = 'fail';
                    break;
            }
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }else{
            $_SESSION['message_type'] = 'fail';
            $_SESSION['message'] = "Loggin First ";
        }
    }
    
    // Clear messages after displaying
    $message = NULL;
    $message_type = NULL;
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
    <link rel="icon" href="../icon.webp" type="image/png">
    <link rel="stylesheet" href="../CSS/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse Blog</title>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="../icon.webp" alt="Blog Icon" class="blog-icon">
            <h1>Hello <?php echo (($username));?> in Pluse Blog</h1>
            <nav>
                <ul>
                    <li><a href="<?php echo htmlspecialchars($_SESSION['link'] . 'index.php') ?>">Home</a></li>
                    <li><a href="<?php echo htmlspecialchars($_SESSION['link'] . 'about.php') ?>">About</a></li>
                    <li><a href="<?php echo htmlspecialchars($username ? $_SESSION['link'] . 'profile.php' : '') ?>"><?php echo htmlspecialchars($username); ?></a></li>
                    <li>
                        <?php if($username):?>
                        <form action="" method="post" class="logout-form">
                            <input type="submit" value="Log-out" name="action" class="logout-button">
                        </form>
                        <?php endif; if(!$username): ?>
                            <a href="http://localhost/Blog_Website/PHP/LogIn.php">Log-in</a>
                            
                        <?php endif;?>
                    </li>
            </ul>
            </nav>
        </div>
    </header>


    <main>
        <section class="featured-post">
            <?php if ($message): ?>
                <div class="message-<?php echo $message_type; ?>" id="message">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                endif; ?>
            <h2>Post Your Thoughts</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <textarea class='post-text' name="content"></textarea>
                <div class="input-group">
                    <input type="file" name="BlogImage" id="image" accept=".png, .jpg, .jpeg">
                    <input class='post-now' type="submit" value="Post" name ='action'>
                </div>
            </form>
        </section>

        <section class="recent-posts">
        <?php
?>
    <div class="blog-container">
        <div class="blog-content-section">
            <!-- Blog content and image -->
            <?php
            while($blog = mysqli_fetch_assoc($Blogs)){
                $image = $blog['image'];
                $content = $blog['BlogContent'];
                $likes = $blog['likes'];
                $DisLikes = $blog['Dlikes'];
                $userID = $blog['userID'];
                $blogID = $blog['BlogID'];
                echo '<div class="blog-post">';
                
                // Delete Post Option
                if($username){
                    $current_user_id = Get_user_ID($username);
                    if($userID == $current_user_id){
                        echo '<form action="" method="post" class="delete-form">';
                        echo '<input type="hidden" name="blogId" value="' . htmlspecialchars($blogID) . '">';
                        echo '<button type="submit" name="action" value="delete-blog" class="delete-button">Delete Blog</button>';
                        echo '</form>';       
                    }
                }

                echo '<p class="blog-content">' . $content . '</p>';
                if($image){
                    ?>
                        <img src="../Images/<?php echo $image ?>" alt="Blog Image" class="blog-image">
                    <?php
                }
                
                // Comment Section
                $query = "SELECT * FROM comment WHERE BlogID = '$blogID'";
                $result = mysqli_query($connection , $query);
                ?>
                                    <!-- Comment Section -->
                    <form action="" method="post" class="react-form">
                        <input type="text" name="CommentContent" placeholder="Add a Comment..." class="comment-input">
                        <button type="submit" name="action" value="comment" class="comment-button">Comment</button>
                        <input type="hidden" name="blogId" value="<?php echo $blogID; ?>">
                        
                    </form>
                    <form action="" method="post" class="react-form">
                        <input type="hidden" name="blogId" value="<?php echo $blogID; ?>">
                        <button type="submit" name="action" value="like" class="react-button like-button">
                            <span><?php echo $likes; ?></span>
                        </button>
                        <button type="submit" name="action" value="dislike" class="react-button dislike-button">
                            <span><?php echo $DisLikes; ?></span>
                        </button>
                        
                    </form>
                </div> <!-- Close comments-reactions-section -->
                <br><br><br>
                <p>Comments</p>
                <div class="comments-reactions-section">

                    <div class="comment-list">
                        <?php while ($comment = mysqli_fetch_assoc($result)) {
                            $blogId = $comment['BlogID'];
                            $userId = $comment['userID'];
                            $Content = $comment['Content'];
                            $commentID = $comment['CommentID'];

                            echo '<div class="comment-box">';
                            
                            // Delete Comment
                            if ($username) {
                                $current_user_id = Get_user_ID($username);
                                if ($userId == $current_user_id || $blog['userID'] == $current_user_id) {
                                    echo '<form action="" method="post" class="delete-form">';
                                    echo '<input type="hidden" name="CommentID" value="' . htmlspecialchars($commentID) . '">';
                                    echo '<button type="submit" name="action" value="delete-comment" class="delete-button">Delete Comment</button>';
                                    echo '</form>';
                                }
                            }
                            
                            $CommentWriter = Get_username($userId);
                            // Display the comment content 
                            ?>
                            <p class='CommentWriter'><?php echo ($CommentWriter) ?> </p>
                            <?php
                            echo '<input type="text" class="comment-content" value="' . htmlspecialchars($Content) . '" readonly>';
                            echo '</div>'; // Close comment-box
                        } ?>
                    </div> <!-- Close comment-list -->

                <?php
                echo '</div>'; // Close blog-post
                echo '<hr>';
            }
            ?>
    </div> <!-- Close blog-content-section -->
        </div> <!-- Close blog-container -->


        </section>
    </main>

    <footer>
        <p>&copy; 2024 My Blog. All rights reserved.</p>
    </footer>
        
    <script>
        // Show the message
        const messageElement = document.getElementById('message');
        if (messageElement) {
            messageElement.style.display = 'block';

            // Add a class for fade-out
            setTimeout(function() {
                messageElement.classList.add('fade-out');
                setTimeout(function() {
                    messageElement.style.display = 'none';
                }, 500);
            }, 4000);
        }
    </script>
</body>
</html>
