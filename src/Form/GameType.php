<?php

namespace App\Form;

use App\Entity\Device;
use App\Entity\Forum;
use App\Entity\Game;
use App\Entity\GameCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'title',
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ]
            ])
            ->add('launchAt', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Launch At',
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Price',
                ]
            ])
            ->add('pathImg', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Images',
                ]
            ])
            ->add('gameCategory', EntityType::class, [
                'class' => GameCategory::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('devices', EntityType::class, [
                'class' => Device::class,
                'choice_label' => 'name',
                'label' => 'Device',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
