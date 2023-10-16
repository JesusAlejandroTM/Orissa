<?php

    namespace App\Code\Model\DataObject;

    class User
    {
        private ?int $id;
        private string $mail;
        private string $username;
        private string $password;
        private ?string $role;

        public function __construct(
            string  $mail,
            string  $username,
            string  $password,
            ?int    $id = null,
            ?string $role = null,
        )
        {
            $this->mail = $mail;
            $this->username = $username;
            $this->password = $password;
            $this->id = $id;
            $this->role = $role;
        }

        public function __toString(): string
        {
            if (is_null($this->id)) {
                return "
                Mail: $this->mail ; 
                Username: $this->username ;
                Role: $this->role ; ";
            } else {
                return "
                ID: $this->id ;
                Mail: $this->mail ; 
                Username: $this->username ;
                Role: $this->role ; ";
            }
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
    }