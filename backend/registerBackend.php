<?php
    
    require_once("../includes/classes/FormSanitizer.php");
    require_once("../includes/config/config.php");
    require_once("../includes/classes/Account.php");

    if (isset($_POST["submitButton"])){

        // Assign all the values POST from server to respectively variables
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);

        $account = new Account($conn); // Create new object of Account class

        // Call all the function of $account object
        $emailMessage = $account->checkMatchEmail($email, $email2);
        $passwordMessage = $account->checkMatchPassword($password, $password2);
        $usernameMessage = $account->checkExistUsername($username);

        // Check and display any validation error messages
        $account->checkAndDisplayErrorMessage($emailMessage, $passwordMessage, $usernameMessage);

        // implement insert data if there is no validation errors exist
        if (!isset($_SESSION["emailErrorMessage"]) && !isset($_SESSION["passwordErrorMessage"]) && !isset($_SESSION["usernameMessage"]))
        {
            $registerMessage = $account->insertUserDetails($firstName, $lastName, $username, $email, $password);
            if($registerMessage == "Values inserted successfully"){
                $_SESSION["userLoggedIn"] = $username;
                header("Location: ../pages/index.php");
            }
        } else {
            // Redirect to the register page if any error exists
            header("Location: ../pages/register.php");
        }

    }

?>