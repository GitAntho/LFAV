<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user")
     */
    public function index(){
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(){
        return $this->render('account/login.html.twig');
    }

    /**
     * Permet le logout
     * 
     * @Route("/logout", name="logout")
     *
     * @return void
     */
    public function logout(){

    }

    /**
     * Création d'un utilisateur
     * 
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Gestion du password
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            // Gestion de l'avatar
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
