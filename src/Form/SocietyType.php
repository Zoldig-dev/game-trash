<?php

namespace App\Form;

use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('numTel', TelType::class)
            ->add('ligne1', TextType::class)
            ->add('ligne2', TextType::class, [
                'required' => false,
            ])
            ->add('ligne3', TextType::class, [
                'required' => false,
            ])
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', CountryType::class)
            ->add('email', EmailType::class)
            ->add('logo', TextType::class)
            ->add('submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Society::class,
        ]);
    }
}
