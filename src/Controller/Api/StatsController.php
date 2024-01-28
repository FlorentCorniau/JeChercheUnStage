<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/stats', name: 'app_api_stats_')]
class StatsController extends AbstractController {
    /**
     * Method to return JSON data
     *
     * @return JsonResponse
     */
    #[Route('/', name: 'list')]
    public function list(): JsonResponse
    {
        // Generating statistical data for various categories
        $stats = [
            [
                "name" => "Informatique",
                "data" => mt_rand(8, 30) // Generating random data within a range
            ],
            [
                "name" => "Administratif",
                "data" => mt_rand(1, 15)
            ],
            [
                "name" => "Aéronotique",
                "data" => mt_rand(3, 16)
            ],
            [
                "name" => "Mécanique",
                "data" => mt_rand(1, 9)
            ],
            [
                "name" => "Education",
                "data" => mt_rand(1, 7)
            ],
            [
                "name" => "BTP",
                "data" => mt_rand(1, 18)
            ]
        ];

        /*$collection = new ArrayCollection([
            'wage' => [
                'name' => 'jwage',
            ],
            'roman' => [
                'name' => 'romanb',
            ],
        ]);*/

        // Return JSON response containing the statistical data
        return $this->json($stats, Response::HTTP_OK, []);//, ["groups" => "movies"]);
    }
}