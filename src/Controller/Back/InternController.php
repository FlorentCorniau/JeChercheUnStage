<?php

namespace App\Controller\Back;

use App\Entity\Intern;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/stagiaires', name: 'app_back_intern_')]
class InternController extends AbstractController
{
    #[Route('/liste', name: 'list')]
    public function list( InternRepository $internRepository ): Response
    {   
        // Fetch all interns from the repository
        $interns = $internRepository->findAll(); 

        // Render the list view with the retrieved interns
        return $this->render('back/intern/list.html.twig', [
            'interns' => $interns
        ]); 
    }

    
    // delete profile interne
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Intern $intern, InternRepository $internRepository , EntityManagerInterface $entityManagerInterface , int $id)
    {
        // Retrieve the intern with the given id
        $intern = $internRepository->find($id); 
    
        // Remove the intern from the database
        $entityManagerInterface->remove($intern, true);
        $entityManagerInterface->flush();

        // flash message to notify the admin that the offer was deleted successfully
        $this->addFlash('success', "Le stagiaire <b>" . $intern->getFirstName() .  " </b> a été <b> suprrimé </b> avec succès.");

        // Redirect to the main page after deletion
        return $this->redirectToRoute("app_back_intern_list");
            
    }
}