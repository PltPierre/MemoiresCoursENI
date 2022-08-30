<?php

namespace App\Form;

use App\Entity\Memoire;
use App\Entity\Tableau;
use App\Form\Field\SearchableEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MermoireType extends AbstractType
{

    public function __construct(private UrlGeneratorInterface $url)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class, [
                'attr' => ['style' => 'height:25vh']
            ])
            ->add('image')
            /*->add('tableaux', EntityType::class,[
                'class' => 'App\Entity\Tableau',
                'choice_label' => function (Tableau $tableau) {
                    return $tableau->getTitre();
                },
                'multiple' => true,
                'expanded' => true
            ])*/
            ->add('tableaux', SearchableEntityType::class,[
                'class' => 'App\Entity\Tableau',
                'search' => $this->url->generate('app_get_tableaux'),
                'label_property' => 'titre',
                'value_property' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memoire::class,
        ]);
    }
}
