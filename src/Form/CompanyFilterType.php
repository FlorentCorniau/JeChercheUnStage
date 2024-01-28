<?php

namespace App\Form;

use App\Entity\Intern;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Represents a form type for filtering companies.
 */
class CompanyFilterType extends AbstractType
{
    // This method builds the form structure for filtering companies.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         // Adds an EntityType field for selecting industries.
            ->add('industries', EntityType::class, [
                'label' => 'Veuillez choisir un secteur d\'activité',
                'class' => Industry::class,
                'choice_label' => 'name',
                'mapped' => false // Permet de bypass l'error du au select sans le multiple / expanded
                //'multiple' => true,
                //'expanded' => true,
            ])
            // Adds a SubmitType button for applying the filter.
            ->add('save', SubmitType::class, [
                'label' => 'Filtrer'
            ])
        ;
    }

    // This method configures default options for the form.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intern::class,
        ]);
    }
}
