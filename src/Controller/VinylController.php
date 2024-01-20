<?php

namespace App\Controller;

use App\Entity\Vinyl;
use App\Form\VinylType;
use App\Repository\VinylRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Intervention\Image\ImageManagerStatic as Image;

#[Route('/vinyl')]
class VinylController extends AbstractController
{
    #[Route('/', name: 'app_vinyl_index', methods: ['GET'])]
    public function index(VinylRepository $vinylRepository): Response
    {
        // Afficher tous les vinyles
        return $this->render('vinyl/index.html.twig', [
            'vinyls' => $vinylRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vinyl_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer un nouveau vinyle et un formulaire associé
        $vinyl = new Vinyl();
        $form = $this->createForm(VinylType::class, $vinyl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload du fichier mp3
            $mp3 = $form->get('mp3')->getData();
            if ($mp3) {
                $directory = str_replace("\\", "/", $this->getParameter('mp3_directory'))."/";
                $originalName = pathinfo($mp3->getClientOriginalName(), PATHINFO_FILENAME).".mp3";
                $mp3->move($directory, $originalName);
                $vinyl->setAudio($originalName);
            }
            $entityManager->persist($vinyl);
            $entityManager->flush();

            // Pour utiliser le getId, mettre la création d'image après le flush
            $image = $form->get('cover')->getData();
            if ($image) {
                // Création d'un thumbnail
                $imgName = $vinyl->getId().".jpg";
                $directory = str_replace('\\','/', $this->getParameter('cover_directory'))."/";
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $originalName = $originalName.".".$image->guessExtension();
                $image->move($directory, $originalName);

                // Chargement de l'image originale
                $image = Image::make($directory.$originalName);

                // Redimensionnement du thumbnail à une largeur de 300 pixels (par exemple)
                $image->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Sauvegarde du thumbnail
                $image->save($directory.$imgName, IMAGETYPE_JPEG);

                // Suppression de l'image originale
                unlink($directory.$originalName);
            }

            return $this->redirectToRoute('app_vinyl_index', [], Response::HTTP_SEE_OTHER);
        }

        // Afficher le formulaire de création de vinyle
        return $this->render('vinyl/new.html.twig', [
            'vinyl' => $vinyl,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_vinyl_show', methods: ['GET'])]
    public function show(Vinyl $vinyl): Response
    {
        // Afficher les détails d'un vinyle
        return $this->render('vinyl/show.html.twig', [
            'vinyl' => $vinyl,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vinyl_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vinyl $vinyl, EntityManagerInterface $entityManager): Response
    {
        // Gérer la modification d'un vinyle
        $form = $this->createForm(VinylType::class, $vinyl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vinyl_index', [], Response::HTTP_SEE_OTHER);
        }

        // Afficher le formulaire de modification
        return $this->render('vinyl/edit.html.twig', [
            'vinyl' => $vinyl,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_vinyl_delete', methods: ['POST'])]
    public function delete(Request $request, Vinyl $vinyl, EntityManagerInterface $entityManager): Response
    {
        // Supprimer un vinyle
        if ($this->isCsrfTokenValid('delete'.$vinyl->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vinyl);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vinyl_index', [], Response::HTTP_SEE_OTHER);
    }
}
