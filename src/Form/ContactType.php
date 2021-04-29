<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Your firstname',
                'attr' => [
                    'placeholder' => 'Please, enter your firstname'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Your lastname',
                'attr' => [
                    'placeholder' => 'Please, enter your lastname'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your email',
                'attr' => [
                    'placeholder' => 'Please, enter your email'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Your message',
                'attr' => [
                    'placeholder' => 'How could we help you ?'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send',
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
