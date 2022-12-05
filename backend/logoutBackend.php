<?php
    require_once("../includes/config/config.php");

    session_start();
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
?>