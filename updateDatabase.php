<?php

session_start();

if(array_key_exists("content", $_POST)){

    //this is your connection string of course this is going to be different for you
    $link = mysqli_connect("localhost", /*YOUR DB USER*/, /*DB PASSWORD*/, /*NAME OF DB*/);
    if (mysqli_connect_error()) {
        die("There was a problem while connecting to database.");
    }

    $query = "UPDATE `users`
              SET `diary` = '".mysqli_real_escape_string($link, $_POST['content'])."'
              WHERE `id` = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
    mysqli_query($link, $query);
}

?>
