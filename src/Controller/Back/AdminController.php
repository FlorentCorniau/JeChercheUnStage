<?php

namespace App\Controller\Back;

use App\Entity\Admin;
use App\Form\CreateAdminType;
use App\Form\UpdateAdminType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin', name: 'app_back_admin_')]
class AdminController extends AbstractController
{
    /**
     * method to list all admins
     * 
     * @return Response
     */
    #[Route('/liste', name: 'list')]
    public function list(AdminRepository $adminRepository ): Response
    {
        $admins = $adminRepository->findAll();

        return $this->render('back/admin/list.html.twig', [
            'admins' => $admins,
        ]);
    }

    /**
     * method to add an admin
     * 
     * @return Response
     */
    #[Route('/ajout', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /// Create a new Admin entity to implemented
        $admin = new Admin();

        // Create a form for creating an admin (using the CreateAdminType form type)
        $form = $this->createForm(CreateAdminType::class, $admin);

        // Handle the form submission and validation
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );
            $admin->setRoles(["ROLE_ADMIN"]);
        
            $entityManager->persist($admin);
            $entityManager->flush();
            
            // display message success  
            $this->addFlash('success', "L'administrateur <b> " . $admin->getFirstname() . " " . $admin->getFirstname() ." </b> a bien été ajouté.");
            
            // Redirect to the home page after successful registration
            return $this->redirectToRoute("app_back_admin_list");
        }
    

        // Render the create admin form template with the admin create and form
        return $this->render('back/admin/create.html.twig', [
            'admin' => $admin,
            'formCreateAdmin' => $form
        ]);
    }

    #[Route('/mise-a-jour/{id}', name: 'update')]
    public function update(Admin $admin, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        // dd($admin);

        // Create a form for creating an admin (using the CreateAdminType form type)
        $form = $this->createForm(UpdateAdminType::class, $admin);

        // Handle the form submission and validation
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($admin);
            $entityManagerInterface->flush();

            // display message success  
            $this->addFlash('success', "Vous venez de modifier les informations de l'Administrateur <b> " . $admin->getFirstname() . " " . $admin->getFirstname() ." </b>.");
            return $this->redirectToRoute('app_back_admin_list');
        }

        return $this->render('back/admin/update.html.twig', [
            'formUpdateAdmin' => $form,
            'admin' => $admin,
        ]);
    }

    /**
     * delete profile admin
     */    
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Admin $admin, EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
    {

        // if the user in url === admin logged , delete my profil, reset token and redirect to homepage
        if ($admin) {
            // delete the admin of the database
            $entityManager->remove($admin,true);
            // flush changes to the database
            $entityManager->flush();      
            
            // Clear the session token so there is no issue when we redirect to homepage 
            $tokenStorage->setToken(null);
            // Redirect to the main page after deletion

            $this->addFlash('success', "Votre profil administrateur a bien été supprimé.");

            return $this->redirectToRoute("app_front_main_home");
        
        } 
        // else just remove the admin selected and redirect to listing of admins in backoffice
        else {
        $entityManager->remove($admin, true);
        $entityManager->flush();

        // flash message to notify the admin that the offer was deleted successfully
        $this->addFlash('success', "L'Administrateur <b>" . $admin->getFirstname() .  " " . $admin->getLastname(). " </b> a été <b> suprrimé </b> avec succès.");

        // Redirect to the main page after deletion
        return $this->redirectToRoute("app_back_admin_list");
            
        }  
    }
}