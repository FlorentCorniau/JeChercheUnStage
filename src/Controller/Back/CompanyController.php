<?php

namespace App\Controller\Back;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/entreprises', name: 'app_back_company_')]
class CompanyController extends AbstractController
{
    /**
     * method to list the differents companies
     *
     * @return Response
     */
    #[Route('/liste', name: 'list')]
    public function list(CompanyRepository $companyRepository): Response
    {
        $companies = $companyRepository->findAll();

        return $this->render('back/company/list.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * delete profile company
     */    
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Company $company, EntityManagerInterface $entityManagerInterface)
    {
        // Remove the company from the database
        $entityManagerInterface->remove($company, true);
        $entityManagerInterface->flush();

        // flash message to notify the admin that the offer was deleted successfully
        $this->addFlash('success', "L'entreprise <b>" . $company->getName() .  " </b> a été <b> suprrimée </b> avec succès.");

        // Redirect to the main page after deletion
        return $this->redirectToRoute("app_back_company_list");
    }
}