<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: Login.php'); // Redirect to login page if not logged in
    exit();
}
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['car_id'])) {
        $car_id = $_POST['car_id'];

        // Query to get car data based on car_id
        $POST_car_data_query = "SELECT * FROM car WHERE car_id='$car_id'";
        $car_data = mysqli_query($connection, $POST_car_data_query);

        if ($car_data && mysqli_num_rows($car_data) > 0) {
            $row = mysqli_fetch_assoc($car_data);

            $is_rented = $row['is_rented'];
            $rented_from = $row['rented_from'];
            $rented_to = $row['rented_to'];

            // Prepare response based on the car's availability
            if ($is_rented) {
                echo json_encode([
                    'status' => 'rented',
                    'message' => "This car is rented already. You can join the waiting list for this car.",
                    'rented_from' => $rented_from,
                    'rented_to' => $rented_to,
                ]);
            } else {
                echo json_encode([
                    'status' => 'available',
                    'message' => "Car is available for rent.",
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "There is no car with this ID found."
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => "No car ID provided."
        ]);
    }
}
?>
