<?php

namespace App\Form;

use App\Model\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Jméno',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Příjmení',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefon',
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'label' => 'E-mail'
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Poznámka',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Uložit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
