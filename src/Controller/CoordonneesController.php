<?php

namespace App\Controller;

use App\Entity\Coordonnees;
use App\Form\CoordonneesForm;
use App\Repository\CoordonneesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// ⚠️ Ajoute ceci pour intercepter les erreurs de contrainte
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

#[Route('/coordonnees')]
final class CoordonneesController extends AbstractController
{
    #[Route(name: 'app_coordonnees_index', methods: ['GET'])]
    public function index(CoordonneesRepository $coordonneesRepository): Response
    {
        return $this->render('coordonnees/index.html.twig', [
            'coordonnees' => $coordonneesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_coordonnees_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coordonnee = new Coordonnees();
        $form = $this->createForm(CoordonneesForm::class, $coordonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coordonnee);
            $entityManager->flush();

            return $this->redirectToRoute('app_coordonnees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coordonnees/new.html.twig', [
            'coordonnee' => $coordonnee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coordonnees_show', methods: ['GET'])]
    public function show(Coordonnees $coordonnee): Response
    {
        return $this->render('coordonnees/show.html.twig', [
            'coordonnee' => $coordonnee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coordonnees_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coordonnees $coordonnee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoordonneesForm::class, $coordonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_coordonnees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coordonnees/edit.html.twig', [
            'coordonnee' => $coordonnee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coordonnees_delete', methods: ['POST'])]
    public function delete(Request $request, Coordonnees $coordonnee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coordonnee->getId(), $request->getPayload()->getString('_token'))) {
            try {
                $entityManager->remove($coordonnee);
                $entityManager->flush();

                $this->addFlash('success', '✅ Coordonnée supprimée avec succès.');
            } catch (ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', '❌ Impossible de supprimer cette coordonnée car elle est utilisée par un ou plusieurs biens.');
            }
        }

        return $this->redirectToRoute('app_coordonnees_index');
    }
}
