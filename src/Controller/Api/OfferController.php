<?php

namespace App\Controller\Api;

use App\Entity\Industry;
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/offres', name: 'app_api_offer_')]
class OfferController extends AbstractController {
    /**
     * Method to return all offers in DB (without filters)
     *
     * @return JsonResponse
     */
    #[Route('/', name: 'listAll')]
    public function listAll(OfferRepository $offerRepository): JsonResponse
    {
        $offers = $offerRepository->findAll();
        return $this->json($offers, Response::HTTP_OK, [], ["groups" => "industries"]);
    }
    
    /**
     *  Method to return a list of offers filter by one industry
     *
     * @return JsonResponse
     */
    #[Route('/secteur-activite/{id}', name: 'listByIndustry')]
    public function listByIndustry(Industry $id, OfferRepository $offerRepository): JsonResponse
    {
        $offers = $offerRepository->findOffersByIndustry($id);
        return $this->json($offers, Response::HTTP_OK, [], ["groups" => "industries"]);
    }
}