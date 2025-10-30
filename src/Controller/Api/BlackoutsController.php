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
use Symfony\Component\HttpFoundation\Request;
use App\Dto\BlackoutCreateDto;
use DateTime;

final class BlackoutsController extends AbstractController
{

    public function __construct(
        private readonly BlackoutService $blackoutService
    ) {}
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

    #[Route('/api/blackouts', name: 'create_blackout', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        try {
            $dto = BlackoutCreateDto::fromArray($data);
            $blackouts = $this->blackoutService->createBlackouts($dto);

            $responseData = array_map(fn($b) => BlackoutDto::fromEntity($b), $blackouts);
            return $this->json($responseData, 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}
