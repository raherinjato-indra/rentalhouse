<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\TypeObjectToRent;
use App\Repository\CityRepository;
use App\Repository\ObjectToRentRepository;
use App\Repository\QuartierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(
        Request $request,
        ObjectToRentRepository $objectToRentRepository,
        CityRepository $cityRepository,
        EntityManagerInterface $em
    ): Response {
        // Récupération des paramètres GET
        $cityId = $request->query->get('city');
        $budgetMin = $request->query->get('budget_min');
        $budgetMax = $request->query->get('budget_max');

        // Récupération des types de biens (array)
        $biens = $request->query->all('biens');
        if (!is_array($biens)) {
            $biens = [];
        }

        // Récupération de la ville (entité)
        $city = null;
        $cityName = '';
        if ($cityId) {
            $city = $cityRepository->find($cityId);
            $cityName = $city ? $city->getName() : '';
        }

        // Construction de la requête avec QueryBuilder
        $qb = $em->createQueryBuilder()
            ->select('o', 't', 'q', 'c')
            ->from('App\\Entity\\ObjectToRent', 'o')
            ->leftJoin('o.typeObjectToRent', 't')
            ->leftJoin('o.quartier', 'q')
            ->leftJoin('q.city', 'c');

        if ($budgetMin !== null && is_numeric($budgetMin)) {
            $qb->andWhere('o.price >= :minPrice')->setParameter('minPrice', $budgetMin);
        }

        if ($budgetMax !== null && is_numeric($budgetMax)) {
            $qb->andWhere('o.price <= :maxPrice')->setParameter('maxPrice', $budgetMax);
        }

        if ($city) {
            $qb->andWhere('c = :city')->setParameter('city', $city);
        }

        if (!empty($biens)) {
            $biensIds = array_filter($biens, fn($id) => is_numeric($id));
            if (count($biensIds) > 0) {
                $qb->andWhere('t.id IN (:types)')->setParameter('types', $biensIds);
            }
        }

        $objects = $qb->getQuery()->getResult();

        $typeObjectToRents = $em->getRepository(TypeObjectToRent::class)->findAll();

        return $this->render('search/index.html.twig', [
            'objects' => $objects,
            'budget_min' => $budgetMin,
            'budget_max' => $budgetMax,
            'nbresultat' => count($objects),
            'city_name' => $cityName,
            'typeObjectToRents' => $typeObjectToRents,
        ]);
    }

    #[Route('/search/city/{id}', name: 'app_search_city')]
    public function getCityById(City $city): Response
    {
        $nbresultat = 0;
        foreach ($city->getQuartiers() as $quartier) {
            foreach ($quartier->getCoordonnees() as $coordonnee) {
                foreach ($coordonnee->getObjectToRents() as $obj) {
                    $nbresultat++;
                }
            }
        }

        return $this->render('search/searchCity.html.twig', [
            'city' => $city,
            'city_name' => $city->getName(),
            'nbresultat' => $nbresultat,
        ]);
    }

    #[Route('/autocomplete', name: 'autocomplete', methods: ['GET'])]
    public function autocomplete(Request $request, CityRepository $cityRepository, QuartierRepository $quartierRepository): JsonResponse
    {
        $query = trim($request->query->get('query', ''));

        if (strlen($query) < 2) {
            return new JsonResponse([]);
        }

        $cities = $cityRepository->createQueryBuilder('c')
            ->where('LOWER(c.name) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $query . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $quartiers = $quartierRepository->createQueryBuilder('q')
            ->where('LOWER(q.nom) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $query . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $results = [];

        foreach ($cities as $city) {
            $results[] = [
                'type' => 'Ville',
                'name' => $city->getName(),
                'id' => $city->getId(),
            ];
        }

        foreach ($quartiers as $quartier) {
            $results[] = [
                'type' => 'Quartier',
                'name' => $quartier->getNom(),
                'id' => $quartier->getId(),
            ];
        }

        return new JsonResponse($results);
    }
}
