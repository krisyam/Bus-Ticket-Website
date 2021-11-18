<?php
include "db_connect.php";


$query = "SELECT event_id,event_name,event_image FROM events";
$result = mysqli_query($conn, $query);
$size = mysqli_num_rows($result);
if ($size > 0) {
    while($row = mysqli_fetch_assoc($result)){
        array_push($_SESSION["event_arr"],$row["event_id"],$row["event_name"],$row["event_image"]);
    }
};

if($_SESSION['level']=="User"){
    $_SESSION["bookedEvents"] = array();
    $sess = $_SESSION["userid"];
    $query1 = "SELECT event_id FROM bookings WHERE user_id='$sess' GROUP BY event_id";
    $result1 = mysqli_query($conn, $query1);
    $size1 = mysqli_num_rows($result1);
    if ($size1 > 0) {
        while($row1 = mysqli_fetch_assoc($result1)){
            array_push($_SESSION["bookedEvents"],$row1["event_id"]);
        }
    };
}
?>