<?php

namespace App\Controller;

use App\Repository\ObjectToRentRepository;
use App\Repository\CityRepository;
use App\Repository\QuartierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;

class SearchController extends AbstractController
{
   #[Route('/search', name: 'app_search')]
public function index(Request $request, ObjectToRentRepository $objectToRentRepository): Response
{
    $budgetMin = $request->query->get('budget_min');
    $budgetMax = $request->query->get('budget_max');

    $queryBuilder = $objectToRentRepository->createQueryBuilder('o');

    // Ajout d'une condition seulement si budgetMin est défini et numérique
    if ($budgetMin !== null && is_numeric($budgetMin)) {
        $queryBuilder->andWhere('o.price >= :minPrice')
                     ->setParameter('minPrice', $budgetMin);
    }

    // Ajout d'une condition seulement si budgetMax est défini et numérique
    if ($budgetMax !== null && is_numeric($budgetMax)) {
        $queryBuilder->andWhere('o.price <= :maxPrice')
                     ->setParameter('maxPrice', $budgetMax);
    }

    $objects = $queryBuilder->getQuery()->getResult();

    return $this->render('search/index.html.twig', [
        'objects' => $objects,
        'budget_min' => $budgetMin,
        'budget_max' => $budgetMax,
    ]);
}


    #[Route('/search/city/{id}', name: 'app_search_city')]
    public function getCityById(City $city): Response
    {
        return $this->render('search/searchCity.html.twig', [
            'city' => $city
        ]);
    }

    #[Route('/autocomplete', name: 'autocomplete', methods: ['GET'])]
    public function autocomplete(Request $request, CityRepository $cityRepository, QuartierRepository $quartierRepository): JsonResponse
    {
        $query = $request->query->get('query');

        $cities = $cityRepository->createQueryBuilder('c')
            ->where('c.name LIKE :search')
            ->setParameter('search', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $quartiers = $quartierRepository->createQueryBuilder('q')
            ->where('q.nom LIKE :search')
            ->setParameter('search', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $results = [];

        foreach ($cities as $city) {
            $results[] = [
                'type' => 'City',
                'name' => $city->getName(),
                'id' => $city->getId()
            ];
        }

        foreach ($quartiers as $quartier) {
            $results[] = [
                'type' => 'Quartier',
                'name' => $quartier->getNom(),
                'id' => $quartier->getId()
            ];
        }

        return new JsonResponse($results);
    }
}
