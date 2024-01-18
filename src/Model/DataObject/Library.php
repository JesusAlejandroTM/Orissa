<?php

    namespace App\Code\Model\DataObject;

    class Library extends AbstractDataObject
    {
        public function __construct(
            private ?int     $id,
            private int    $idUser,
            private string $title,
            private string $description,
        )
        {
        }

        public function formatTableau(): array
        {
            return [
                'id_libTag' => $this->getId(),
                'id_creatorTag' => $this->getIdUser(),
                'titleTag' => $this->getTitle(),
                'descriptionTag' => $this->getDescription(),
            ];
        }

        public function getPrimaryKeyValue(): int
        {
            return $this->getId();
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getIdUser(): int
        {
            return $this->idUser;
        }

        public function setIdUser(int $idUser): void
        {
            $this->idUser = $idUser;
        }

        public function getTitle(): string
        {
            return $this->title;
        }

        public function setTitle(string $title): void
        {
            $this->title = $title;
        }

        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription(string $description): void
        {
            $this->description = $description;
        }
    }