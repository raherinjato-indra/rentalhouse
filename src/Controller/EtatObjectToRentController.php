<?php

namespace App\Controller;

use App\Entity\EtatObjectToRent;
use App\Form\EtatObjectToRentForm;
use App\Repository\EtatObjectToRentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etat/object/to/rent')]
final class EtatObjectToRentController extends AbstractController
{
    #[Route('/etat-object-to-rent', name: 'app_etat_object_to_rent_index', methods: ['GET'])]
    public function index(EtatObjectToRentRepository $etatObjectToRentRepository): Response
    {
        $categories = [
            'Disponibilité' => ['Disponible', 'Réservé', 'Loué', 'Expiré', 'Retiré du marché'],
            'État physique' => ['Neuf', 'Bon état', 'À rénover', 'En maintenance', 'Insalubre'],
            'Gestion financière' => ['En attente de paiement', 'Paiement en cours', 'Paiement effectué', 'Impayé', 'Saisie'],
            'Statut administratif' => ['En cours d’enregistrement', 'Validé', 'Suspendu', 'Litige', 'Vendu']
        ];

        $etats = $etatObjectToRentRepository->findAll();

        return $this->render('etat_object_to_rent/index.html.twig', [
            'categories' => $categories,
            'etats' => $etats,
            'etat_object_to_rents' => $etats, // ✅ Ajout pour corriger l’erreur Twig
        ]);
    }

    #[Route('/new', name: 'app_etat_object_to_rent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etatObjectToRent = new EtatObjectToRent();
        $form = $this->createForm(EtatObjectToRentForm::class, $etatObjectToRent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etatObjectToRent);
            $entityManager->flush();

            return $this->redirectToRoute('app_etat_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etat_object_to_rent/new.html.twig', [
            'etat_object_to_rent' => $etatObjectToRent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_object_to_rent_show', methods: ['GET'])]
    public function show(EtatObjectToRent $etatObjectToRent): Response
    {
        return $this->render('etat_object_to_rent/show.html.twig', [
            'etat_object_to_rent' => $etatObjectToRent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etat_object_to_rent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtatObjectToRent $etatObjectToRent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtatObjectToRentForm::class, $etatObjectToRent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etat_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etat_object_to_rent/edit.html.twig', [
            'etat_object_to_rent' => $etatObjectToRent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_object_to_rent_delete', methods: ['POST'])]
    public function delete(Request $request, EtatObjectToRent $etatObjectToRent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etatObjectToRent->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($etatObjectToRent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etat_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
    }
}
