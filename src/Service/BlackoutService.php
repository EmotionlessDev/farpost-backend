<?php

namespace App\Service;

use App\Repository\BlackoutRepository;
use App\Dto\BlackoutCreateDto;
use App\Entity\Blackout;
use App\Repository\BuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTime;
use InvalidArgumentException;


readonly class BlackoutService
{

    public function __construct(
        private BlackoutRepository $blackoutRepository,
        private BuildingRepository $buildingRepository,
        private EntityManagerInterface $em,
    )
    {

    }
    public function getBlackoutsForPeriod(string $period): array
    {
        $now = new DateTime();

        try {
            $from = match ($period) {
                'hour' => $now->modify('-1 hour'),
                'day' => $now->modify('-1 day'),
                'week' => $now->modify('-7 days'),
                'month' => $now->modify('-30 days'),
                'year' => $now->modify('-1 year'),
                default => throw new InvalidArgumentException("Unknown period: $period"),
            };
        } catch (DateMalformedStringException $e) {
            throw new InvalidArgumentException("Invalid period format: {$period}");
        }

        $blackouts = $this->blackoutRepository->findByPeriod($now);

        if (!$blackouts) {
            return [
                'count' => 0,
                'type' => [],
            ];
        }

        $countByType = [];
        foreach ($blackouts as $blackout) {
            $type = $blackout->getType()->value;
            if (!isset($countByType[$type])) {
                $countByType[$type] = 0;
            }
            $countByType[$type]++;
        }

        return [
            'count' => count($blackouts),
            'type' => $countByType,
        ];
    }
    public function createBlackouts(BlackoutCreateDto $dto): array
    {
        $createdBlackouts = [];

        foreach ($dto->buildings as $coords) {
            $lat = (float) ($coords['lat'] ?? 0);
            $lng = (float) ($coords['lng'] ?? 0);

            $building = $this->buildingRepository->findByCoordinates($lat, $lng);

            if (!$building) {
                continue;
            }

            $blackout = new Blackout();
            $blackout->setType($dto->type);
            $blackout->setDescription($dto->description);
            $blackout->setStartDate($dto->startDate);
            $blackout->setEndDate($dto->endDate);
            $blackout->setSource($dto->source);
            $blackout->addBuilding($building);

            $this->em->persist($blackout);
            $createdBlackouts[] = $blackout;
        }

        $this->em->flush();

        return $createdBlackouts;
    }


}
