<?php

    namespace App\Web\Model\DataObject;

    class TaxaObject
    {
        private int $id;
        private int $parentId;
        private string $scientificName;
        private string $authority;
        private string $rankId;
        private string $rankName;
        private string  $habitat;
        private string $genusName;
        private string $familyName;
        private string $orderName;
        private string $className;
        private string $phylumName;
        private string $kingdomName;
        private string $taxrefVersion;
        private array $links;

        public function __construct(
             int $id,
             int $parentId,
             string $scientificName,
             string $authority,
             string $rankName,
             string $habitat,
             string $genusName,
             string $rankId,
             string $familyName,
             string $orderName,
             string $className,
             string $phylumName,
             string $kingdomName,
             string $taxrefVersion,
             array $links
        ){
            $this->id = $id;
            $this->parentId = $parentId;
            $this->scientificName = $scientificName;
            $this->authority = $authority;
            $this->rankId = $rankId;
            $this->rankName = $rankName;
            $this->habitat = $habitat;
            $this->genusName = $genusName;
            $this->familyName = $familyName;
            $this->orderName = $orderName;
            $this->className = $className;
            $this->phylumName = $phylumName;
            $this->kingdomName = $kingdomName;
            $this->taxrefVersion = $taxrefVersion;
            $this->links = $links;
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

        public function getTaxrefVersion(): string
        {
            return $this->taxrefVersion;
        }

        public function setTaxrefVersion(string $taxrefVersion): void
        {
            $this->taxrefVersion = $taxrefVersion;
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
                "ID: %d\nParent ID: %d\nScientific Name: %s\nAuthority: %s\nRank ID: %s\nRank Name: %s\nHabitat: %s\nGenus Name: %s\nFamily Name: %s\nOrder Name: %s\nClass Name: %s\nPhylum Name: %s\nKingdom Name: %s\nTaxref Version: %s\nLinks: %s",
                $this->id,
                $this->parentId,
                $this->scientificName,
                $this->authority,
                $this->rankId,
                $this->rankName,
                $this->habitat,
                $this->genusName,
                $this->familyName,
                $this->orderName,
                $this->className,
                $this->phylumName,
                $this->kingdomName,
                $this->taxrefVersion,
                json_encode($this->links) // Convert the links array to JSON
            );
        }
    }