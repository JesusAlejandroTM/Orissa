<?php

    namespace App\Web\Model\DataObject;
    class User
    {
        public function __construct(
            private int     $id,
            private ?string $mail,
            private ?string $username,
            private ?string $password,
            private ?string $role,
            private ?string $surname,
            private ?string $name
        )
        {
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getMail(): string
        {
            return $this->mail;
        }

        public function setMail(string $mail): void
        {
            $this->mail = $mail;
        }

        public function getUsername(): string
        {
            return $this->username;
        }

        public function setUsername(string $username): void
        {
            $this->username = $username;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        public function getRole(): string
        {
            return $this->role;
        }

        public function setRole(string $role): void
        {
            $this->role = $role;
        }

        public function getSurname(): string
        {
            return $this->surname;
        }

        public function setSurname(string $surname): void
        {
            $this->surname = $surname;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function setName(string $name): void
        {
            $this->name = $name;
        }
    }