<?php

namespace App\Controller\Front;

use App\Entity\Intern;
use App\Entity\Company;
use App\Form\RegistrationInternFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationCompanyFormType;
use App\Repository\CompanyRepository;
use App\Repository\IndustryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/inscription', name: 'app_front_registration_')]
class RegistrationController extends AbstractController
{
    /**
     * Registration method for an intern.
     */
    #[Route('/stagiaire', name: 'intern')]
    public function registerIntern(Request $request, UserPasswordHasherInterface $userPasswordHasher,  EntityManagerInterface $entityManager, IndustryRepository $industryRepository, Security $security): Response
    {
        // Create a new Intern instance
        $intern = new Intern();
        // Create a registration form for the intern
        $form = $this->createForm(RegistrationInternFormType::class, $intern);
        $form->handleRequest($request);

        // Handle form submission and validation
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $intern->setPassword(
                $userPasswordHasher->hashPassword(
                    $intern,
                    $form->get('plainPassword')->getData()
                )
            );
            $intern->setRoles(["ROLE_INTERN"]);

            // Get the selected industries and add them to the intern entity
            $industries = $request->get('registration_intern_form')["industries"];
            if($industries) {
                for ($i = 0; $i < count($industries); $i++)
                {
                    $intern->addIndustry($industryRepository->find($industries[$i]));
                    //$entityManager->persist($industries[$i]);
                }
            }

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

            $entityManager->persist($intern);
            $entityManager->flush();
            
            $security->login($intern,'form_login');

            // Redirect to the home page after successful registration
            return $this->redirectToRoute('app_front_main_home');
        }

        // Render the registration form for the intern
        return $this->render('front/registration/intern.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
        
    }

    /**
     * Method for registering a company.
     */
    #[Route('/entreprise', name: 'company')]
    public function registerCompany(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, CompanyRepository $companyRepository, Security $security): Response
    {
         // Check if the user is already authenticated
        if ($this->getUser()) {
            dd("Vous êtes déjà connecté.");
        }
         // Create a new Company instance
        $user = new Company();
        // Create a registration form for the company
        $form = $this->createForm(RegistrationCompanyFormType::class, $user);
        $form->handleRequest($request);
        // Handle form submission and validation
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the SIRET number from the form
            $siretForm = $form->get('siret_number')->getData();
            // Check if the SIRET number already exists in the database
            if(!$companyRepository->findCompanyBySiret($siretForm)) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(["ROLE_COMPANY"]);

                // Persist the new company in the database
                $entityManager->persist($user);
                $entityManager->flush();

                $security->login($user,'form_login');

                // Authenticate the new user                   
                return $this->redirectToRoute('app_front_main_home');

            }
            else {
                // If the provided SIRET is already registered
                return $this->render('front/registration/company.html.twig', [
                    'registrationForm' => $form->createView(),
                    'errorSiret' => 'Le numéro de SIRET indiqué est déjà enregistré.'
                ]);
            }
        }

        // Render the registration form for the company
        return $this->render('front/registration/company.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
