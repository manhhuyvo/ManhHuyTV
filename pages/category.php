<?php
    
    require_once("../includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::showError("No id passed to this URL...");
    }

    $preview = new PreviewProvider($conn, $userLoggedIn);
    echo $preview->createCategoryPreviewVideo($_GET["id"]);
    
    $preview = new CategoryContainers($conn, $userLoggedIn);
    echo $preview->showCategory($_GET["id"]);
?>

<!-- The main HTML code go below here -->

<?php 
    require_once("../includes/footer.php");
?>