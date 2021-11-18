<?php
session_start();
include "../db_connect.php";

if (isset($_POST['e_name'])) {
    $e_name = trim($_POST['e_name']);
    $target_dir = "../uploads/";
    $target_dir2 = "uploads/";
    $target_main_dir = $target_dir2.basename($_FILES["image"]["name"]);
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
    if(empty($e_name)){
        header("Location: ../index.php?error=Event name is required");
		exit();
    }else{
        if (file_exists($target_file)){
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }

        $insert = "INSERT INTO events(event_name, event_image) VALUES('$e_name','$target_main_dir');";
        $result = mysqli_query($conn, $insert);
        mysqli_close($conn);
        header("Location: ../main.php?success=Event Successfully Created");
        exit();
    }
}

    
?>