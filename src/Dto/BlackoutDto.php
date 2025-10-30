<?php

namespace App\Dto;

use App\Entity\Blackout;
use DateTimeInterface;
class BlackoutDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $start_date,
        public readonly ?string $end_date,
        public readonly string $description,
        public readonly string $type,
        public readonly string $source,
        /** @var BuildingDto[] */
        public readonly array $buildings,
    ) {}

    public static function fromEntity(Blackout $blackout): self
    {
        $buildings = [];
        foreach ($blackout->getBuilding() as $building) {
            $buildings[] = BuildingDto::fromEntity($building);
        }

        return new self(
            id: $blackout->getId(),
            start_date: $blackout->getStartDate()->format('Y-m-d H:i:s'),
            end_date: $blackout->getEndDate()?->format('Y-m-d H:i:s'),
            description: $blackout->getDescription(),
            type: $blackout->getType()?->value ?? 'unknown',
            source: $blackout->getSource(),
            buildings: $buildings,
        );
    }
}
