<?php
  //Connect to the database
  // Set the database access information as constants...
  DEFINE ('DB_USER', 'vustean');
  DEFINE ('DB_PASSWORD', '');
  DEFINE ('DB_HOST', 'localhost');
  DEFINE ('DB_NAME', 'onlineTests');                          //The port #. It is always 3306
    
  // Make the connection...
  $con = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL! ' . mysqli_connect_error());

  // Set the encoding...
  mysqli_set_charset($con, 'utf8');
?>