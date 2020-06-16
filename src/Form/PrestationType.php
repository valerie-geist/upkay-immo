<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Intervention;
use App\Entity\Prestation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intervention', EntityType::class, [
                'class' => Intervention::class,
                'placeholder' => 'Selectionner une prestation',
                'mapped' => false,
                'required' => false
            ])
        ;
        $builder->get('intervention')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addCategorieField($form->getParent(), $form->getData());
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                $this->addCategorieField($form, null);
                }
        );
    }

        private function addCategorieField(FormInterface $form, ?Intervention $intervention)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'categorie',
            EntityType::class,
            null,
            [
                'class'           => Categorie::class,
                'placeholder'     => $intervention ? 'Sélectionnez une catégorie' : 'Sélectionnez une prestation pour choisir la catégorie',
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $intervention ? $intervention->getCategories() : []
            ]
        );
        $form->add($builder->getForm());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestation::class,
        ]);
    }
}
