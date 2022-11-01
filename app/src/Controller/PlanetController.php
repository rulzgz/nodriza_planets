<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlanetRepository;
use App\Service\PlanetService;
use App\Entity\Planet;

/**
 * @Route("/api", name="api_")
 */
class PlanetController extends AbstractController
{
    public function __construct(private PlanetRepository $repository, private PlanetService $planetService)
    {
    }

    /**
     * @Route("/planets/{id}", name="planet_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $data = $this->planetService->get($id);
        return new JsonResponse($data['content'], $data['status']);
    }

}
