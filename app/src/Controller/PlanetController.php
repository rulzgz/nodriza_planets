<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\PlanetRepository;
use App\Service\PlanetService;
use App\Entity\Planet;
use DateTime;


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

    /**
     * @Route("/planet", name="planet_new", methods={"POST"})
     */
    public function new(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $planet = new Planet;
        
        try {
            $planet->setId($data['id'] ?? null)
                ->setName($data['name'] ?? null)
                ->setRotationPeriod($data['rotation_period'] ?? null)
                ->setOrbitalPeriod($data['orbital_period'] ?? null)
                ->setDiameter($data['diameter'] ?? null)
                ->setCreated(new DateTime());
        } catch (\Throwable $e) {
            return new JsonResponse([
                'errors' => ['Wrong data type: id <integer>, name <string>, rotation_period <integer>, orbital_period <integer>, diameter <integer>']
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $validationErrors = $validator->validate($planet);

        if (count($validationErrors) > 0) {
            foreach ($validationErrors as $error) {
                $errors[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->repository->save($planet, true);

        return new JsonResponse($data, Response::HTTP_CREATED);
    }

}
