<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\ActuNews;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;


class RegistrationFormType extends AbstractType
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
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '2',
                    'max-length' => '255'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '2',
                    'max-length' => '255'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('pseudo', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '5',
                    'max-length' => '255',
                    'placeholder' => 'Facultatif'
                ],
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'form__label',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 255]),
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form__img'
                ],
                'label' => "Photo de profil (facultatif)",
                'label_attr' => [
                    'class' => 'form__label'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form__control',
                    'min-length' => '5',
                    'max-length' => '255'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La taille du mot de passe doit être d\'au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [

                'label' => 'Confirmer le mot de passe',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form__control',
                    'min-length' => '5',
                    'max-length' => '255'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer le mot de passe a nouveau',
                    ]),
                    new Length([
                        'min' => 6,
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'form__submit',
                ],
                'label' => 'Créer mon compte',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
