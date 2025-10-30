<?php

namespace App\Dto;

use App\Entity\Building;
class BuildingDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $number,
        public readonly ?string $street,
        public readonly ?string $city,
        public readonly ?string $coordinates,
        public readonly ?string $organization,
        public readonly ?string $type,
    ) {}

    public static function fromEntity(Building $building): self
    {
        return new self(
            id: $building->getId(),
            number: $building->getNumber(),
            street: $building->getStreet()?->getName(),
            city: $building->getCity()?->getName(),
            coordinates: $building->getCoordinates(),
            organization: $building->getOrganization()?->getName(),
            type: $building->getType(),
        );
    }
}
