<?php

namespace App\Controller;

use App\Repository\VinylRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserVinylController extends AbstractController
{
    #[Route('/user_vinyl', name: 'app_user_vinyl')]
    public function index(VinylRepository $vinylRepository): Response
    {
        $vinyl1983 = $vinylRepository->findBy(['annee'=>1993]);
        return $this->render('user_vinyl/index.html.twig', [
            'tousMesVinylesDe1983'=>$vinyl1983

        ]);
    }
}
