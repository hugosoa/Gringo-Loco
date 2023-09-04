<?php

namespace App\Form;

use App\Entity\ActuNews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form__control',
                    'min-length' => '5',
                    'max-length' => '255'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 5, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form__textarea',
                ],
                'label' => 'Texte',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            // ->add('article_picture', TextType::class, [
            //     'attr' => [
            //         'class' => 'form__img',
            //     ],
            //     'label' => "URL de l'image",
            //     'label_attr' => [
            //         'class' => 'form__label'
            //     ],
            //     'constraints' => [
            //         new Assert\NotBlank()
            //     ]
            // ])
            ->add('imageFile', VichImageType::class, [
                'attr' => [
                    'class' => 'form__img'
                ],
                'label' => "Image de l'article",
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
                'label' => 'Ajouter mon article',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActuNews::class,
        ]);
    }
}
