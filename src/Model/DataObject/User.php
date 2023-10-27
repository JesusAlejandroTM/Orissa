<?php

    namespace App\Code\Model\DataObject;

    use DateTime;

    class User
    {
        private ?int $id;
        private string $mail;
        private string $username;
        private string $password;
        private DateTime $birthDate;

        private ?string $role;

        public function __construct(
            ?int $id,
            string  $mail,
            string  $username,
            string  $password,
            string $birthDate,
            ?string $role = null,
        )
        {
            $this->id = $id;
            $this->mail = $mail;
            $this->username = $username;
            $this->birthDate = new DateTime($birthDate);
            $this->password = $password;
            $this->role = $role;
        }

        public function __toString(): string
        {
            if (is_null($this->id)) {
                return "Client{
                Mail='$this->mail',  
                Username='$this->username', 
                Password='$this->password', 
                Birthdate='" . $this->getBirthDateString() . "',
                Role='$this->role'}";
            } else {
                return "
                ID: $this->id ;
                Username='$this->username', 
                Password='$this->password', 
                Birthdate='" . $this->getBirthDateString() . "',
                Role='$this->role'}";
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

        public function getBirthDate() : DateTime
        {
            return $this->birthDate;
        }

        public function getBirthDateString() : String
        {
            return date_format($this->birthDate, 'Y/m/d');
        }


        public function setBirthDate(String $birthDate): void
        {
            $this->birthDate = new DateTime($birthDate);
        }
    }