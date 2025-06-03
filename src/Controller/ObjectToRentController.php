<?php

namespace App\Controller;

use App\Entity\ObjectToRent;
use App\Form\ObjectToRentForm;
use App\Repository\ObjectToRentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/object/to/rent')]
final class ObjectToRentController extends AbstractController
{
    #[Route(name: 'app_object_to_rent_index', methods: ['GET'])]
    public function index(ObjectToRentRepository $objectToRentRepository): Response
    {
        $objects = $objectToRentRepository->findAll();

        return $this->render('object_to_rent/index.html.twig', [
            'object_to_rents' => $objects,
        ]);
    }

    #[Route('/new', name: 'app_object_to_rent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $objectToRent = new ObjectToRent();
        $form = $this->createForm(ObjectToRentForm::class, $objectToRent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }

                $objectToRent->setImageFilename($newFilename);
            }

            $entityManager->persist($objectToRent);
            $entityManager->flush();

            return $this->redirectToRoute('app_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('object_to_rent/new.html.twig', [
            'object_to_rent' => $objectToRent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_object_to_rent_show', methods: ['GET'])]
    public function show(ObjectToRent $objectToRent): Response
    {
        return $this->render('object_to_rent/show.html.twig', [
            'object_to_rent' => $objectToRent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_object_to_rent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ObjectToRent $objectToRent, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ObjectToRentForm::class, $objectToRent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }

                $objectToRent->setImageFilename($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('object_to_rent/edit.html.twig', [
            'object_to_rent' => $objectToRent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_object_to_rent_delete', methods: ['POST'])]
    public function delete(Request $request, ObjectToRent $objectToRent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $objectToRent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($objectToRent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_object_to_rent_index', [], Response::HTTP_SEE_OTHER);
    }
}
