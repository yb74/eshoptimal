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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Your firstname",
                'attr' => [
                    'placeholder' => 'Please, enter your firstname'
                ],
                'constraints' => [new NotBlank(), new Length(['min' => 3, 'max' => 30])]
            ])
            ->add('lastname', TextType::class, [
            'label' => "Your lastname",
                'attr' => [
                    'placeholder' => 'Please, enter your lastname'
                ],
                'constraints' => [new NotBlank(), new Length(['min' => 3, 'max' => 30])]
            ])
            ->add('email', EmailType::class, [
                'label' => "Your email",
                'attr' => [
                    'placeholder' => 'Please, enter your email'
                ],
                'constraints' => [new NotBlank(), new Length(['min' => 3, 'max' => 60])]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Sorry, password and confirm password doesn't match",
                'required' => true,
                'first_options' => [
                    'label' => 'Your Password',
                    'attr' => [
                        'placeholder' => "Please, enter your password"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'attr' => [
                        'placeholder' => "Please, confirm your password"
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Register",
                'attr' => [
                    'class' => "btn btn-info btn-block"
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
