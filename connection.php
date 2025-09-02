<?php

$conn=mysqli_connect("localhost", "root", "", "DBNAME");

if(mysqli_connect_error()){
    echo"<script>alert('Cannot connect to the database.');</script>";
    exit();
}

?>