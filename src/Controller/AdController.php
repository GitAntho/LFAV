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
            // Gestion de l'utilisateur
            $ad->setAuthor($this->getUser());

            // Gestion de l'image du film
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

    /**
     * Affiche les catégories
     * 
     * @Route("/categories", name="categories")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function category(){
        return $this->render('ad/categories.html.twig');
    }

    /**
     * Affiche les films d'action
     * 
     * @Route("/category/action", name="category_action")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showAction(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Action']
        );

        return $this->render('ad/categories/action.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films d'animation
     * 
     * @Route("/category/animation", name="category_animation")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showAnimation(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Animation']
        );

        return $this->render('ad/categories/animation.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films d'aventure
     * 
     * @Route("/category/adventure", name="category_adventure")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showAdventure(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Aventure']
        );

        return $this->render('ad/categories/adventure.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films de comédie
     * 
     * @Route("/category/comedy", name="category_comedy")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showComedy(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Comédie']
        );

        return $this->render('ad/categories/comedy.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films de drame
     * 
     * @Route("/category/drama", name="category_drama")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showDrama(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Drame']
        );

        return $this->render('ad/categories/drama.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films fantastique
     * 
     * @Route("/category/fantastic", name="category_fantastic")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showFantastic(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Fantastique']
        );

        return $this->render('ad/categories/fantastic.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films historique
     * 
     * @Route("/category/historical", name="category_historical")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showHistorical(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Historique']
        );

        return $this->render('ad/categories/historical.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films d'horreur
     * 
     * @Route("/category/horror", name="category_horror")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showHorror(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Horreur']
        );

        return $this->render('ad/categories/horror.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films policier
     * 
     * @Route("/category/police", name="category_police")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showPolice(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Policier']
        );

        return $this->render('ad/categories/police.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films de romance
     * 
     * @Route("/category/romance", name="category_romance")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showRomance(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Romancce']
        );

        return $this->render('ad/categories/romance.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Affiche les films de science fiction
     * 
     * @Route("/category/sf", name="category_sf")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showSf(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Science Fiction']
        );

        return $this->render('ad/categories/sf.html.twig', [
            'ads' => $ads
        ]);
    }
    /**
     * Affiche les films thriller
     * 
     * @Route("/category/thriller", name="category_thriller")
     *
     * @param AdRepository $repo
     * @return void
     */
    public function showThriller(AdRepository $repo){
        $ads = $repo->findBy(
            ['category' => 'Thriller']
        );

        return $this->render('ad/categories/thriller.html.twig', [
            'ads' => $ads
        ]);
    }
}
