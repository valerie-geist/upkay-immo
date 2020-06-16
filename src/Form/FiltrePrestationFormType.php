<?php

namespace App\Form;

use App\Entity\Prestation;
use App\Entity\Ville;
use App\Model\PrestationFiltre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltrePrestationFormType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prestation', EntityType::class, [
                'class' => Prestation::class,
                'required' => false,
                'choice_label' => 'statut'
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'required' => false,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PrestationFiltre::class,
        ]);
    }
}