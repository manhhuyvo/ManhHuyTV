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
                    <h3>SIGN IN NOW</h3>
                    <p>to watch awesome movie!</p>
                </div>
                <form class="signin-form" method="POST" action="../backend/loginBackend.php">
                    <input type="text" name="username" placeholder="Username..." value="<?php if(isset($_SESSION['rememberUsername'])){echo $_SESSION['rememberUsername'];}?>"/>
                    <input type="password" name="password" placeholder="Password..."/>
                    <?php
                        if (isset($_SESSION["authenticationMessage"])){
                            echo "<p class='minor-error-message'>".$_SESSION["authenticationMessage"]."</p>";
                        }
                    ?>
                    <input type="submit" name="submitButton" value="SUBMIT"/>
                </form>
                <p class="signin-message">Dont have an account yet? <a href="register.php">Sign up here!</a></p>
            </div>
        </div>
    </body>
</html>