<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditUserPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form__control',],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre mot de passe actuel s\'il vous plait',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Saisissez le nouveau mot de passe',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'mapped' => false,
                'attr' => [
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
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer le nouveau mot de passe',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'mapped' => false,
                'attr' => [
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
