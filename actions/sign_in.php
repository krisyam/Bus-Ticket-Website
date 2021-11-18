<?php
session_start();
include "../db_connect.php";


if (isset($_POST['username']) && isset($_POST['password'])) {

	$uname = trim($_POST['username']);
	$pass = trim($_POST['password']);
    $query = "  SELECT user_id, username, name, user_type 
                FROM users_detail
                WHERE username = '$uname' AND password = '$pass'";


	if (empty($uname)) {
		header("Location: ../index.php?error=Username is required");
		exit();
	} else if (empty($pass)) {
		header("Location: ../index.php?error=Password is required");
		exit();
	} else {
		$result = mysqli_query($conn,$query);
		if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
			$_SESSION['userid'] = $row["user_id"];
			$_SESSION['username'] = $row["username"];
            $_SESSION['name'] = $row["name"];
            $_SESSION['level'] = $row["user_type"];
			header("Location: ../main.php");
			exit();
		} else {
			header("Location: ../index.php?error=Incorect Username or password");
			exit();
		}
	}
	header("Location: ../index.php");
	exit();
}
