<?php

namespace App\Controller\Api;

use App\Entity\Industry;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/entreprises', name: 'app_api_company_')]
class CompanyController extends AbstractController {
    /**
     * Method to return all companies in DB (without filters)
     *
     * @return JsonResponse
     */
    #[Route('/', name: 'listAll')]
    public function listAll(CompanyRepository $companyRepository): JsonResponse
    {
        $companies = $companyRepository->findAll();
        return $this->json($companies, Response::HTTP_OK, [], ["groups" => "industries"]);
    }

    /**
     *  Method to return a list of companies filter by one industry
     *
     * @return JsonResponse
     */
    #[Route('/secteur-activite/{id}', name: 'listByIndustry')]
    public function listByIndustry(Industry $id, CompanyRepository $companyRepository): JsonResponse
    {
        $companies = $companyRepository->findCompaniesByIndustry($id);
        return $this->json($companies, Response::HTTP_OK, [], ["groups" => "industries"]);
    }
}