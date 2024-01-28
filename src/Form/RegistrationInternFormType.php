<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationInternFormType extends AbstractType
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
                    new Email([
                        // Constraint for ensuring the field has a valid email format.
                        'message' => 'Veuillez entrer un e-mail valide'
                    ])
                ]
            ])

            // Adds a password field with constraints for strong passwords.
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe <span class="stars-registration">*</span>',
                'label_html' => true,
                 // Instead of being set directly onto the object, this is read and encoded in the controller
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


             // Other fields for intern registration with respective constraints.
            ->add('firstname', TextType::class, [
                'label' => 'Prénom <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: Maxime'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un prénom',
                    ])
                ]
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: LE GENTIL'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom de famille',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 64,
                        'minMessage' => 'Votre nom de famille doit contenir au minimum {{ limit }} caractère',
                        'maxMessage' => 'Votre nom de famille doit contenir au maximum {{ limit }} caractères',
                    ])
                ]
            ])

            ->add('description', TextareaType::class, [ // Le champs peut être nullable
                'label' => 'Description de votre profil',
                'attr' => [
                    'placeholder' => 'Exemple: Une description'
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

            ->add('linkedin', TextType::class, [ // Le champs peut être nullable
                'label' => 'Votre URL Linkedin',
                'attr' => [
                    'placeholder' => 'Exemple: https://www.linkedin.com/in/maxime-le-gentil/'
                ]
            ])

            ->add('imageFile', FileType::class, [ // Le champs peut être nullable
                'label' => 'Votre photo de profil',
                'constraints' => [
                    new File([
                        'extensions' => ['png', 'jpeg', 'jpg'],
                        'extensionsMessage' => 'Veuillez choisir un document au format suivant : PNG, JPG'
                    ]),
                ]
            ])

            ->add('resumeFile', FileType::class, [ // Le champs peut être nullable
                'label' => 'Votre CV',
                'constraints' => [
                    new File([
                        'extensions' => ['pdf'],
                        'extensionsMessage' => 'Veuillez choisir un document au format suivant : PDF'
                    ]),
                ]
            ])

            ->add('industries', EntityType::class, [ // input can be nullable
                // looks for choices from this entity
                'label' => 'Choix du secteur d\'activité',
                
                'class' => Industry::class,
            
                // uses the Industry.name property as the visible option string
                'choice_label' => 'name',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('birthdate', BirthdayType::class, [ // input can be nullable
                'label' => 'Votre date de naissance',
                'input' => 'datetime_immutable',
                'format' => 'dd MMMM  yyyy', 
                'attr' => ['class' => 'mb-3'],
            ])

            // Adds a button for form submission.
            ->add('save', SubmitType::class, [
                'label' => 'M\'inscrire',
                'attr' => ['class' => 'btn btn-dark mx-auto d-block mt-4'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

            // Removes HTML form restrictions.
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!
            ]
        ]);
    }
}
