<?php

namespace App\Form;

use App\Entity\Memoire;
use App\Entity\Tableau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('url')
            ->add('imageUrl')
            ->add('memoires', EntityType::class,[
                'class' => 'App\Entity\Memoire',
                'choice_label' => function (Memoire $memoire) {
                    return $memoire->getTitre();
                },
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
