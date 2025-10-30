<?php

namespace App\Controller\Api;

use App\Repository\BlackoutRepository;
use App\Service\BlackoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use InvalidArgumentException;
use App\Dto\BuildingDto;
use App\Dto\BlackoutDto;
use DateTime;

final class BlackoutsController extends AbstractController
{

    #[Route('/api/blackouts/stats/{period}', name: 'blackout_stats', methods: ['GET'])]
    public function stats(string $period,  BlackoutService $blackoutService): JsonResponse
    {
        try {
            $data = $blackoutService->getBlackoutsForPeriod($period);
            return $this->json($data);
        } catch (InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/api/blackouts/active', name: 'active_blackouts', methods: ['GET'])]
    public function getActiveBlackouts(BlackoutRepository $blackoutRepository): JsonResponse
    {
        $since = new DateTime('-1 hour');

        $blackouts = $blackoutRepository->findRecentBlackouts($since);
        $data = array_map(fn($b) => BlackoutDto::fromEntity($b), $blackouts);

        return $this->json($data);
    }
}
