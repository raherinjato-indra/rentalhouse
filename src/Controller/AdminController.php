<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('baseadmin.html.twig');
    }

    #[Route('/admin/city', name: 'admin_city_index')]
    public function cityIndex(): Response
    {
        return $this->render('city/index.html.twig');
    }

    #[Route('/admin/city/new', name: 'admin_city_new')]
    public function cityNew(): Response
    {
        return $this->render('city/new.html.twig');
    }

    #[Route('/admin/quartier', name: 'admin_quartier_index')]
    public function quartierIndex(): Response
    {
        return $this->render('quartier/index.html.twig');
    }

    #[Route('/admin/quartier/new', name: 'admin_quartier_new')]
    public function quartierNew(): Response
    {
        return $this->render('quartier/new.html.twig');
    }

    #[Route('/admin/coordonnees', name: 'admin_coordonnees_index')]
    public function coordonneesIndex(): Response
    {
        return $this->render('coordonnees/index.html.twig');
    }

    #[Route('/admin/coordonnees/new', name: 'admin_coordonnees_new')]
    public function coordonneesNew(): Response
    {
        return $this->render('coordonnees/new.html.twig');
    }

    #[Route('/admin/object_to_rent', name: 'admin_object_to_rent_index')]
    public function objectToRentIndex(): Response
    {
        return $this->render('object_to_rent/index.html.twig');
    }

    #[Route('/admin/object_to_rent/new', name: 'admin_object_to_rent_new')]
    public function objectToRentNew(): Response
    {
        return $this->render('object_to_rent/new.html.twig');
    }
}
