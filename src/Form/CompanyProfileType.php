<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CompanyProfileType extends AbstractType
{
    // Builds the form structure for company profile.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         // Adds an email field with constraints for valid email format.
            ->add('email', TextType::class, [
                'label' => 'Email <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => "VotreEmail@exemple.com"
                ],                
                'constraints' => [
                    // Constraint for ensuring the field is not blank.
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse e-mail',                    
                    ]),
                    // Constraint for ensuring the field has a valid email format.
                    new Email([
                        'message' => 'Veuillez entrer un e-mail valide'
                    ])
                ]
            ])
            // Other fields with similar constraints for company information.
            ->add('name', TextType::class, [
                'label' => 'Nom de votre entreprise <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: Business Corporate'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom d\'entreprise',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 100,
                        // max length allowed by Symfony for security reasons
                        'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractère',
                        'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères',
                    ])
                ]
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

            ->add('siret_number', IntegerType::class, [
                'label' => 'N° de SIRET de votre entreprise <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: Votre numéro de SIRET'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un numéro de SIRET',
                    ]),
                    new Length([
                        'min' => 14,
                        'max' => 14,
                        'minMessage' => 'Le numéro de SIRET doit contenir au minimum {{ limit }} caractères',
                        'maxMessage' => 'Le numéro de SIRET doit contenir au maximum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('linkedin' , UrlType::class, [ // input can be nullable
                'label' => "Lien Linkedin",
                'attr' => [
                    'placeholder' => "Lien Linkedin"
                ]
            ])
            ->add('description' , TextType::class, [// input can be nullable
                'label' => "Description",
                'attr' => [
                    'placeholder' => "Description"
                ]
            ])
            ->add('industries', EntityType::class, [
                'label' => "Secteurs d'activités",
                'class' => Industry::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,     
                ])
             
            // Adds a button for form submission.    
            ->add('save', SubmitType::class, [
                'label' => " Enregistrer les modifications",
                'attr' => [
                    'class' => "btn btn-success btn-sm bi bi-check-all mx-auto d-block m-4"
                ]
            ])
            ;

    }

    // Configures default options for the form.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
