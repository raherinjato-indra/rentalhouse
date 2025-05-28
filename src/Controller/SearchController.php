<?php

// src/Controller/SearchController.php

namespace App\Controller;

use App\Repository\ObjectToRentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;

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
    #[Route('/search/city/{id}', name: 'app_search_city')]
    public function getCityById(City $city): Response
      
    {

        return $this->render('search/searchCity.html.twig', [
            'city' => $city
        ]);
    }
   
}

