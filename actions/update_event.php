<?php
session_start();
include "../db_connect.php";

if (isset($_POST['u_e_name']) && isset($_POST['u_e_id'])) {
    $e_id = $_POST['u_e_id'];
    $e_name = trim($_POST['u_e_name']);
    if(isset($_POST['u_image'])){
        $target_dir = "../uploads/";
        $target_dir2 = "uploads/";
        $target_main_dir = $target_dir2.basename($_FILES["image"]["name"]);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    }
    if(empty($e_name)){
        header("Location: ../index.php?error=Event name is required");
		exit();
    }else{
        if (isset($_POST['u_image'])){
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $update = "UPDATE events SET event_name='$e_name', event_image='$target_main_dir' WHERE event_id='$e_id'";
            mysqli_query($conn, $update);
            
        }else{
            $update = "UPDATE events SET event_name='$e_name' WHERE event_id='$e_id'";
            $result = mysqli_query($conn, $update);
            print($result);
        }
        mysqli_close($conn);
        header("Location: ../main.php?success=Event Successfully Updated");
        exit();
    }
}else{
    header("Location: ../main.php?error=Fill required all fields");
    exit();
}

    
?>