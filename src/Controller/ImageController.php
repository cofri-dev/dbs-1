<?php

namespace App\Controller;

use App\Entity\Work;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
    # Allow to delete images from edit
    #[Route('/admin/images/{id}/supprimer', name: 'app_admin_delete_image')]
    public function deleteImages(EntityManagerInterface $manager, Image $img, ImageRepository $imageRepo): Response
    {

        $images = $imageRepo->findBy(['images' => $img]);
        unlink($this->getParameter('images_directory') . '/' . $img->getNom());

        foreach ($images as $image) {
            $manager->remove($image);
            $manager->flush();
        }

        $manager->remove($img);
        $manager->flush();


        return $this->redirectToRoute('app_home');
    }
}
