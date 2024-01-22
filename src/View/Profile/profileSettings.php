<div class="setting">
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

    <div class="form">
        <form method="GET" action="Profile/UpdateInfo">
            <fieldset>
                <legend>Editer votre profil</legend>
                <p>Votre identifiant : <?php echo $userId ?></p>
                <p>Votre rôle : <?php echo $userRole ?></p>
                <input type="hidden" value="<?php echo $userId ?>" name="user_id">
                <div class="textbox">
                    <label for="username_id">Nom d'utilisateur :</label>
                    <input type="text" value="<?php echo $username ?>" name="username" id="username_id" />
                </div>
                <div class="textbox">
                    <label for="mail_id">Adresse mail :</label>
                    <input type="email" value="<?php echo $userMail ?>" name="email" id="mail_id" />
                </div>
                <div class="textbox">
                    <label for="birthdate_id">Date de naissance :</label>
                    <input type="date" value="<?php echo $userBirthDate ?>" name="birthdate" id="birthdate_id" />
                </div>
                <div class="textbox">
                    <label for="surname_id">Prénom :</label>
                    <input type="text" placeholder="<?php echo $userSurname ?>" name="surname" id="surname_id" />
                </div>
                <div class="textbox">
                    <label for="familyName_id">Nom :</label>
                    <input type="text" placeholder="<?php echo $userFamilyName ?>" name="familyName" id="familyName_id" />
                </div>
                <div class="textbox">
                    <label for="phoneNumber_id">Numéro de téléphone :</label>
                    <input type="number" placeholder="<?php echo $userPhoneNumber ?>" name="phoneNumber" id="phoneNumber_id" />
                </div>
                <div class="textbox">
                    <label>Mot de passe :</label>

                    <input type="password" id="password" name="password" required>

                </div>
                <p>
                    <input type="submit" value="Envoyer" />
                </p>
            </fieldset>
        </form>
    </div>

    <p><a href="Profile" b class="btn-retour">Return</a></p>

</div>