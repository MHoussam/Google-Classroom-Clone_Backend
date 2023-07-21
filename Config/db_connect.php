<?php

    $conn=mysqli_connect('localhost','root','','google_classroom');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
?>