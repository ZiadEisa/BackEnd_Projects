<?php
session_start();  // Start the session at the very beginning

// Check if the user is logged in
if (isset($_SESSION['username'] )) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}  

// Debugging: Check if session is working
if (!isset($_SESSION)) {
    echo json_encode([
        "status" => "error",
        "message" => "Session failed to start."
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db_connection.php');

    // Retrieve username and password from POST request
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        echo json_encode([
            "status" => "error",
            "message" => "Username or password cannot be empty."
        ]);
        exit();
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT password,is_admin FROM customer WHERE username = ?");
    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "message" => 'Prepare failed: ' . $connection->error
        ]);
        exit();
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $DB_password = $row['password'];
        $is_admin = $row['is_admin'];
        // Verify the password
        if (password_verify($password, $DB_password)) {
            // Store the username in the session
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = ($is_admin? 1: 0);
            echo json_encode([
                "status" => "success",
                "message" => "Log in successful for: " . $_SESSION['username']
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Password is incorrect."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Username is not registered."
        ]);
    }

    $stmt->close();
    $connection->close();
}
?>
