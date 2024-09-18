<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: Login.php'); // Redirect to login page if not logged in
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : null;
    $Username = isset($_POST['username']) ? $_POST['username'] : null;
    $rented_from = isset($_POST['rented_from']) ? $_POST['rented_from'] : null;
    $rented_to = isset($_POST['rented_to']) ? $_POST['rented_to'] : null;

    include('db_connection.php');
    // Prepare the SQL statement to update expired rentals
    if (isset($_SESSION['username'])) {
        if ($car_id) {
            $POST_car_query = "SELECT is_rented FROM car WHERE car_id='$car_id'";
            $res_query = mysqli_query($connection, $POST_car_query);

            if ($res_query && mysqli_num_rows($res_query) > 0) {
                $row = mysqli_fetch_assoc($res_query);
                if ($row['is_rented'] == 0) {
                    $insert_renting_car = "UPDATE car SET rented_from='$rented_from', rented_to='$rented_to', rented_by='$Username', is_rented=1 WHERE car_id='$car_id'";
                    $rent_query = mysqli_query($connection, $insert_renting_car);

                    if ($rent_query) {
                        echo json_encode([
                            "Username" => $Username,
                            "status" => "success",
                            "message" => "Your car has been rented successfully."
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "Failed to rent the car. Please try again later."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "The car is already rented."
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "No car found with this ID."
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "No car found with this ID."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "You are not logged in. Please log in to continue."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid Request Method"
    ]);
}
?>
