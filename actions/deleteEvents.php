<?php
session_start();
include "../db_connect.php";

$e_id = $_POST['e_id'];
$delete = "DELETE FROM events WHERE event_id='$e_id'";
$result = mysqli_query($conn, $delete);
header("Location: ../main.php?success=Successfully Deleted Event");

?>