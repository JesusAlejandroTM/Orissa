<?php
    use App\Code\Model\DataObject\User;
    use App\Code\Model\Repository\UserRepository;

    /** @var User $userObject */
    global $userId, $username, $userMail, $userRole, $userBirthDate,
           $userSurname, $userFamilyName, $userPhoneNumber, $userDomain;

    $userObject = $GLOBALS['userObject'];
    $userId = $userObject->getId();
    $username = $userObject->getUsername();
    $userMail = $userObject->getMail();
    $userRole = $userObject->getRole();
    $userBirthDate = $userObject->getBirthDateString();

    $userExtraData = UserRepository::GetUserExtraInfo($userId);

    $userSurname = $userExtraData['surname'];
    if (is_null($userSurname)) $userSurname = 'Unknown';

    $userFamilyName = $userExtraData['name'];
    if (is_null($userFamilyName)) $userFamilyName = 'Unknown';

    $userPhoneNumber = $userExtraData['phoneNumber'];
    if (is_null($userPhoneNumber)) $userPhoneNumber = 'Unknown';

    $userDomain = $userExtraData['domain'];