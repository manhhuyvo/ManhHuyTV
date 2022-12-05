<?php
require_once("../includes/header.php");

$saveDetailsMessage = "";
$savePasswordMessage = "";

$account = new Account($conn);

if(isset($_POST["saveDetailsBtn"])){

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    $saveDetailsMessage = $account->updateDetails($firstName, $lastName, $email, $userLoggedIn);
}

if (isset($_POST["savePasswordBtn"])){
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];
    $newPassword2 = $_POST["newPassword2"];

    $savePasswordMessage = $account->updatePassword($userLoggedIn, $oldPassword, $newPassword, $newPassword2);
}

?>
<div class="setting-container column">
    <div class="form-section">
        <form method="POST" action="../pages/profile.php">
            <h2>User Details</h2>
            <?php
                $user = new User($conn, $userLoggedIn);
                if(isset($_POST["firstName"])){
                    $firstName = $_POST["firstName"];
                } else {
                    $firstName= $user->getFirstName();
                }

                if(isset($_POST["lastName"])){
                    $lastName = $_POST["lastName"];
                } else {
                    $lastName= $user->getLastName();
                }

                if(isset($_POST["email"])){
                    $email = $_POST["email"];
                } else {
                    $email= $user->getEmail();
                }
            ?>
            <input type="text" name="firstName" placeholder="First Name..." value="<?php echo $firstName;?>" required>
            <input type="text" name="lastName" placeholder="Last Name..." value="<?php echo $lastName;?>" required>
            <input type="email" name="email" placeholder="Email Address..." value="<?php echo $email;?>" required>
            
            <input type="submit" name="saveDetailsBtn" value="UPDATE">
            <?php 
                if($saveDetailsMessage != ""){
                    echo "<p class='update-message'>$saveDetailsMessage</p>";
                }
            ?>
        </form>
    </div>

    <div class="form-section second-form">
        <form method="POST">
            <h2>Update Your Password</h2>
            <input type="password" name="oldPassword" placeholder="Current Password..." required>
            <input type="password" name="newPassword" placeholder="New Password..." required>
            <input type="password" name="newPassword2" placeholder="Confirm New Password..." required>

            <input type="submit" name="savePasswordBtn" value="UPDATE">

            <?php 
                if($savePasswordMessage != ""){
                    echo "<p class='update-message'>$savePasswordMessage</p>";
                }
            ?>
        </form>
    </div>
</div>