<?php

namespace App\Form;

use App\Entity\Chauffage;
use App\Entity\TypeChauffage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChauffageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque')
            ->add('puissance')
            ->add('modele')
            ->add('annee_installation', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'mapped' => false,
            ])
            ->add('type', EntityType::class, [
                'class' => TypeChauffage::class,
                'choice_label' => 'nom',
                 'placeholder' => 'Choisir le type de chauffage'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chauffage::class,
        ]);
    }
}
