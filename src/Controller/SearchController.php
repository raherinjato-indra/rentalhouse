<?php

// src/Controller/SearchController.php

namespace App\Controller;

use App\Repository\ObjectToRentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends BaseController
{
    #[Route('/search', name: 'app_search')]
    public function index(ObjectToRentRepository $objectToRentRepository): Response
    {
        // Récupère tous les objets à louer
        $objects = $objectToRentRepository->findAll();

        return $this->render('search/index.html.twig', [
            'objects' => $objects,
        ]);
    }
}

