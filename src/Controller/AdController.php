<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Affichage des artciles
     * 
     * @Route("/ads", name="ads")
     */
    public function index(AdRepository $repo){
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet la création d'un article
     *
     * @Route("/ads/create", name="ad_create")
     * 
     * @return Response
     */
    public function create(EntityManagerInterface $manager, Request $request){
        $ad =  new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image = $ad->getImageFilm();

            $file = $image->getFile();

            $name = $ad->getTitle() . '_' . md5(uniqid()) . '.' . $file->guessExtension();

            $file->move('../public/images/film', $name);

            $image->setName($name);

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre film a bien été ajouté'
            );

            return $this->redirectToRoute('ads');
        }

        return $this->render('ad/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Affiche 1 film détaillé
     * 
     * @Route("/ad/{slug}", name="ad_show")
     *
     * @return Response
     */
    public function show(Ad $ad){
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
