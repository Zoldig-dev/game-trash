<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'firstName',
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'lastName',
                ]
            ])
            ->add('avatar', FileType::class, [
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
                'required' => false,
                'mapped' => false,
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'email',
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}