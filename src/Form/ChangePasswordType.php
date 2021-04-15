<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => "My email adress"
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => "My firstname"
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => "My lastname"
            ])
            ->add('previous_password', PasswordType::class, [
                'label' => "My current password",
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Please, enter your current password"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => "Sorry, password and confirm password doesn't match",
                'label' => 'My new password',
                'required' => true,
                'first_options' => [
                    'label' => 'My new Password',
                    'attr' => [
                        'placeholder' => "Please, enter your new password"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => "Please, confirm your new password"
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Save changes"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
