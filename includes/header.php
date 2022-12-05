<?php
    require_once("../includes/config/config.php");
    require_once("../includes/classes/PreviewProvider.php");
    require_once("../includes/classes/Account.php");
    require_once("../includes/classes/FormSanitizer.php");
    require_once("../includes/classes/CategoryContainers.php");
    require_once("../includes/classes/Entity.php");
    require_once("../includes/classes/ErrorMessage.php");
    require_once("../includes/classes/EntityProvider.php");
    require_once("../includes/classes/SeasonProvider.php");
    require_once("../includes/classes/Season.php");
    require_once("../includes/classes/Video.php");
    require_once("../includes/classes/VideoProvider.php");
    require_once("../includes/classes/User.php");
    
    if(!isset($_SESSION["userLoggedIn"])){
        header("Location: login.php");
    }

    $userLoggedIn = $_SESSION["userLoggedIn"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to ManhHuy TV !</title>
        <link rel="stylesheet" href="../assets/styles.css"/>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/520bf41886.js" crossorigin="anonymous"></script>
        <script src="../assets/js/script.js"></script>
    </head>
    <body>
        <div class="wrapper">
<?php 
    if(!isset($hideNav)){
        require_once ("../includes/navBar.php");
    }
?>