<?php

require_once("../includes/config/config.php");
if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])){
    $videoId = $_POST["videoId"];
    $username = $_POST["username"];
    $progress = $_POST["progress"];

    // Check if user has watched this video before
    $sql = "UPDATE videoprogress SET progress = $progress,
            dateModified =NOW() WHERE username= '$username' AND videoId = $videoId";
    $result = mysqli_query($conn, $sql);
    
} else {
    echo "No video ID or username have been added to the file";
}

?>