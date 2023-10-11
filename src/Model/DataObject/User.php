<?php

    namespace App\Web\Model\DataObject;

    use DateTime;

    class User
    {
        private ?int $id;
        private string $mail;
        private string $username;
        private string $password;
        private ?string $role;
        private ?DateTime $created_at;
        private ?string $surname;
        private ?string $name;
        private ?string $domain;
        private ?bool $verify;
        private ?bool $accepted_tos;

        public function __construct(
            string    $mail,
            string    $username,
            string    $password,
            ?int      $id = null,
            ?string   $role = null,
            ?DateTime $created_at = null,
            ?string   $surname = null,
            ?string   $name = null,
            ?string   $domain = null,
            ?bool     $verify = null,
            ?bool     $accepted_tos = null,
        )
        {
            $this->mail = $mail;
            $this->username = $username;
            $this->password = $password;
            $this->id = $id;
            $this->role = $role;
            $this->created_at = $created_at;
            $this->surname = $surname;
            $this->name = $name;
            $this->domain = $domain;
            $this->verify = $verify;
            $this->accepted_tos = $accepted_tos;
        }

        public function __toString(): string
        {
            return "
        ID: $this->id ;
        Mail: $this->mail ; 
        Username: $this->username ;
        Password: $this->password ;
        Accepted TOS: " . ($this->accepted_tos ? 'Yes' : 'No') . " ; 
        Role: $this->role ; 
        Created At: " . ($this->created_at ? $this->created_at->format('Y-m-d H:i:s') : 'N/A') . " ;
        Surname: $this->surname ; 
        Name: $this->name ; 
        Domain: $this->domain ; 
        Verify: " . ($this->verify ? 'Yes' : 'No');
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

        public function getAcceptedTos(): ?bool
        {
            return $this->accepted_tos;
        }

        public function setAcceptedTos(?bool $accepted_tos): void
        {
            $this->accepted_tos = $accepted_tos;
        }

        public function getCreatedAt(): ?DateTime
        {
            return $this->created_at;
        }

        public function setCreatedAt(?DateTime $created_at): void
        {
            $this->created_at = $created_at;
        }

        public function getDomain(): ?string
        {
            return $this->domain;
        }

        public function setDomain(?string $domain): void
        {
            $this->domain = $domain;
        }

        public function getVerify(): ?bool
        {
            return $this->verify;
        }

        public function setVerify(?bool $verify): void
        {
            $this->verify = $verify;
        }
    }