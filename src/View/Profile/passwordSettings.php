<div class="setting">
    <?php
        include_once 'userData.php';
        $userId = $GLOBALS['userId'];
        $userRole = $GLOBALS['userRole'];
        ?>

    <form method="GET" action="Profile/UpdatePassword">
        <fieldset>
            <legend>Modifier votre mot de passee</legend>
            <p>Votre identifiant : <?php echo $userId ?></p>
            <p>Votre rôle : <?php echo $userRole ?></p>
            <input type="hidden" value="<?php echo $userId ?>" name="user_id">
            <div class="textbox">
                <label for="password_id">Ancien mot de passe :</label>
                <input type="password" placeholder="Ancien mot de passe" name="oldPassword" id="password_id" required/>
            </div>
            <div class="textbox">
                <label for="newPassword_id">Nouveau mot de passe :</label>
                <input type="password" placeholder="Nouveau mot de passe" name="newPassword" id="newPassword_id" required/>
            </div>
            <div class="textbox">
                <label for="newPasswordCheck_id">Vérifier nouveau mot de passe :</label>
                <input type="password"  placeholder="Nouveau mot de passe" name="newPasswordCheck" id="newPasswordCheck_id" required/>
            </div>
            <p>
                <input type="submit" value="Envoyer"/>
            </p>
        </fieldset>
    </form>
    <p><a href="Profile">Retour</a></p>
</div>