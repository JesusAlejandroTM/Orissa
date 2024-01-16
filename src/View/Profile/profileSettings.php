<?php
    include_once 'userData.php';
    $userId = $GLOBALS['userId'];
    $username = $GLOBALS['username'];
    $userMail = $GLOBALS['userMail'];
    $userRole = $GLOBALS['userRole'];
    $userBirthDate = $GLOBALS['userBirthDate'];
    $userSurname = $GLOBALS['userSurname'];
    $userFamilyName = $GLOBALS['userFamilyName'];
    $userPhoneNumber = $GLOBALS['userPhoneNumber'];
    $userDomain = $GLOBALS['userDomain'];
    ?>

<form method="GET" action="Profile/Update">
    <fieldset>
        <legend>Your Profile Settings</legend>
        <p>Your ID : <?php echo $userId ?></p>
        <p>Your role : <?php echo $userRole ?></p>
        <input type="hidden" value="<?php echo $userId ?>" name="user_id">
        <p>
            <label for="username_id">Username :</label>
            <input type="text" value="<?php echo $username ?>" name="username" id="username_id"/>
        </p>
        <p>
            <label for="mail_id">Mail :</label>
            <input type="email" value="<?php echo $userMail ?>" name="email" id="mail_id"/>
        </p>
        <p>
            <label for="birthdate_id">Birthdate :</label>
            <input type="date"  value="<?php echo $userBirthDate ?>" name="birthdate" id="birthdate_id"/>
        </p>
        <p>
            <label for="surname_id">Surname :</label>
            <input type="text" placeholder="<?php echo $userSurname ?>" name="surname" id="surname_id"/>
        </p>
        <p>
            <label for="familyName_id">Family name :</label>
            <input type="text" placeholder="<?php echo $userFamilyName ?>" name="familyName" id="familyName_id"/>
        </p>
        <p>
            <label for="phoneNumber_id">Phone number :</label>
            <input type="number" placeholder="<?php echo $userPhoneNumber ?>" name="phoneNumber" id="phoneNumber_id"/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>
<p><a href="Profile">Return</a></p>
