<?php

require_once("../includes/config/config.php");
if(isset($_POST["videoId"]) && isset($_POST["username"])){
    $videoId = $_POST["videoId"];
    $username = $_POST["username"];

    // Get the progress of the current video and echo it as the data
    $sql = "SELECT * FROM videoprogress WHERE videoId = $videoId AND username = '$username'";
    $result = mysqli_query($conn, $sql);

    $progressColumn = null;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $progressColumn = $row["progress"];
        }
        echo $progressColumn;
    } else {
        echo "Something is wrong!!";
    }
    
} else {
    echo "No video ID or username have been added to the file";
}

?>