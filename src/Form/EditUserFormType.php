<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Component\Validator\Constraints as Assert;


class EditUserFormType extends AbstractType
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
            // ->add('imageFile', VichImageType::class, [
            //     'required' => false,
            //     'attr' => [
            //         'class' => 'form__img'
            //     ],
            //     'label' => "Photo de profil (facultatif)",
            //     'label_attr' => [
            //         'class' => 'form__label'
            //     ],
            // ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'form__submit',
                ],
                'label' => 'Modifier mes informations',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
