<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION["event_arr"])){
    $_SESSION["event_arr"] = array();
}else{
    unset($_SESSION["event_arr"]);
    $_SESSION["event_arr"] = array();
}

include "actions/queryEvents.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Events</h2>
    </header>
    <div class="container_b grid disp">
        <div>
            <div class="name"><?php echo $_SESSION["name"]?></div>
            <form action="actions/sign_out.php"><button>Sign Out</button></form>
        </div>
        
        <div class="admin container">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <button onclick="open_c_event()">Create Event</button>
            <button onclick="open_c_user()">Create User</button>
            <form action="actions/add_event.php" method="POST" class="c_event" style="display:none;" enctype="multipart/form-data">
                <h3>Create Event</h3>
                <label>Event Name:</label>
                <input type="text" name="e_name" id="e_name"><br>
                <label>Event Image:</label>
                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg"><br>
                <button type="submit">Create Event</button>
            </form>

            <form action="actions/update_event.php" method="POST" class="u_c_event" style="display:none;" enctype="multipart/form-data">
                <h3>Create Event</h3>
                <input type="hidden" name="u_e_id" id="u_e_id">
                <label>Event Name:</label>
                <input type="text" name="u_e_name" id="u_e_name"><br>
                <label>Event Image:</label>
                <input type="file" name="u_image" id="u_image" accept="image/png, image/gif, image/jpeg"><br>
                <button type="submit">Update Event</button>
            </form>

            <form action="actions/sign_up.php" method="POST" class="c_user" style="display:none;">
                <h3>Create User</h3>
                <label>Username:</label>
                <input type="text" name="username"><br>
                <label>Password:</label>
                <input type="password" name="password"><br>
                <label>Name:</label>
                <input type="text" name="name"><br>
                <label>Email:</label>
                <input type="text" name="email"><br>
                <button type="submit">Register</button>
            </form>
        </div>
        
        <div class="container">
            <button onclick="open_events()" class="events_button">Display events</button>
            <button onclick="open_booked_events()" class="booked_events_button user">Booked Events</button>
            <div class="events" style="display: none;">
            <h4>Events</h4>
                <?php
                for($i=$j=0;$i<$size*3;$i+=3,$j++){
                    echo '<div class="e_container disp">';
                    echo '<img src="'. $_SESSION["event_arr"][$i+2] .'" alt="" class="style_image"><br>';
                    echo '<h3>'. $_SESSION["event_arr"][$i+1] .'</h3><br>';
                    echo '  <button id="update" onclick="update_event('.$j.')" class="admin">Update Event</button><br>';
                    echo '  <form action="actions/deleteEvents.php" method="POST" class="admin">
                            <input type="hidden" name="e_id" value="'.$_SESSION["event_arr"][$i].'">
                            <button type="submit">Delete Event</button>
                            </form><br>';
                    echo '  <form action="actions/bookEvents.php" method="POST" class="user" id="book_'.$_SESSION["event_arr"][$i].'">
                            <input type="hidden" name="u_id" value="'.$_SESSION["userid"].'">
                            <input type="hidden" name="e_id" value="'.$_SESSION["event_arr"][$i].'">
                            <button type="submit" id="button_id_'.$_SESSION["event_arr"][$i].'">Book Event</button>
                            </form><br>';
                    echo '</div>';
                }
                
                ?>
            </div>
            <div class="booked_events user" style="display: none;">
            <h4>Booked Events</h4>
            <?php
                $size2 = count($_SESSION['bookedEvents']);
                for($i=0;$i<$size*3;$i+=3){
                    for($j=0;$j<$size2;$j++){
                        if($_SESSION["event_arr"][$i]==$_SESSION["bookedEvents"][$j]){
                            echo '<div class="e_container disp">';
                            echo '<img src="'. $_SESSION["event_arr"][$i+2] .'" alt="" class="style_image"><br>';
                            echo '<h3>'. $_SESSION["event_arr"][$i+1] .'</h3><br>';
                            echo '  <form action="actions/cancelEvents.php" method="POST">
                                    <input type="hidden" name="e_id" value="'.$_SESSION["event_arr"][$i].'">
                                    <button>Cancel</button>
                                    </form>';
                            echo '<script>document.querySelector(\'#book_'.$_SESSION["event_arr"][$i].'\').style.display="none";</script>';
                            echo '</div>';
                        }
                    }
                }
                
            ?>
            </div>
        </div>


        <script>
            const type = <?php echo '"'.$_SESSION["level"].'"'?>;
            if(type == "Admin"){
                var x = document.querySelectorAll('.user');
                var i;
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = 'none';
                }
            }
            else{
                var x = document.querySelectorAll('.admin');
                var i;
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = 'none';
                }
            }

            function open_c_event(){
                document.querySelector('.u_c_event').style.display = 'none';
                document.querySelector('.c_event').style.display = 'block';
                document.querySelector('.c_user').style.display = 'none';
            }

            function open_c_user(){
                document.querySelector('.u_c_event').style.display = 'none';
                document.querySelector('.c_event').style.display = 'none';
                document.querySelector('.c_user').style.display = 'block';
            }

            function open_events(){
                document.querySelector('.booked_events').style.display = 'none';
                document.querySelector('.events').style.display = 'block';
            }

            function open_booked_events(){
                document.querySelector('.events').style.display = 'none';
                document.querySelector('.booked_events').style.display = 'block';
            }

            

            function update_event(id_event){
                document.querySelector('.c_event').style.display = 'none';
                document.querySelector('.u_c_event').style.display = 'block';
                document.querySelector('.c_user').style.display = 'none';
                switch(id_event){
                    <?php 
                        for($i=$j=0;$i<$size*3;$i+=3,$j++){
                            echo 'case '.$j.':';
                            echo 'document.getElementById("u_e_id").value = "'.$_SESSION["event_arr"][$i].'";';
                            echo 'document.getElementById("u_e_name").value = "'.$_SESSION["event_arr"][$i+1].'";';
                            echo 'die();';
                            
                        }
                    ?>
                }
            }
        </script>
    </div>
</body>
</html>