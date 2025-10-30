<?php

namespace App\Dto;

use DateTime;
class BlackoutCreateDto
{
    public function __construct(
        public string $type,
        public DateTime $startDate,
        public ?DateTime $endDate,
        public string $description,
        public string $source,
        public array $buildings = [] // массив координат ['lat' => ..., 'lng' => ...]
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            startDate: new DateTime($data['start_date']),
            endDate: isset($data['end_date']) ? new DateTime($data['end_date']) : null,
            description: $data['description'],
            source: $data['source'],
            buildings: $data['buildings'] ?? []
        );
    }
}
