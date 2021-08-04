<?php

namespace App\Form;

use App\Entity\Device;
use App\Entity\GameCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('search', SearchType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('support', EntityType::class, [
                'class' => Device::class,
                'choice_label' => 'name',
                'label' => 'Device',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('cat', EntityType::class, [
                'class' => GameCategory::class,
                'choice_label' => 'name',
                'label' => 'Game Category',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', RangeType::class, [
                'required' => false
            ]);
    }
}