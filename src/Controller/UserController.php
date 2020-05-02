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

    public function register(Request $request, EntityManagerInterface $manager, User  $user){
        $user = new User();

        $form = $this->createForm(AccountType::class);

        $form->handleRequest($request);

        

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
