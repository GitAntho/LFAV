<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(){
        return $this->render('account/index.html.twig');
    }

    /**
     * Création d'un utilisateur
     * 
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager){
        $user = new User();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $image = $user->getAvatar();
            $file = $image->getFile();

            $name = $user->getFullName() . '_' . md5(uniqid()) . '.' . $file->guessExtension();
            $file->move('../public/images/avatar', $name);

            $image->setName($name);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
