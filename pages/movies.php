<?php
    
    require_once("../includes/header.php");

    $preview = new PreviewProvider($conn, $userLoggedIn);
    echo $preview->createMoviePreviewVideo();
    
    $preview = new CategoryContainers($conn, $userLoggedIn);
    echo $preview->showMovieCategory();
?>

<!-- The main HTML code go below here -->

<?php 
    require_once("../includes/footer.php");
?>