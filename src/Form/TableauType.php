<?php

namespace App\Form;

use App\Entity\Memoire;
use App\Entity\Tableau;
use App\Form\Field\SearchableEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TableauType extends AbstractType
{


    public function __construct(private UrlGeneratorInterface $url)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('url')
            ->add('imageUrl')
            /*->add('memoires', EntityType::class,[
                'class' => 'App\Entity\Memoire',
                'choice_label' => function (Memoire $memoire) {
                    return $memoire->getTitre();
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])*/
            ->add('memoires', SearchableEntityType::class,[
                'class' => 'App\Entity\Memoire',
                'search' => $this->url->generate('app_get_memoires'),
                'label_property' => 'titre',
                'value_property' => 'id'
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
