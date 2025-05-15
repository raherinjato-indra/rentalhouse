<?php

namespace App\Controller;

use App\Entity\Quartier; // On importe l'entité Quartier
use App\Form\QuartierForm; // On importe le formulaire QuartierForm
use Doctrine\ORM\EntityManagerInterface; // Pour gérer les opérations en base de données
use Symfony\Component\HttpFoundation\Request; // Pour récupérer les données HTTP
use Symfony\Component\HttpFoundation\Response; // Pour retourner une réponse HTTP
use Symfony\Component\Routing\Annotation\Route; // Pour définir les routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Contrôleur de base Symfony

#[Route('/quartier')] // Préfixe de route pour toutes les méthodes de ce contrôleur
class QuartierController extends BaseController
{
    #[Route('/', name: 'app_quartier_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupère tous les quartiers depuis la base de données
        $quartiers = $em->getRepository(Quartier::class)->findAll();

        // Rend la vue index avec les quartiers récupérés
        return $this->render('quartier/index.html.twig', [
            'quartiers' => $quartiers,
        ]);
    }

    #[Route('/new', name: 'app_quartier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Crée une nouvelle instance de Quartier
        $quartier = new Quartier();

        // Crée le formulaire basé sur l'entité Quartier
        $form = $this->createForm(QuartierForm::class, $quartier);
        $form->handleRequest($request); // Traite la requête

        // Si le formulaire est soumis et valide, on sauvegarde en BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quartier); // Prépare l'enregistrement
            $em->flush(); // Enregistre dans la base

            // Message flash de succès
            $this->addFlash('success', 'Quartier ajouté avec succès.');

            // Redirection vers la même page pour permettre l’ajout d’un autre quartier
            return $this->redirectToRoute('app_quartier_new');
        }

        // Affiche le formulaire et la liste des quartiers existants
        return $this->render('quartier/new.html.twig', [
            'form' => $form->createView(),
            'quartiers' => $em->getRepository(Quartier::class)->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_quartier_show', methods: ['GET'])]
    public function show(Quartier $quartier): Response
    {
        // Affiche un quartier spécifique
        return $this->render('quartier/show.html.twig', [
            'quartier' => $quartier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quartier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quartier $quartier, EntityManagerInterface $em): Response
    {
        // Crée le formulaire d'édition avec les données existantes du quartier
        $form = $this->createForm(QuartierForm::class, $quartier);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on met à jour
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // Pas besoin de persist, car l'entité est déjà gérée
            $this->addFlash('success', 'Quartier modifié avec succès.');
            return $this->redirectToRoute('app_quartier_new');
        }

        // Affiche le formulaire pré-rempli
        return $this->render('quartier/edit.html.twig', [
            'quartier' => $quartier,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_quartier_delete', methods: ['POST'])]
    public function delete(Request $request, Quartier $quartier, EntityManagerInterface $em): Response
    {
        // Vérifie que le token CSRF est valide avant suppression
        if ($this->isCsrfTokenValid('delete'.$quartier->getId(), $request->request->get('_token'))) {
            $em->remove($quartier); // Supprime
            $em->flush(); // Applique la suppression
            $this->addFlash('success', 'Quartier supprimé avec succès.');
        }

        // Redirection après suppression
        return $this->redirectToRoute('app_quartier_new');
    }
}
