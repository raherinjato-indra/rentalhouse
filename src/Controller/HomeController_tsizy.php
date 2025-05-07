<?php
namespace App\Controller;

use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class HomeController_tsizy extends BaseController
{
    /**
     * @Route("/accueil", name="accueil", methods={"GET"})
     */
    public function index(Environment $twig)
    {
        //$session = new Session();
        //$user = $this->getUser();
        //$client = new \GuzzleHttp\Client();
        //$response2 = $client->request('GET', $this->getParameter('RESTUri')."albums");
        //$albums = $this->get('serializer')
           // ->deserialize($response2->getBody(), 'App\Models\Album[]', 'json');
        return parent::Response($twig,'home/index.html.twig',null);
    }
}