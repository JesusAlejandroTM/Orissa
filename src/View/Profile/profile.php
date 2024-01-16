<h1 class="profileTitle">Votre profil</h1>
<?php
    include_once 'userData.php';

    echo '<p>Your ID : ' . $GLOBALS['userId'] . ' </p>';
    echo '<p>Your Username : ' . $GLOBALS['username'] . ' </p>';
    echo '<p>Your Mail : ' . $GLOBALS['userMail'] . ' </p>';
    echo '<p>Your Role : ' . $GLOBALS['userRole'] . ' </p>';
    echo '<p>Your Birthdate : ' . $GLOBALS['userBirthDate'] . ' </p>';
    echo '<p>Your Surname : ' . $GLOBALS['userSurname'] . ' </p>';
    echo '<p>Your Family Name : ' . $GLOBALS['userFamilyName'] . ' </p>';
    echo '<p>Your Phone Number : ' . $GLOBALS['userPhoneNumber'] . ' </p>';
    echo '<p>Your Domain : ' . $GLOBALS['userDomain'] . ' </p>';
    ?>
<p><a href="Profile/Disconnect">Disconnect</a></p>
<p><a href="Profile/Settings">Settings</a></p>
<p><a href="Profile/Password">Change password</a></p>
