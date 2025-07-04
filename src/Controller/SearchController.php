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
public function index(
    Request $request,
    ObjectToRentRepository $objectToRentRepository,
    CityRepository $cityRepository
): Response {
    $budgetMin = $request->query->get('budget_min');
    $budgetMax = $request->query->get('budget_max');

    // Récupère ce que l'utilisateur tape dans le champ texte "query"
    $cityName = $request->query->get('query');
    $city = null;

    if ($cityName) {
        // Cherche la ville en base, insensible à la casse
        $city = $cityRepository->createQueryBuilder('c')
            ->where('LOWER(c.name) = :name')
            ->setParameter('name', strtolower(trim($cityName)))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        // Si ville trouvée, prends son vrai nom
        if ($city) {
            $cityName = $city->getName();
        }
    }

    $queryBuilder = $objectToRentRepository->createQueryBuilder('o');

    if ($budgetMin !== null && is_numeric($budgetMin)) {
        $queryBuilder->andWhere('o.price >= :minPrice')
                     ->setParameter('minPrice', $budgetMin);
    }

    if ($budgetMax !== null && is_numeric($budgetMax)) {
        $queryBuilder->andWhere('o.price <= :maxPrice')
                     ->setParameter('maxPrice', $budgetMax);
    }

    if ($city) {
        $queryBuilder->andWhere('o.city = :city')
                     ->setParameter('city', $city);
    }

    $objects = $queryBuilder->getQuery()->getResult();

   return $this->render('search/index.html.twig', [
    'objects' => $objects,
    'budget_min' => $budgetMin,
    'budget_max' => $budgetMax,
    'nbresultat' => count($objects),
    'city' => $city,
    'city_name' => $cityName ?? '',
]);

}



 #[Route('/search/city/{id}', name: 'app_search_city')]
public function getCityById(City $city): Response
{
    $nbresultat = 0;

    foreach ($city->getQuartiers() as $quartier) {
        foreach ($quartier->getCoordonnees() as $coordonnee) {
            $nbresultat += count($coordonnee->getObjectToRents());
        }
    }

    return $this->render('search/searchCity.html.twig', [
        'city' => $city,
        'city_name' => $city->getName(), // <-- AJOUTÉ
        'nbresultat' => $nbresultat,
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
