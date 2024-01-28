<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationCompanyFormType extends AbstractType
{
    // Builds the form structure for company registration.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Adds an email field with constraints for a valid email format.
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: maxime@oclock.io'
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

             // Adds a password field with constraints for strong passwords.
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe <span class="stars-registration">*</span>',
                'label_html' => true,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    // Constraints for password length and complexity.
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                        // max length allowed by Symfony for security reasons
                        'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.'
                    ]),
                ],
            ])


             // Other fields for company registration with respective constraints.
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
                        'max' => 64,
                        'minMessage' => 'Votre nom d\'entreprise doit contenir au minimum {{ limit }} caractère',
                        'maxMessage' => 'Votre nom d\'entreprise doit contenir au maximum {{ limit }} caractères',
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

            ->add('linkedin', TextType::class, [ // Le champs peut être nullable
                'label' => 'Votre URL Linkedin',
                'attr' => [
                    'placeholder' => 'Exemple: https://www.linkedin.com/in/maxime-le-gentil'
                ]
            ])

            ->add('industries', EntityType::class, [ // Le champs peut être nullable
                // looks for choices from this entity
                'label' => 'Choix du secteur d\'activité',
                
                'class' => Industry::class,
            
                // uses the Industry.name property as the visible option string
                'choice_label' => 'name',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('description', TextareaType::class, [ // Le champs peut être nullable
                'label' => 'Votre description d\'entreprise',
                'attr' => [
                    'placeholder' => 'Exemple: Votre description d\'entreprise',
                    'class' => 'mb-4'
                ]
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'M\'inscrire',
                'attr' => ['class' => 'btn btn-dark mx-auto d-block mt-4'],
            ])
        ;
    }

    // Configures default options for the form.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

            // Retrait des restrictions HTML du formulaire
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!
            ]
        ]);
    }
}
