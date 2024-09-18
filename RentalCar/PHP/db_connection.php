<?php



$connection = new mysqli( 'localhost','root' , '' ,'rental_car');

if($connection->connect_error){
  echo "Connection Failed: ". $conn->connect_error;
}