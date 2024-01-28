<?php

namespace App\Controller\Front;

use App\Form\OfferFilterType;
use App\Repository\OfferRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller class handling main actions.
 */
class MainController extends AbstractController
{
    /**
     * Method for the homepage.
     */
    #[Route('/', name: 'app_front_main_home')]
    public function home(CompanyRepository $companyRepository): Response
    {
        return $this->render('front/main/home.html.twig', [
            "randomCompany" => $companyRepository->findRandomCompanyByThree(),
        ]);
    }

    /**
     * Method for displaying help content.
     */
    #[Route('/aide', name: 'app_front_main_help')]
    public function help(): Response
    {
        return $this->render('front/main/help.html.twig');
    }
    
    /**
     * Method for displaying terms of service.
     */
    #[Route('/conditions-generales-utilisation', name: 'app_front_main_cgu')]
    public function cgu(): Response
    {
        return $this->render('front/main/cgu.html.twig');
    }   

    /**
     * Controller method to search for offers by region
     */    
    #[Route('/recherche/{region}', name: 'app_front_main_searchofferbyregion')]
    public function searchOfferByRegion(OfferRepository $offerRepository, string $region, Request $request): Response
    {
        // Create a form displaying industry sectors
        $form = $this->createForm(OfferFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectionIndustries = $form->get('industries')->getData();
            // Fetch offers by selected industry and region
            $offers = $offerRepository->findOffersByIndustryAndRegion($collectionIndustries, $region);
        }
        else {
            // If the form is not submitted or invalid, fetch offers by region only    
            $offers = $offerRepository->findOffersByRegion($region); 
        }

        return $this->render('front/offer/list.html.twig', [
            'offers' => $offers,
            'region' => $region,
            'form' => $form
        ]);
    }
}