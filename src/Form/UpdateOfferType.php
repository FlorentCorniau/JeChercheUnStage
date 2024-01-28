<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Intern;
use App\Entity\Company;
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

class UpdateOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [// Mandatory so a constraint as been set
                'label' => 'Intitulé de l\'offre <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Développeur web'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez renseigner l'intitulé de l'offre",
                    ])
                ]
                ])

            ->add('description', TextareaType::class, [// Input can be nullable
                'label' => 'Description de l\'offre',
                'attr' => [
                    'placeholder' => 'Missions attendues / Profil Recherché / Avantages...'
                ],
                ])

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

            ->add('duration', IntegerType::class, [// Input can be nullable
                'attr' => [
                    'placeholder' => '90 jours'
                ],
                'label' => 'Durée du stage en jours'
                ])

            // CreatedAt => Managed in "construct" in entity "Offer"    
            // ->add('createdAt')

            ->add('industry', EntityType::class, [// Input can be nullable
                'class' => Industry::class,
                'label' => 'Secteur d\'activité',
                'choice_label' => 'name',
                'multiple' => false,
                // Permet d'afficher au format checkbox
                'expanded' => true,
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Modifier l\'offre',
                'attr' => [
                    'class' => 'btn btn-secondary mx-auto d-block m-4'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
