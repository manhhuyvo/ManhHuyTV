<?php

require_once("../includes/config/config.php");
if(isset($_POST["videoId"]) && isset($_POST["username"])){
    $videoId = $_POST["videoId"];
    $username = $_POST["username"];

    // Check if user has watched this video before
    $sql1 = "SELECT * FROM videoProgress WHERE videoId = $videoId AND username = '$username'";
    $result1 = mysqli_query($conn, $sql1);

    if(mysqli_num_rows($result1) == 0){ // If this is the first time user watches this video
        $sql2 = "INSERT INTO videoprogress (username, videoId)
                VALUES ('$username', $videoId)";
        $result2 = mysqli_query($conn, $sql2);     
    }
} else {
    echo "No video ID or username have been added to the file";
}

?>