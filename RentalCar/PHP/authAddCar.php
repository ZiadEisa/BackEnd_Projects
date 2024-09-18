<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'] )) {
    header('Location: Login.php'); // Redirect to login page if not logged in
    exit();
}  

if(!$_SESSION['is_admin']){
    header('Location: index.php'); // Redirect to index page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';

    if (!empty($_POST['username'])) {
        $Publisher_name = $_POST['username'];

        // Fetch publisher data
        $query_get_publisher_data = "SELECT * FROM customer WHERE username = '$Publisher_name'";
        $res_query = mysqli_query($connection, $query_get_publisher_data);

        // Check if the query was successful and if any rows were returned
        if ($res_query && mysqli_num_rows($res_query) > 0) {
            $row = mysqli_fetch_assoc($res_query);
            $publisher_id = ($row['customer_id']? $row['customer_id']: NULL); // Make sure this key exists

            if ( $publisher_id && $row['is_admin']) {
                $car_type = $_POST['carType'];
                $car_name = $_POST['car-name'];
                $car_speed = $_POST['car-speed'];
                $car_rent_price = $_POST['car-rent-price'];
                $car_image = $_FILES['car-image'];

                if ($car_image && $car_image['error'] === UPLOAD_ERR_OK) {
                    $imagesDir = '../Images/';
                    if (!is_dir($imagesDir)) {
                        mkdir($imagesDir, 0755, true);
                    }
                    $imageName = basename($car_image['name']);
                    $imageTargetPathName = $imagesDir . $imageName;
                    $tempImageName = $car_image['tmp_name'];

                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    if (in_array($car_image['type'], $allowedTypes)) {
                        if (move_uploaded_file($tempImageName, $imageTargetPathName)) {



                            // Validate inner car iamges

                            $detailedImages = $_FILES['car-detailed-images'];
                            $imagesCount = count($detailedImages['name']);
                            if($imagesCount < 4 || $imagesCount > 6){
                                echo "The Inner images You Should select at least 4 files and not more than 6 files";
                                return;
                            }
                            $imagesDir = '../Images/';
                            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                            $response = "Your car added successfully!";

                            if (!is_dir($imagesDir)) {
                                mkdir($imagesDir, 0755, true);
                            }

                            for ($i = 0; $i < $imagesCount; $i++) {
                                if ($detailedImages['error'][$i] === UPLOAD_ERR_OK) {
                                    $tempImageName = $detailedImages['tmp_name'][$i];
                                    $imageName = basename($detailedImages['name'][$i]);
                                    $imageTargetPathName = $imagesDir . $imageName;

                                    if (in_array($detailedImages['type'][$i], $allowedTypes)) {
                                        
                                        if (!move_uploaded_file($tempImageName, $imageTargetPathName)) {
                                            $response = "An error occurred while uploading the image: " . $imageName . "<br>";
                                            break;
                                        }
                                    } else {
                                        $response = "Invalid file type for detail image: " . $imageName . "<br>";
                                        break;
                                    }
                                } else {
                                    $response = "An error occurred while uploading the image. Error code: " . $detailedImages['error'][$i] . "<br>";
                                    break;
                                }
                            }
                            if($response == "Your car added successfully!"){
                                $query_insering_car_data = "INSERT INTO car (car_name, car_type, is_rented, publisher_id, car_rent_rate, car_image) 
                                                            VALUES ('$car_name', '$car_type', 0, '$publisher_id', '$car_rent_price', '$imageTargetPathName')";
                                

                                $res_query = mysqli_query($connection , $query_insering_car_data);
                                $car_id = mysqli_insert_id($connection);
                                if($res_query){
                                    for($i = 0 ; $i < $imagesCount ; $i++){
                                        $imageName = basename($detailedImages['name'][$i]);
                                        $imageTargetPathName = $imagesDir . $imageName;
                                        $insert_inner_images_query = "INSERT INTO car_inner_images (car_id, car_inner_image) VALUES ('$car_id', '$imageTargetPathName')";
                                        $res_query = mysqli_query($connection, $insert_inner_images_query);
                                        if(!$res_query){
                                            $response = "An error occur while inserting your inner images: " . mysqli_errno($connection); 
                                            break;
                                        }
                                    }
                                    echo $response;
                                }
                                else{
                                    echo "An error occur while inserting your car data : " . mysqli_errno($connection); 
                                }
                            }else{
                                echo $response;
                            }
                            
                        } else {
                            echo "An error occurred while uploading the car image: " . $imageName . '<br>';
                        }
                    } else {
                        echo "Invalid file type for car image: " . $imageName . "<br>";
                    }
                } else {
                    echo "An error occurred while uploading the car image: " . $car_image['error'] . '<br>';
                }
            } else {
                echo "You are not authorized to add a car";
            }
        } else {
            echo "No publisher found or query failed.";
        }
    } else {
        echo "You are not logged in yet to upload car info.";
    }
}
?>
