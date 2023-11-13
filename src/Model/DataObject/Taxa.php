<?php

    namespace App\Code\Model\DataObject;

    class Taxa
    {
        public static array $dataFilterArray = ["id", "parentId", "scientificName",
            "authority", "rankId", "rankName", "frenchVernacularName", "habitat", "genusName", "familyName",
            "orderName", "className", "phylumName", "kingdomName", "taxrefVersion", "_links",
            ];

        public function __construct(
            private int     $id,
            private ?int    $parentId = null,
            private ?string $scientificName = null,
            private ?string $authority = null,
            private ?string $rankId = null,
            private ?string $rankName = null,
            private ?string $vernacularName = null,
            private ?string $genusName = null,
            private ?string $familyName = null,
            private ?string $orderName = null,
            private ?string $className = null,
            private ?string $phylumName = null,
            private ?string $kingdomName = null,
            private ?string $habitat = null,
            private ?string $taxRefVersion = null,
            private ?array  $links = null
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

        public function getParentId(): int
        {
            return $this->parentId;
        }

        public function setParentId(int $parentId): void
        {
            $this->parentId = $parentId;
        }

        public function getScientificName(): string
        {
            return $this->scientificName;
        }

        public function setScientificName(string $scientificName): void
        {
            $this->scientificName = $scientificName;
        }

        public function getVernacularName(): ?string
        {
            return $this->vernacularName;
        }

        public function setVernacularName(?string $vernacularName): void
        {
            $this->vernacularName = $vernacularName;
        }

        public function getAuthority(): string
        {
            return $this->authority;
        }

        public function setAuthority(string $authority): void
        {
            $this->authority = $authority;
        }

        public function getRankName(): string
        {
            return $this->rankName;
        }

        public function setRankName(string $rankName): void
        {
            $this->rankName = $rankName;
        }

        public function getHabitat(): string
        {
            return $this->habitat;
        }

        public function setHabitat(string $habitat): void
        {
            $this->habitat = $habitat;
        }

        public function getGenusName(): string
        {
            return $this->genusName;
        }

        public function setGenusName(string $genusName): void
        {
            $this->genusName = $genusName;
        }

        public function getFamilyName(): string
        {
            return $this->familyName;
        }

        public function setFamilyName(string $familyName): void
        {
            $this->familyName = $familyName;
        }

        public function getOrderName(): string
        {
            return $this->orderName;
        }

        public function setOrderName(string $orderName): void
        {
            $this->orderName = $orderName;
        }

        public function getClassName(): string
        {
            return $this->className;
        }

        public function setClassName(string $className): void
        {
            $this->className = $className;
        }

        public function getPhylumName(): string
        {
            return $this->phylumName;
        }

        public function setPhylumName(string $phylumName): void
        {
            $this->phylumName = $phylumName;
        }

        public function getKingdomName(): string
        {
            return $this->kingdomName;
        }

        public function setKingdomName(string $kingdomName): void
        {
            $this->kingdomName = $kingdomName;
        }

        public function getLinks(): array
        {
            return $this->links;
        }

        public function setLinks(array $links): void
        {
            $this->links = $links;
        }

        public function getTaxRefVersion(): string
        {
            return $this->taxRefVersion;
        }

        public function setTaxRefVersion(string $taxRefVersion): void
        {
            $this->taxRefVersion = $taxRefVersion;
        }

        public function getRankId(): string
        {
            return $this->rankId;
        }

        public function setRankId(string $rankId): void
        {
            $this->$rankId = $rankId;
        }

        public function __toString(): string
        {
            return sprintf(
                "ID: %d\n; Scientific Name: %s\n; Authority: %s\n; Habitat: %s\n; Kingdom Name: %s",
                $this->id,
                $this->scientificName,
                $this->authority,
                $this->habitat,
                $this->kingdomName,
            );
        }
    }