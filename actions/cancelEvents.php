<?php
include "../db_connect.php";
session_start();


    $e_id = $_POST["e_id"];
    $u_id = $_SESSION["userid"];
    $delete = "DELETE FROM bookings WHERE user_id='$u_id' AND event_id='$e_id'";
    mysqli_query($conn, $delete);
    header("Location: ../main.php?success=Successfully Canceled Booked Event");
    exit();
?>