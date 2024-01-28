<?php

namespace App\Form;


use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OfferFilterType extends AbstractType
{
    // Builds the form structure for filtering offers.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Adds a field for selecting industries for filtering.
            ->add('industries', EntityType::class, [
                'label' => 'Veuillez choisir un secteur d\'activité',
                'class' => Industry::class,
                'choice_label' => 'name',
                'mapped' => false // Bypasses the error due to select without multiple/expanded
                //'multiple' => true,
                //'expanded' => true,
            ])

            // Adds a button for applying the filter.
            ->add('save', SubmitType::class, [
                'label' => 'Filtrer'
            ])
        ;
    }

}
