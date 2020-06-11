<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Page d'accueil
     * 
     * @Route("/", name="homepage")
     */
    public function index(AdRepository $repo){
        $ads = $repo->findBy([], [
            'createdAt' => 'DESC'
        ], 3, 0);

        return $this->render('home.html.twig', [
            'ads' => $ads
        ]);
    }
}
