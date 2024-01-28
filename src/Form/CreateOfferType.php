<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreateOfferType extends AbstractType
{
    // Builds the form structure for creating an offer.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          // Adds a field for the title of the offer with constraints.
            ->add('title', TextType::class, [
                'label' => 'Intitulé de l\'offre <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Développeur web'
                ],
                'constraints' => [
                    // Constraint for ensuring the field is not blank.
                    new NotBlank([
                        'message' => "Veuillez renseigner l'intitulé de l'offre",
                        ])
                    ]
                ])


            // Adds a field for the description of the offer.
            ->add('description', TextareaType::class, [// Input can be nullable
                'label' => 'Description de l\'offre',
                'attr' => [
                    'placeholder' => 'Missions attendues / Profil Recherché / Avantages...'
                ],
                ])
            
            // Adds a field for selecting the region of the offer.
            ->add('region', ChoiceType::class, [
                'label' => 'Veuillez choisir votre région <span class="stars-registration">*</span>',
                'label_html' => true,
                'choices'  => [
                    'Auvergne-Rhône-Alpes' => 'Auvergne-Rhône-Alpes',
                    'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
                    'Bretagne' => 'Bretagne',
                    'Centre-Val de Loire' => 'Centre-Val de Loire',
                    //'Corse' => 'Corse', // Par PACA
                    'Grand Est' => 'Grand Est',
                    'Hauts-de-France' => 'Hauts-de-France',
                    'Île-de-France' => 'Île-de-France',
                    'Normandie' => 'Normandie',
                    'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
                    'Occitanie' => 'Occitanie',
                    'Pays de la Loire' => 'Pays de la Loire',
                    'Provence-Alpes-Côte d\'Azur' => 'Provence-Alpes-Côte d\'Azur'
                ],
            ])
            
            // Adds a field for specifying the duration of the internship.
            ->add('duration', IntegerType::class, [
                'attr' => [
                    'placeholder' => '90 jours',
                ],
                'label' => 'Durée du stage en jours'
                ])

            // CreatedAt => Managed in "construct" in entity "Offer"    
            // ->add('createdAt')

            // Adds a field for selecting the industry of the offer.
            ->add('industry', EntityType::class, [
                'class' => Industry::class,
                'label' => 'Secteur d\'activité <span class="stars-registration">*</span>',
                'label_html' => true,
                'choice_label' => 'name',
                'multiple' => false,
            ])

            // Adds a button for submitting the form.
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter l\'offre',
                'attr' => [
                    'class' => 'btn btn-secondary mx-auto d-block m-4'
                ],
            ])

        ;
    }

    // Configures default options for the form.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
