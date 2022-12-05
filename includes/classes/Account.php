<?php

class Account {
    
    private $conn;

    //Create a constructor
    public function __construct($con){
        $this -> conn = $con; // Assign the $con variable that we get from the constructor to the variable $conn of the class
    }

    // Check if the username entered has existed in the database
    public function checkExistUsername ($username){
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($result) > 0){
            return "This username has existed.";
        } else {
            return "Username eligible";
        }
    }

    // Check if the email and confirm email matches with each other
    public function checkMatchEmail ($email, $email2){
        if ($email == $email2){
            return "Email Matched";
        } else {
            return "Your email confirm doesn't match.";
        }
    }

    // Check if the password and confirm password matches with each other
    public function checkMatchPassword ($password, $password2){
        if ($password == $password2){
            return "Password Matched";
        } else {
            return "Your password confirm doesn't match.";
        }
    }

    // Check and display any errors message if exist
    public function checkAndDisplayErrorMessage($emMess, $pwMess, $unMess){
        if($emMess != "Email Matched"){
            $_SESSION["emailErrorMessage"] = $emMess;
        } else { // Email matched
            if(isset($_SESSION["emailErrorMessage"])){
                unset($_SESSION["emailErrorMessage"]); // Unset the email error message if it was set last try
            }
        }

        if($pwMess != "Password Matched"){
            $_SESSION["passwordErrorMessage"] = $pwMess;
        } else { // Password matched
            if(isset($_SESSION["passwordErrorMessage"])){
                unset($_SESSION["passwordErrorMessage"]); // Unset the password error message if it was set last try
            }
        }

        if($unMess != "Username eligible"){
            $_SESSION["usernameMessage"] = $unMess;
        } else { // Username didn't exist
            if(isset($_SESSION["usernameMessage"])){
                unset($_SESSION["usernameMessage"]); // Unset the username error message if it was set last try
            }
        }
    }

    // Run the query to insert the data to the database
    public function insertUserDetails($fn, $ln, $un, $em, $pw){
        $pw = hash("sha512", $pw); // Hash the password and store to the current $pw

        $sql = "INSERT INTO users (firstName, lastName, username, email, password)
                VALUES ('$fn', '$ln', '$un', '$em', '$pw')";
        $query = mysqli_query($this->conn, $sql); 
        if ($query){
            return "Values inserted successfully";
        } else {
            return "User registration unsuccessful.";
        }
    }

    // Sign in function validation
    public function checkUserDetails($un,$pw){
        $pw = hash("sha512", $pw);

        $sql = "SELECT * FROM users WHERE username = '$un' AND password = '$pw'";
        $result = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($result) > 0){
            return "Login successfully";
        } else {
            return "Wrong username and password combination.";
        }
    }

    // Update the user's details
    public function updateDetails ($fn, $ln, $em, $un){
        $sql = "UPDATE users SET firstName = '$fn', lastName = '$ln', email = '$em' WHERE username = '$un'";
        $query = mysqli_query($this->conn, $sql);

        if($query) {
            return "Details have been updated successfully.";
        } else {
            return "Details couldn't be updated.";
        }
    }

    public function updatePassword ($un, $pw, $pw1, $pw2) {
        $loginMessage = $this->checkUserDetails($un, $pw);
        if($loginMessage == "Login successfully"){
            $passwordMatch = $this->checkMatchPassword($pw1, $pw2);
            if($passwordMatch == "Password Matched"){
                $newPw = hash("sha512", $pw1);
                $sql = "UPDATE users SET password = '$newPw' WHERE username = '$un'";
                $query = mysqli_query($this->conn, $sql);
                if($query){
                    return "Your new password has been updated successfully.";
                } else {
                    return "Unable to update new password. Please try again later.";
                }
            } else {
                return "Your new password and password confirmation doesn't match. Please try again.";
            }
        } else {
            return "Your current password is not correct. Please try again.";
        }
        
    }
}

?>