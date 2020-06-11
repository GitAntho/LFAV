<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\InfoImageType;
use App\Form\InfoGlobalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Affiche la page d'un utilisateur
     * 
     * @Route("/user/{slug}", name="user")
     */
    public function index(User $user){
        return $this->render('account/index.html.twig', [
            'user' => $user
        ]);
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

    /**
     * Permet la modification des informations du compte
     *
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     */
    public function editInfo(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        $form = $this->createForm(InfoGlobalType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Vos informations ont bien étés mise à jour"
            );
        }

        return $this->render('account/editInfo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
