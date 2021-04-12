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

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Your firstname",
                'attr' => [
                    'placeholder' => 'Enter your firstname'
                ]
            ])
            ->add('lastname', TextType::class, [
            'label' => "Your lastname",
                'attr' => [
                    'placeholder' => 'Enter your lastname'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Your email",
                'attr' => [
                    'placeholder' => 'Enter your email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Password and confirm password doesn't match",
                'required' => true,
                'first_options' => ['label' => 'Your Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'label' => "Send"
                ]
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
