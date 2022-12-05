<?php
    require_once("../includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::showError("No ID has been passed into the page..."); // Stop executing anymore codes below this line
    }
    $entityId = $_GET["id"];
    $entity = new Entity($conn, $entityId);

    $preview = new PreviewProvider($conn, $userLoggedIn);
    echo $preview -> createPreviewVideo($entity);

    $seasonProvider = new SeasonProvider($conn, $userLoggedIn);
    echo $seasonProvider->createSeason($entity);

    $categoryContainers = new CategoryContainers($conn, $userLoggedIn) ;
    echo $categoryContainers->showCategory($entity->getCategoryId(), "You might also like...");

?>