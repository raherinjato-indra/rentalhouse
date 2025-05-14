<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Repository\CityRepository;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getGlobals(): array
    {
        return [
            'cities' => $this->cityRepository->findAll()
        ];
    }
}


