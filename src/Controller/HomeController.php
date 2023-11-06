<?php

namespace App\Controller;

use App\Entity\Work;
use App\Entity\Image;
use App\Repository\WorkRepository;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(WorkRepository $workRepo, ImageRepository $imageRepo): Response
    {

        
        $realisation = $workRepo->findBy([],['dateChantier' => 'DESC'], 4);
        $image = $imageRepo->findBy([], ['id' => 'DESC'], 10);
        

        return $this->render('home/index.html.twig', [
            'realisations' => $realisation,
            'images' => $image
        ]);
    }
}
