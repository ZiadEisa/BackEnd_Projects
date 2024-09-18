<?php
session_start();

// Destroy the session to log the user out
session_unset(); 
session_destroy();

$response = [
  "status" => "success",
  "message" => "You have been logged out successfully."
];

echo json_encode($response);
?>
