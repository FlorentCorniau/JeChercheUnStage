<?php

namespace App\Controller\Front;

use App\Entity\Intern;
use App\Form\InternFilterType;
use App\Form\InternProfileType;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/stagiaires', name: 'app_front_intern_')]
class InternController extends AbstractController
{
    /**
    * Controller method for listing interns.
    */
    #[Route('/liste', name: 'list')]
    public function list(InternRepository $internRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {   
        // Create a form displaying industry sectors
        $form = $this->createForm(InternFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get selected industries from the form
            $collectionIndustries = $form->get('industries')->getData();

            $interns = $internRepository->findInternsByIndustry($collectionIndustries);
            //dd($request, $collectionIndustries, $interns);
            /*$pagination = $paginatorInterface->paginate(
                $internRepository->paginationQueryByIndustry($collectionIndustries), // target = query Doctrine
                $request->query->get('page', 1),
                6 // Nombre de stagiaires par page
            );*/
        }
        else {
            /*$pagination = $paginatorInterface->paginate(
                $internRepository->paginationQueryAll(), // target = query Doctrine
                $request->query->get('page', 1),
                6 // Nombre de stagiaires par page
            );*/
            $interns = $internRepository->findAll();
        }


        // Render the list view with the retrieved interns
        return $this->render('front/intern/list.html.twig', [
            'form' => $form,
            'interns' => $interns
            //'pagination' => $pagination
        ]); 
    }


    // show profile intern  
    #[Route('/mon-compte' , name:'show')]
    public function show(): Response 
    {            
        $intern = $this->getUser();
        if($intern) {
            //Render the profile view with the retrieved intern
            return $this->render('front/intern/show.html.twig', [
                'intern' => $intern, 
            ]); 
        }
    }
  
  
    /**
     * show profile intern public 
     */
    #[Route('/profil/{id}', name:'showProfile')]
    public function showProfile (InternRepository $internRepository , EntityManagerInterface $entityManager,  int $id): Response 
    {
        // Retrieve the intern with the given id
        $intern = $internRepository->find($id);
        
        // Assuming Intern entity has a property named 'industries'
        $industries = $intern->getIndustries();
    
        //Render the profile view with the retrieved intern
        return $this->render('front/intern/showProfile.html.twig', [
            'intern' => $intern, 
            'industries' => $industries,
        ]); 
    }

    /**
     * update profile interne 
     *
     * @param Request $request
     * @param InternRepository $internRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/mon-compte/mise-a-jour', name: 'update', methods:["GET" , "POST"])]
    public function update(Request $request, InternRepository $internRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $this->getUser()->getId();
        // Retrieve the intern with the given id
        $intern = $internRepository->find($id);

        // If the intern exists
        if($intern) {

            // Create the form associated with the Intern entity
            $form = $this->createForm(InternProfileType::class, $intern );

            // Handle the form submission
            $form->handleRequest($request);

            if ($form->isSubmitted()) { // && $form->isValid()) {

                // if we have an image
                if ($image = $form->get('imageFile')->getData()) {
                    $imageName = uniqid() . '_' . $image->getClientOriginalName();
                    $image->move($this->getParameter('upload_directory_image'), $imageName);
                    $intern->setPictureName($imageName);
                    $intern->setImageFile(null);
                }

                // if we have a resume
                if ($resume = $form->get('resumeFile')->getData()) {   
                    $resumeName = uniqid() . '_' . $resume->getClientOriginalName();
                    $resume->move($this->getParameter('upload_directory_cv'), $resumeName);
                    $intern->setResumeName($resumeName);
                    $intern->setResumeFile(null);
                }                  

                $entityManager->flush();  

                //  flash message to notify that your profile was update successfully
                $this->addFlash('success', " Merci  <b>" . $intern->getFirstName() .  " </b> d'avoir actualisé vos informations. Votre profil reflète désormais les changements que vous avez apportés.");

                // Redirect to the intern's profile page after the update
                return $this->redirectToRoute('app_front_intern_show', [
                    'id' => $intern->getId(),
                ]);
            }

            // Render the form in the view
            return $this->render('front/intern/update.html.twig', [
                'intern' => $intern,
                'form' => $form,
            ]);
        }
    }

    /**
     * delete profile intern
     */
    #[Route('/mon-compte/suppression', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        // We target the user session Id
        $userId = $this->getUser()->getId();
        $intern = $this->getUser();

        // Then we do the same with the internProfile id
        //$internProfileId = $intern->getId();

        // We compare them and if they match we proceed like this :
        if ($userId) {
            // delete the intern of the database
            $entityManager->remove($intern);
            // flush changes to the database
            $entityManager->flush();      
            
            // Clear the session token so there is no issue when we redirect to homepage 
            $tokenStorage->setToken(null);
            // Redirect to the main page after deletion

            $this->addFlash('success', "Votre profil a bien été supprimé.");

            return $this->redirectToRoute("app_front_main_home");
        
        // Or of they dont match.
        } 
        else {
            // Unauthorized access, this user does not have a matchting ID

            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à supprimer ce profil.');
            return $this->redirectToRoute('app_front_intern_show');
        }
    }
}