<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration('Le nom de votre film', 'Mettez le nom du film ici')
            )
            ->add(
                'content',
                TextareaType::class,
                $this->getConfiguration('Description complète de votre film', 'Mettez ici toute la description du film')
            )
            ->add(
                'introduction',
                TextareaType::class,
                $this->getConfiguration('Description rapide de votre film', 'Mettez ici une description en quelques ligne du film')
            )
            ->add(
                'coverImage'
            )
            ->add(
                'slug'
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}