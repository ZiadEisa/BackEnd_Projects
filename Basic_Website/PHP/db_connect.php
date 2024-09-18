<?php

$server_name = 'localhost';
$Username = 'root';
$Password = '';
$DB_name = 'PluseBlog';

$connection = mysqli_connect($server_name, $Username, $Password, $DB_name);

if(!$connection){
    echo "Can't Connect\n";
}