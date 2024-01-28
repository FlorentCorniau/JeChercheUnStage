<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UpdateAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Adds an email field with constraints for a valid email format.       
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Exemple: prenom-nom@jechercheunstage.com'
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

            // These input are managed in controller in method "create" 
            // ->add('roles')

            // Adds a password field with constraints for strong passwords.
            ->add('password', PasswordType::class, [
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
            // These input are managed by contruc method in entity Admin
            // ->add('createdAt')

            // Other fields for company registration with respective constraints.
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
                        'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractère',
                        'maxMessage' => 'Le mot de passe doit contenir au maximum {{ limit }} caractères',
                    ])
                ]
            ])

            // Adds a button for form submission.
            ->add('save', SubmitType::class, [
                'label' => 'Modifier l\'administrateur',
                'attr' => ['class' => 'btn btn-dark mx-auto d-block mt-4'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
