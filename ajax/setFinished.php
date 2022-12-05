<?php

require_once("../includes/config/config.php");
if(isset($_POST["videoId"]) && isset($_POST["username"])){
    $videoId = $_POST["videoId"];
    $username = $_POST["username"];

    // Check if user has watched this video before
    $sql = "UPDATE videoprogress SET finished = 1, progress = 0,
            dateModified =NOW() WHERE username= '$username' AND videoId = videoId";
    $result = mysqli_query($conn, $sql);
    
} else {
    echo "No video ID or username have been added to the file";
}

?>