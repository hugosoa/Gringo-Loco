<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '5',
                    'max-length' => '255'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '2',
                    'max-length' => '255'
                ],
                'label' => 'Réservation au nom de',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form__textarea',
                ],
                'label' => 'Nombre de personne et demande particulière',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'form__submit',
                ],
                'label' => 'Demande de réservation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
