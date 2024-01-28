<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class ApplyOfferType extends AbstractType
{
    // This method builds the form structure for applying to an offer.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             // Adds a TextareaType field for the email content input.
            ->add('email_contain', TextareaType::class, [
                'label' => 'Contenu de l\'Email de candidature <span class="stars-registration">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Renseignez le contenu du mail que vous souhaitez envoyer à l\'employeur'
                ],
                'label' => 'Contenu de l\'Email de candidature *',
                'constraints' => [
                    // Constraint for ensuring the field is not blank.
                    new NotBlank([
                        'message' => "Veuillez rédiger le contenu de votre mail de candidature",
                        ])
                    ]
                ])

            // Adds a SubmitType button to submit the form.
            ->add('save', SubmitType::class, [
                'label' => 'Postuler',
                'attr' => [
                    'class' => 'btn btn-secondary mx-auto d-block m-4'
                ],
            ]);
    }

}
