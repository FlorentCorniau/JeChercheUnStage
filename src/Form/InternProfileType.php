<?php

namespace App\Form;


use App\Entity\Intern;
use App\Entity\Industry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InternProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('firstname', TextType::class,[
                'label' => 'Prénom <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr'  => [
                    'placeholder' => "Maxime"
                ],
                'constraints' => [
                    new NotBlank(),              // Ensure the field is not empty
                    new Length(['max' => 64]),  // Limit the maximum length to 64 characters
                ],
                
            ])
          
            ->add('lastname', TextType::class,[
                'label' => 'Nom <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr'  => [
                    'palceholder' => "LE GENTIL"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une région',
                    ]),              // Ensure the field is not empty
                    new Length(['max' => 64]),  // Limit the maximum length to 64 characters
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

            ->add('description', TextareaType::class, [
                'label' => "Description",
                'attr' => [
                    'placeholder' => "Description"
                ],
                'constraints' => [
                    new NotBlank(),              // Ensure the field is not empty
                    // new Length(['max' => 500]),  // Limit the maximum length to 500 characters
                ],

            ])
          
            ->add('linkedin' , UrlType::class, [
                'label' => "Lien Linkedin",
                'attr' => [
                    'placeholder' => "https://www.linkedin.com/in/chokri-kraiem-319b41266"
                ],
                'constraints' => [
                    new Url(), // Ensure the field is a valid URL
                ],
            ])
          
            ->add('imageFile', FileType::class, [ // input can be nullable
                'label' => 'Votre photo de profil',
                'constraints' => [
                    new File([
                        'extensions' => ['png', 'jpeg', 'jpg'],
                        'extensionsMessage' => 'Veuillez choisir un document au format suivant : PNG, JPG'
                    ]),
                ]
            ])
          
            ->add('resumeFile', FileType::class, [ // input can be nullable
                'label' => 'Votre CV',
                'constraints' => [
                    new File([
                        'extensions' => ['pdf'],
                        'extensionsMessage' => 'Veuillez choisir un document au format suivant : PDF'
                    ]),
                ]
            ])
          
            ->add('birthdate' , BirthdayType::class, [
                'label' => 'Date de naissance',
                'input' => 'datetime_immutable',
                'format' => 'dd MMMM  yyyy',
            ])
          
            ->add('industries', EntityType::class, [
                'class' => Industry::class,
                'label' => 'Secteur d\'activité',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, 
            ])
          
            ->add('save', SubmitType::class, [
                'label' => ' Enregister les modifications',
                'attr' => ['class' => 'btn btn-success btn-sm bi bi-check-all mx-auto d-block m-4'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'   => Intern::class 
        ]);
    }
}
