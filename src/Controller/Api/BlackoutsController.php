<?php

namespace App\Controller\Api;

use App\Service\BlackoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use InvalidArgumentException;

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
}
