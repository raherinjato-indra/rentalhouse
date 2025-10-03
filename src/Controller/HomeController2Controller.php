<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController2Controller extends BaseController
{
    #[Route('/', name: 'app_home_controller2')]
    public function index(Environment $twig): Response
    {
        // Exemple : tableau des types de biens (remplace par ta vraie source de données plus tard)
        $typeObjectToRents = [
            (object)['id' => 1, 'name' => 'Appartement'],
            (object)['id' => 2, 'name' => 'Maison'],
            (object)['id' => 3, 'name' => 'Terrain'],
        ];

        // Envoi des variables à la vue Twig
        return parent::Response($twig, 'home/index.html.twig', [
            'header_type' => 'home',
            'typeObjectToRents' => $typeObjectToRents,
        ]);
    }
}
