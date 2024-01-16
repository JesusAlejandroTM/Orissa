<?php
    include_once 'userData.php';
    $userId = $GLOBALS['userId'];
    $userRole = $GLOBALS['userRole'];
    ?>

<form method="GET" action="Profile/UpdatePassword">
    <fieldset>
        <legend>Your Password Settings</legend>
        <p>Your ID : <?php echo $userId ?></p>
        <p>Your role : <?php echo $userRole ?></p>
        <input type="hidden" value="<?php echo $userId ?>" name="user_id">
        <p>
            <label for="password_id">Old password :</label>
            <input type="password" placeholder="Your old password" name="oldPassword" id="password_id" required/>
        </p>
        <p>
            <label for="newPassword_id">New password :</label>
            <input type="password" placeholder="Your new password" name="newPassword" id="newPassword_id" required/>
        </p>
        <p>
            <label for="newPasswordCheck_id">Check new password :</label>
            <input type="password"  placeholder="Check new password" name="newPasswordCheck" id="newPasswordCheck_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<p><a href="Profile">Return</a></p>
