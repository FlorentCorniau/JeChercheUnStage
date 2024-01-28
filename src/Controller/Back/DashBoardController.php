<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_back_dashboard_')]
class DashBoardController extends AbstractController
{
    /**
     * method to display dashboard of backoffice
     *
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('back/dashboard/home.html.twig');
    }
}