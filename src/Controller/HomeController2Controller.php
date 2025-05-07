<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController2Controller extends BaseController
{
    #[Route('/', name: 'app_home_controller2')]
    public function index(Environment $twig): Response
    {
        return parent::Response($twig,'home/index.html.twig',['header_type' =>'home']);
    }
}
