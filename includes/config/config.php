<?php
  ob_start(); // Turns on output buffering

  session_start(); // Start the session

  date_default_timezone_set("Australia/Sydney"); // Set to the current timezone in Australia

  //Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbName = "manhhuytv";

  $conn = mysqli_connect($servername, $username, $password, $dbName);

    if( !$conn){
      die("Connection failed: " . mysqli_connect_error());
    }
?>