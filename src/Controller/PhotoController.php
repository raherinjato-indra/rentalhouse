<?php
namespace App\Controller;

use App\Entity\ObjectToRent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    #[Route('/photo/{id}', name: 'photo_show')]
    public function show(ObjectToRent $object): Response
    {
        $photoData = $object->getPhoto();

        if (!$photoData) {
            throw $this->createNotFoundException('Photo non trouvée');
        }

        return new Response($photoData, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline',
        ]);
    }
}
