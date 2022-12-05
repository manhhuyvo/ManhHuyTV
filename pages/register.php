<?php
    require_once("../includes/config/config.php");
    /* Check if SESSION username exist, then navigate to the index page*/
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to ManhHuy TV !</title>
        <link rel="stylesheet" href="../assets/styles.css"/>
    </head>
    <body>
        <div class="signin-container">
            <div class="column">
                <div class="signin-logo-container">
                    <img src="../assets/images/logo.png">
                </div>
                <div class="signin-title-container">
                    <h3>SIGN UP NOW</h3>
                    <p>to continue to ManhHuyTV!</p>
                </div>
                <form class="signin-form" method="POST" action="../backend/registerBackend.php">
                    <input type="text" name="firstName" placeholder="First Name..."/>
                    <input type="text" name="lastName" placeholder="Last Name..."/>
                    <input type="text" name="username" placeholder="Username..."/>
                    <?php
                        if (isset($_SESSION["usernameMessage"])){
                            echo "<p class='minor-error-message'>".$_SESSION["usernameMessage"]."</p>";
                        }
                    ?>
                    <input type="email" name="email" placeholder="Email..."/>
                    <?php
                        if (isset($_SESSION["emailErrorMessage"])){
                            echo "<p class='minor-error-message'>".$_SESSION["emailErrorMessage"]."</p>";
                        }
                    ?>
                    <input type="email" name="email2" placeholder="Confirm Email..."/>
                    <input type="password" name="password" placeholder="Password..."/>
                    <?php
                        if (isset($_SESSION["passwordErrorMessage"])){
                            echo "<p class='minor-error-message'>".$_SESSION["passwordErrorMessage"]."</p>";
                        }
                    ?>
                    <input type="password" name="password2" placeholder="Confirm Password..."/>
                    <input type="submit" name="submitButton" value="SUBMIT"/>
                </form>
                <p class="signin-message">Already have an account? <a href="login.php">Sign in now!</a></p>
            </div>
        </div>
    </body>
</html>