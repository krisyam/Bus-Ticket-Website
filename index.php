<?php
session_start();
if(isset($_SESSION['username'])){
    header("Location: main.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <h2>Login</h2>
    </header>
    <div class="container_b">
        <form action="actions/sign_in.php" method="POST">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>Username:</label>
            <input type="text" name="username" placeholder="Username" autocomplete="on"><br>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Password" autocomplete="on"><br>
            <input type="submit"><br>
        </form>
    </div>
</body>
</html>