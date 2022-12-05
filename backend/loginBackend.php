<?php
    
    require_once("../includes/classes/FormSanitizer.php");
    require_once("../includes/config/config.php");
    require_once("../includes/classes/Account.php");

    if (isset($_POST["submitButton"])){

        getInputValue("username");

        // Assign all the values POST from server to respectively variablesx
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        $account = new Account($conn); // Create new object of Account class

        // Check the user's input with the database
        $signinMessage = $account->checkUserDetails($username, $password);
        
        // Check the sign in message and navigate the website accordingly
        if($signinMessage != "Login successfully"){ // Not successful
            $_SESSION["authenticationMessage"] = $signinMessage;
            header("Location: ../pages/login.php");
        } else { // Log in successful
            if (isset($_SESSION["authenticationMessage"])){
                unset($_SESSION["authenticationMessage"]);
            }
            $_SESSION["userLoggedIn"] = $username;
            header("Location: ../pages/index.php");
        }

    }

    function getInputValue($name){
        if(isset($_POST[$name])){
            $_SESSION["rememberUsername"] = $_POST[$name];
        }
    }

?>