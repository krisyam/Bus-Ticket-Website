<?php
session_start();
include "../db_connect.php";

$e_id = $_POST['e_id'];
$u_id = $_POST['u_id'];
$insert = "INSERT INTO `bookings`(`event_id`, `user_id`) VALUES('$e_id', '$u_id')";
$result = mysqli_query($conn, $insert);
header("Location: ../main.php?success=Successfully Booked Event");

?>