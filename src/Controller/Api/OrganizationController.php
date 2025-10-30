<?php

namespace App\Controller\Api;

use App\Repository\OrganizationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


final class OrganizationController extends AbstractController
{
    #[Route('/api/organizations', name: 'organizations', methods: ['GET'])]
    public function getOrganizations(OrganizationsRepository $organizationsRepository): JsonResponse
    {
        $organizations = $organizationsRepository->findAllWithBuildings();
        $data = [];

        foreach ($organizations as $organization) {
            $buildings = $organization->getBuildings();
            $data[] = [
                'id' => $organization->getId(),
                'name' => $organization->getName(),
                'building_count' => count($buildings),
            ];
        }

        return $this->json($data);
    }




}
