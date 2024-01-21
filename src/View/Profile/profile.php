<?php
    include_once 'userData.php';

    $userId = $GLOBALS['userId'];
    $username = $GLOBALS['username'];
    $userMail = $GLOBALS['userMail'];
    $role = $GLOBALS['userRole'];
    $birthDate = $GLOBALS['userBirthDate'];
    $userSurname = $GLOBALS['userSurname'];
    $userFamilyName = $GLOBALS['userFamilyName'];
    $userPhoneNumber = $GLOBALS['userPhoneNumber'];
    $dateTime = $GLOBALS['dateCreated'];
    $dateCreated = date('Y-m-d', strtotime($dateTime));
    ?>
<div class="banner-div">
    <div class="banner-image"></div>
</div>
<main class="mainContainer">
    <div id="detail-profil">
        <div class="username">Nom d'utilisateur : <?php echo $username ?></div>
        <div class="mail">Mail : <?php echo $userMail ?></div>
        <div class="familyName">Nom : <?php echo $userFamilyName ?></div>
        <div class="name">Prénom : <?php echo $userSurname ?></div>
        <div class="role">Rôle : <?php echo $role ?></div>
        <div class="userIdentifier">Identifiant : <?php echo $userId ?></div>
        <div class="dates">Date de naissance : <?php echo $dateCreated ?></div>
        <div class="dates">Date de création : <?php echo $birthDate ?></div>
        <button onclick="window.location.href='Profile/Settings';" id="edit-profile-button">
            Modifier le profil
        </button>
        <div class="logout-section">
            <button onclick="window.location.href='Profile/Disconnect';" class="logout-button">
                <span class="logout">Déconnecter</span>
            </button>
        </div>
        <div class="delete-section">
            <button onclick="window.location.href='Profile/DeleteAccount';" class="delete-button">
                <span class="delete">SUPPRIMER VOTRE COMPTE</span>
            </button>
        </div>
    </div>
    <div class="content-section">
        <div class="nav-barre">
            <a href="" class="nav-link nav-Naturothèques">Mes naturotheques</a>
            <a href="" class="nav-link nav-Register">Register</a>
            <a href="" class="nav-link nav-Creation">Creation de naturotheques</a>
        </div>
        <div class="list-grid">
            <div class="libraryUnit">
                <div class="imageSpace">
                    <div class="backgroundLock">
                        <div class="boutonLock">
                            <div id="img"></div>
                        </div>
                    </div>
                </div>
                <div class="name-library">
                    <span class="innerName">12345678 9012345 6789012 345678 9012345 67890123 4567890</span>
                </div>
            </div>
        </div>
    </div>
</main>
