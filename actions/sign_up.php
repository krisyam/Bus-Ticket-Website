<?php
session_start();
include "../db_connect.php";



if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {

	
	$uname = trim($_POST['username']);
	$pass = trim($_POST['password']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $check = "SELECT username FROM users_detail Where username = '$uname'";
    $insert = "INSERT INTO users_detail(username,password,name,email) VALUES('$uname','$pass','$name','$email')";

	if (empty($name) || empty($uname) || empty($pass) || empty($email)) {
		header("Location: ../main.php?error=Please Fill All Fields");
		exit();
	} else {
		$uname_check = mysqli_query($conn, $check);
		if (mysqli_num_rows($uname_check) == 0) {
			mysqli_query($conn, $insert);
            mysqli_close($conn);
			header("Location: ../main.php?created=Account created successfully");
			
		} else {
			header("Location: ../main.php?error=Email already exists");
		}
	}
}
