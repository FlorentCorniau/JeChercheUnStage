<?php

namespace App\Controller\Api;

use App\Entity\Industry;
use App\Repository\InternRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/stagiaires', name: 'app_api_intern_')]
class InternController extends AbstractController {
     /**
     * Method to return all interns in DB (without filters)
     *
     * @return JsonResponse
     */
    #[Route('/', name: 'listAll')]
    public function listAll(InternRepository $internRepository): JsonResponse
    {
        $interns = $internRepository->findAll();
        return $this->json($interns, Response::HTTP_OK, [], ["groups" => "industries"]);
    }

     /**
     * Method to return a list of companies filter by one industry
     *
     * @return JsonResponse
     */
    #[Route('/secteur-activite/{id}', name: 'listByIndustry')]
    public function listByIndustry(Industry $id, InternRepository $internRepository): JsonResponse
    {
        $interns = $internRepository->findInternsByIndustry($id);
        return $this->json($interns, Response::HTTP_OK, [], ["groups" => "industries"]);
    }
}