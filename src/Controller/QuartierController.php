<?php

namespace App\Controller;

use App\Entity\Quartier;
use App\Form\QuartierForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuartierController extends AbstractController
{
    #[Route('/quartier', name: 'app_quartier_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $quartiers = $em->getRepository(Quartier::class)->findAll();

        return $this->render('quartier/index.html.twig', [
            'quartiers' => $quartiers,
        ]);
    }

    #[Route('/quartier/new', name: 'app_quartier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $quartier = new Quartier();
        $form = $this->createForm(QuartierForm::class, $quartier);
        $form->handleRequest($request);

        // ✅ Le bloc manquant a été ajouté ici
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quartier);
            $em->flush();

            $this->addFlash('success', 'Quartier ajouté avec succès.');

            return $this->redirectToRoute('app_quartier_new');
        }

        return $this->render('quartier/new.html.twig', [
            'form' => $form->createView(),
            'quartiers' => $em->getRepository(Quartier::class)->findAll(),
        ]);
    }

    #[Route('/quartier/{id}/edit', name: 'app_quartier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quartier $quartier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuartierForm::class, $quartier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Quartier modifié avec succès.');

            return $this->redirectToRoute('app_quartier_index');
        }

        return $this->render('quartier/edit.html.twig', [
            'quartier' => $quartier,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/quartier/{id}', name: 'app_quartier_show', methods: ['GET'])]
    public function show(Quartier $quartier): Response
    {
        return $this->render('quartier/show.html.twig', [
            'quartier' => $quartier,
        ]);
    }

    #[Route('/quartier/{id}', name: 'app_quartier_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $quartier = $em->getRepository(Quartier::class)->find($id);

        if (!$quartier) {
            throw new NotFoundHttpException('Quartier non trouvé.');
        }

        if ($this->isCsrfTokenValid('delete' . $quartier->getId(), $request->request->get('_token'))) {
           /* $imageFilename = $quartier->getImage();
            if ($imageFilename) {
                $imagePath = $this->getParameter('quartier_images_directory') . '/' . $imageFilename;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }*/

            $em->remove($quartier);
            $em->flush();

            $this->addFlash('success', 'Quartier supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_quartier_new');
    }
}
