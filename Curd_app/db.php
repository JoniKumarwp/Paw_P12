<?php
 $host = 'localhost:3307';
 $user = 'root';
 $pass = '';
 $dbname = 'db_vehicle';
 $conn = mysqli_connect($host, $user, $pass, $dbname);
 if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
 }
 ?>