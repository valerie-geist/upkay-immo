<?php

namespace App\Form;

use App\Entity\Bien;

use App\Entity\TypeBien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('etage')
            ->add('ascenceur', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
            ->add('surface')
            ->add('ville', VilleType::class)
            ->add('locataire',LocataireType::class)
            ->add('type_bien', EntityType::class, [
                'class' => TypeBien::class,
                'choice_label' => 'type',
                'placeholder' => 'Choisir le type de bien',
            ])
            ->add('chauffage',ChauffageFormType::class)
            ->add('chauffe_eau', ChauffeEauFormType::class)
            ->add('photo', FileType::class, [
                 'required' => false,
                 'data_class' => NULL
             ])
            // ->add('photo', CollectionType::class, [
            //      'entry_type' => PhotoType::class,
            //      'prototype'			=> true,
            //      'allow_add'			=> true,
            //      'allow_delete'		=> true,
            //      'by_reference' 		=> false,
            //      'required'			=> false,
            //      'label'			=> false,
            //  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
