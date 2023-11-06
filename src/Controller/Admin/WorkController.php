<?php

namespace App\Controller\Admin;

use App\Entity\Work;
use App\Entity\Image;
use App\Form\WorkType;
use App\Repository\ImageRepository;
use App\Repository\WorkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkController extends AbstractController
{
    # Allow to add a new work
    #[Route('/admin/ajouter', name: 'app_admin_add_work')]
    public function add(EntityManagerInterface $manager, Request $request): Response
    {

        $work = new Work();

        $form_chantier = $this->createForm(WorkType::class, $work);
        $form_chantier->handleRequest($request);

        if ($form_chantier->isSubmitted() && $form_chantier->isValid()) {
            $img = $form_chantier->get('chantier')->getData();
            foreach ($img as $images) {
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $photo = new Image();
                $photo->setNom($fichier);
                $work->addWorkImage($photo);
            }
            $manager->persist($work);
            $manager->flush();
        }

        return $this->render('work/add.html.twig', [
            'form_chantier' => $form_chantier->createView(),
        ]);
    }

    # Allow to watch all realisation
    #[Route('/admin/realisation', name: 'app_admin_show_work')]
    public function show(WorkRepository $workRepo): Response
    {
        $realisation = $workRepo->findAll();

        return $this->render('work/show.html.twig', [
            'realisations' => $realisation
        ]);
    }

    # Allow to edit a work
    #[Route('/admin/{id}/editer', name: 'app_admin_edit_work')]
    public function edit(EntityManagerInterface $manager, Request $request, Work $work, ImageRepository $imageRepo): Response
    {
        $oldImage = $imageRepo->findBy(['images' => $work]);

        $form_chantier = $this->createForm(WorkType::class, $work);
        $form_chantier->handleRequest($request);

        if ($form_chantier->isSubmitted() && $form_chantier->isValid()) {

            $img = $form_chantier->get('chantier')->getData();
            foreach ($img as $images) {
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $photo = new Image();
                $photo->setNom($fichier);
                $work->addWorkImage($photo);
            }
            if ($oldImage !== $img) {
                foreach ($oldImage as $old) {
                    unlink($this->getParameter('images_directory') . '/' . $old->getNom());
                    $manager->remove($old);
                    $manager->flush();
                }
            }
            $manager->persist($work);
            $manager->flush();
        }
        return $this->render('work/edit.html.twig', [
            'form_chantier' => $form_chantier->createView(),
            'oldImage' => $oldImage,
        ]);
    }

    # Allow to delete a work and images with an unlink
    #[Route('/admin/realisation/{id}/supprimer', name: 'app_admin_delete_work')]
    public function delete(EntityManagerInterface $manager, Work $work, ImageRepository $imageRepo): Response
    {
        $images = $imageRepo->findBy(['images' => $work]);

        foreach ($images as $image) {
            unlink($this->getParameter('images_directory') . '/' . $image->getNom());
            $manager->remove($image);
            $manager->flush();
        }

        $manager->remove($work);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }
}
