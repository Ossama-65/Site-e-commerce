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
                'label' => 'Veuillez rentrer votre nom',
                'attr' => [
                    'placeholder' => 'Nommer votre address'
                ]
            ])
            
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ]
            ])

            ->add('lastname' , TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ]
            ])

            ->add('company' , TextType::class, [
                'label' => 'Votre société',
                'required' => false,
                'attr' => [
                    'placeholder' => '(Facultatif) Entrer le nom de votre société'
                ]
            ])
            ->add('adress' , TextType::class, [
                'label' => 'Veuillez rentrer votre adresse',
                'attr' => [
                    'placeholder' => '7 places du code'
                ]
            ])

            ->add('postal' , TextType::class, [
                'label' => 'Votre code postal ',
                'attr' => [
                    'placeholder' => '77000'
                ]
            ])

            ->add('city' , TextType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'placeholder' => 'Paris'
                ]
            ])

            ->add('country' , CountryType::class, [
                'label' => 'Votre pays',
                'attr' => [
                    'placeholder' => 'Françe'
                ]
            ])

            ->add('phone' , TelType::class, [
                'label' => 'Votre numéro',
                'attr' => [
                    'placeholder' => '07 89 98 25 25'
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-block btn-info'
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
