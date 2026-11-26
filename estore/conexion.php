<?php
$con = mysqli_connect("db", "root", "root_password", "Proyectofinal");

if (!$con) {
    die("Database connection error: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>
