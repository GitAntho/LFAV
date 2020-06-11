<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InfoGlobalType extends ApplicationType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
