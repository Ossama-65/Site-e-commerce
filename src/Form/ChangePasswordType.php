<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuiller saisir votre mot de passe actuel'
                ]
            ])

            ->add('new_password' , RepeatedType::class,[
                'type' => PasswordType::class,
                // pour pas avoir d'erreur
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => [

                    'label' => ' Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre nouveau mot de passe'
                    ]
                    ],

                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    'attr' =>[
                        'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                    ]
                    ]
            ])

            // ->add('email', EmailType::class, [
            //     'disabled' => true,
            //     'label' => 'Mon adresse mail'
            // ])

            // ->add('firstname', EmailType::class, [
            //     'disabled' => true,
            //     'label' => 'Mon prénom'
            // ])
            // ->add('lastname' , EmailType::class, [
            //     'disabled' => true,
            //     'label' => 'Mon nom '
            // ])

            ->add('Submit' , SubmitType::class,[
                'label' => "Mettre à jour",
                
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
