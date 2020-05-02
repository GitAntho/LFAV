<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration('Votre prénom', 'Mettez ici votre prénom')
            )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration('Votre nom', 'Mettez ici votre nom')
            )
            ->add(
                'email',
                TextType::class,
                $this->getConfiguration('Votre adresse mail', 'Mettez ici votre adresse main')
            )
            ->add(
                'password',
                PasswordType::class,
                $this->getConfiguration('Votre mot de passe', 'Mettez ici votre mot de passe')
            )
            ->add(
                'avatar',
                ImageType::class,
                ['label' => false]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
