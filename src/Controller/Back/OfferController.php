<?php

namespace App\Controller\Back;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/offres', name: 'app_back_offer_')]
class OfferController extends AbstractController
{
    /**
     * method to display in backoffice the list of all offers published
     *
     * @return Response
     */
    #[Route('/liste', name: 'list')]
    public function list(OfferRepository $offerRepository): Response
    {
        // list of all offers published
        $offers = $offerRepository->findAll();
     
        return $this->render('back/offer/list.html.twig', [
            'offers' => $offers
        ]);
    }

    /**
     * method to delete an internship offer
     */
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Offer $offer)
    {
        $entityManager->remove($offer);
        $entityManager->flush();

        // flash message to notify the admin that the offer was deleted successfully
        $this->addFlash('success', "L'offre <b>" . $offer->getTitle() .  " </b> a été <b> suprrimée </b> avec succès.");

        return $this->redirectToRoute('app_back_offer_list');
    }
}