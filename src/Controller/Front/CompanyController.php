<?php

namespace App\Controller\Front;

use App\Entity\Company;
use App\Form\CompanyFilterType;
use App\Form\CompanyProfileType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/entreprises', name: 'app_front_company_')]
class CompanyController extends AbstractController
{
    /**
     * method to list internship offers of one company
     *
     * @return Response
     */
    #[Route('/mes-offres', name: 'myOffers')]
    public function myOffers(): Response
    {
        // We get the current connected user
        // No need here because we get the offers of the user directly in twig with app.user.offers
        return $this->render('front/company/myOffers.html.twig');
    }

    /**
     * method for listing companies.
     *
     * @return Response
     */
    #[Route('/liste', name: 'list')]
    public function list(CompanyRepository $companyRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        // Create a form displaying industry sectors
        $form = $this->createForm(CompanyFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get selected industries from the form
            $collectionIndustries = $form->get('industries')->getData();
            $companies = $companyRepository->findCompaniesByIndustry($collectionIndustries);

            // Paginate companies based on selected industries
            // $pagination = $paginatorInterface->paginate(
            //     $companyRepository->paginationQueryByIndustry($collectionIndustries), // target = query Doctrine
            //     $request->query->get('page', 1),
            //     6 // Nombre de stagiaires par page
            // );
        }
        else {
             // Paginate all companies if the form is not submitted or invalid
            // $pagination = $paginatorInterface->paginate(
            //     $companyRepository->paginationQueryAll(), // target = query Doctrine
            //     $request->query->get('page', 1),
            //     6 // Nombre de stagiaires par page
            // );
            $companies = $companyRepository->findAll(); 
        }
         // Render the list view with the paginated companies
        return $this->render('front/company/list.html.twig', [
            // 'pagination' => $pagination,
            'companies' => $companies,
            'form' => $form
        ]);
    }
  
    /**
     * method to show one company based on the ID
     *
     * @return Response
     */    
    #[Route('/profil/{id}', name: 'showCompany')]
    public function showCompany(CompanyRepository $companyRepository, $id): Response
    {      
        // Find the company by ID
        $company = $companyRepository->find($id);
        
        // Render the company profile view
        return $this->render('front/company/showCompany.html.twig', [ 
            'company' => $company,             
            'industry' => $company->getIndustries(),       

        ]);        
    }
  

    /**
     * method to show the profile of current user if they are a company
     *
     * @return Response
     */        
    #[Route('/mon-compte', name: 'show')]
    public function show(): Response
    {           
        return $this->render('front/company/show.html.twig', [         
        ]);        
    }

    /**
     * method to update the profile of current user if they are a company
     *
     * @return Response
     */
    #[Route('/mon-compte/mise-a-jour', name: 'update')]
    public function update(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
    
        $form = $this->createForm(CompanyProfileType::class, $this->getUser());
        
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the updated user data
            $entityManagerInterface->persist($this->getUser());
            $entityManagerInterface->flush();

            //flash message to notify that your profile was update successfully
            $this->addFlash('success', " Merci d'avoir actualisé vos informations.Votre profil reflète désormais les changements que vous avez apportés.");

            // Redirect to the company profile page after successful update
            return $this->redirectToRoute('app_front_company_show');
        }
        
        // Render the update form for the company profile
        return $this->render('front/company/update.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Method to delete a company profile.
     */
    #[Route('/mon-compte/suppression', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {

        // We target the user session Id
        $userId = $this->getUser()->getId();
        $company = $this->getUser();

        // We compare them and if they match we proceed like this :
        if ($userId) {
            // delete the company of the database
            $entityManager->remove($company);
            // flush changes to the database
            $entityManager->flush();      
            
            // Clear the session token so there is no issue when we redirect to homepage 
            $tokenStorage->setToken(null);
            // Redirect to the main page after deletion
            $this->addFlash('success', "Votre profil a bien été supprimé.");

            return $this->redirectToRoute("app_front_main_home");

        // Or of they dont match.
        } 
        else 
        {
            // Unauthorized access, this user does not have a matchting ID
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à supprimer ce profil.');
          
            return $this->redirectToRoute('app_front_company_show');
        }
    }   
}