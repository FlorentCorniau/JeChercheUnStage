<?php

namespace App\Controller\Front;


use App\Entity\User;
use App\Entity\Offer;
use App\Form\ApplyOfferType;
use App\Form\CreateOfferType;
use App\Form\OfferFilterType;
use App\Form\UpdateOfferType;
use App\Repository\OfferRepository;
use Symfony\Component\Mime\Part\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/offres', name: 'app_front_offer_')]
class OfferController extends AbstractController 
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag) {
        $this->parameterBag = $parameterBag;
    }

    /**
     *  Controller method to list published offers
     */
    #[Route('/liste', name: 'list')]
    public function list(OfferRepository $offerRepository): Response
    {     
        $offers = $offerRepository->findAll(); 

        // Create a form displaying industry sectors and button "Filtrer"
        $form = $this->createForm(OfferFilterType::class);

        return $this->render('front/offer/list.html.twig', [
            'offers' => $offers,
            'form' => $form
        ]);
    }

    /**
     *  method to show detail of one offer
     */
    #[Route('/{id}', name: 'show')]
    public function show(Offer $offer): Response
    {    
        // If offer exist, show this offer
        if($offer) { 
            return $this->render('front/offer/show.html.twig', [
                'offer' => $offer,
            ]);
        }
    }

    /**
     * method to add an internship offer
     * 
     * @return Response
     */
    #[Route('/ajout/nouvelle', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /// Create a new Offer entity to implemented
        $offer = new Offer();

        // Get the currently authenticated user
        /**
         * @var User $user
         */
        $user = $this->getUser();

        // Get the company name from the currently authenticated user

        $companyName = $user->getName();
        
        // Set the company name of company who create the offer 
        $offer->setCompanyName($companyName);
        
        // Set the company of currently authenticated user in the Offer
        $offer->setCompany($user);

        // Create a form for creating an offer (using the CreateOfferType form type)
        $form = $this->createForm(CreateOfferType::class, $offer);

        // Handle the form submission and validation
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Persist the offer entity to the database
            $entityManager->persist($offer);
            // Flush changes to the database
            $entityManager->flush();
            
            // display message success  
            $this->addFlash('success', "L'annonce <b> " . $offer->getTitle() . " </b> a bien été ajoutée.");

            // Redirect to the route named "app_front_company_myOffers"
            return $this->redirectToRoute("app_front_company_myOffers");
        }
        

        // Render the create offer form template with the offer create and form
        return $this->render('front/offer/create.html.twig', [
            'offer' => $offer,
            'formCreateOffer' => $form
            ]);
    }
        

    /**
     * method to update an internship offer
     *
     * @return Response
     */
    #[Route('/modification/{id}', name: 'update')]
    public function update(Request $request, EntityManagerInterface $entityManager, Offer $offer ): Response
    {
        if($offer) {
            // Create a form for updating an offer (using the UpdateOfferType form type)
            $form = $this->createForm(UpdateOfferType::class, $offer);

            // Handle the form submission and validation
            $form->handleRequest($request);

            // Check if the form is submitted and valid
            if ($form->isSubmitted() && $form->isValid()) {

                // Persist the offer entity to the database
                $entityManager->persist($offer);
                // Flush changes to the database
                $entityManager->flush();

                // Redirect to the route named "app_front_company_myOffers"
                return $this->redirectToRoute("app_front_company_myOffers");

            }

            // Render the update offer form template with the offer update and form
            return $this->render('front/offer/update.html.twig', [
                'offer' => $offer,
                'formUpdatedOffer' => $form
            ]);

        }
        
    }


    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Offer $offer)
    {
        // We target the user session Id
        $userId = $this->getUser()->getId();
        // Then the same id in the Offer Object
        $companyIdByOffer = $offer->getCompany()->getId();

        // We compare them and if they match we proceed like this :
        if($userId === $companyIdByOffer) {
            // delete the offer of the database
            $entityManager->remove($offer);
            // Flush changes to the database
            $entityManager->flush();

            $this->addFlash('success', "L'annonce <b> " . $offer->getTitle() . " </b> a bien été supprimée.");
                
            // Redirect to the route named "app_front_company_myOffers"
            return $this->redirectToRoute('app_front_company_myOffers');
            
            // Or of they dont match.
        } 
        else {
            // Unauthorized access, this user does not have a matchting ID
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à supprimer cette offre.');
            return $this->redirectToRoute('app_front_company_myOffers');
        }
    }

    /**
     * Method to apply for an offer => on the "offer details" page when clicking "Postuler"
     */
    #[Route('/postuler/{id}', name: 'offerApply')]
    public function offerApply(Request $request, Offer $offer, MailerInterface $mailer)
    {
        // Get the intern's data to pass it to in argument off email sending method
        $intern = $this->getUser();

        // Create a form for applying to an offer (using the ApplyOfferType formType)
        $form = $this->createForm(ApplyOfferType::class);

        // Processing data submitted on the form, validating and updating the form object with this data.
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
       
            $emailContain = $form->get('email_contain')->getData();

            // Execute the "sendEmailToCompany" method with arguments retrieved from the application form
            $this->sendEmailToCompany($emailContain, $intern, $offer, $mailer);

            // Display message success
            $this->addFlash(
                'success', 
                "Votre candidature pour l'offre <b> " . $offer->getTitle() . " </b> a bien été <b> envoyée </b>."
            );

            // Redirect to the route named "app_front_offer_show"
            return $this->redirectToRoute('app_front_offer_show',[
                'id' => $offer->getId()
            ]);

        }

        // Render the apply offer form template with the offer and the form
        return $this->render('front/offer/offerApply.html.twig', [
            'offer' => $offer,
            'formApplyOffer' => $form,
            'resume' => $intern->getResumeName()
        ]);

    }   

    // Private method to send an email to the company
    private function sendEmailToCompany($emailContain, $intern, $offer, $mailer)
    {
        // Get the project directory URL
        $url = $this->parameterBag->get('kernel.project_dir') . "/public";                      

        $internEmail = $intern->getEmail();
        $internResume = $intern->getResumeName();
        $internFirstname = $intern->getFirstname();
        $internLastname = $intern->getLastname();
        $internFullname = $internFirstname . '_' . $internLastname; // Exemple : Florent_Corniau

        // Get company's email
        $companyEmail = $offer->getCompany()->getEmail();

        // Get offer name
        $offerName = $offer->getTitle();

        // Create the email
        $email = (new TemplatedEmail())
        
        ->from('jechercheunstage.oclock@gmail.com')
        ->cc($internEmail)
        ->to($companyEmail)
        ->subject($offerName.' - '. $internFullname)
        // Template to genrate the contain of sent email
        ->htmlTemplate('front/offer/sendEmail.html.twig')
        // Add variables required for the template
        ->context([
            'emailContain' => $emailContain,
        ])
        // add resume (cv) as attachment of email
        ->addPart(new DataPart(new File($url . '/cv/stagiaires/'. $internResume), $internFullname . '.pdf'));

        // Send the email
        $mailer->send($email);
    }
}