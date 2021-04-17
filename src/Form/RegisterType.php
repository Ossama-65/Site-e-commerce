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

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // input
            ->add('firstname', TextType::class,[
                'label' => 'Votre prénom',
                // pour limiter le nombre de caractére dans input
                'constraints' => new Length(['min'=> 2, 'max' => 20]),
                'attr' =>[
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre Nom',
                'constraints' => new Length(['min'=> 2, 'max' => 20]),
                'attr' =>[
                    'placeholder' => 'Nom'
                ]
            ])

            ->add('email', EmailType::class,[
                'label' => 'Votre Email',
                'constraints' => new Length(['min'=> 2, 'max' => 60]),
                'attr' =>[
                    'placeholder' => 'Email'
                ]
            ])
            ->add('password' , RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                    ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' =>[
                        'placeholder' => 'Confirmer votre mot de passe'
                    ]
                    ]
            ])

            ->add('Submit' , SubmitType::class,[
                'label' => "S'inscire",
                
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
