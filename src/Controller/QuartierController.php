<?php

namespace App\Controller;

use App\Entity\Quartier;
use App\Form\QuartierForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/quartier')]
class QuartierController extends BaseController
{
    #[Route('/new', name: 'app_quartier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        
        $quartier = new Quartier();
        $form = $this->createForm(QuartierForm::class, $quartier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quartier);
            $em->flush();

            $this->addFlash('success', 'Quartier ajouté avec succès.');
            return $this->redirectToRoute('app_quartier_new');
        }

        return $this->render('quartier/new.html.twig', [
            'form' => $form->createView(),
            'quartiers' => $em->getRepository(Quartier::class)->findAll()
        ]);
    } 
}
