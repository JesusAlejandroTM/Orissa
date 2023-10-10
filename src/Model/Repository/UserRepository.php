<?php

    namespace App\Web\Model\Repository;

    use App\Web\Model\DataObject\User;

    class UserRepository
    {
        public static function Construire(array $userArray): User
        {
            return new User(
                $userArray['id'],
                $userArray['mail'],
                $userArray['username'],
                $userArray['password'],
                $userArray['role'],
                $userArray['surname'],
                $userArray['name'],
            );
        }
    }