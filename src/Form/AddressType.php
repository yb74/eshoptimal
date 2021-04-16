<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "What name would you want to assign to your address ?",
                'attr' => [
                    'placeholder' => "Name your address"
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Your firstname",
                'attr' => [
                    'placeholder' => "Enter your firstname"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Your lastname",
                'attr' => [
                    'placeholder' => "Enter your lastname"
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Your company",
                'attr' => [
                    'placeholder' => "No mandatory",
                    'required' => false
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Your address",
                'attr' => [
                    'placeholder' => "Enter your address"
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => "Your zip code",
                'attr' => [
                    'placeholder' => "Enter your zip code"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Enter your city",
                'attr' => [
                    'placeholder' => "Enter your city"
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Your country",
                'attr' => [
                    'placeholder' => "Enter your country"
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Your phone number",
                'attr' => [
                    'placeholder' => "Enter your phone number"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Validate",
                'attr' => [
                    'class' => "btn-block btn-info"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
