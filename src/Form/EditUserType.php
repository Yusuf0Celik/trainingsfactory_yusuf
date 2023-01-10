<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('insertion', TextType::class, [
                'required' => false
            ])
            ->add('lastname')
            ->add('birthdate', DateType::class, [
                'years' => range(date('Y'), 1950)
            ])
            ->add('username')
            ->add('gender', ChoiceType::class, [
                'attr' => [
                    'class' => ''
                ],
                'choices' => [
                    'Man' => '0',
                    'Vrouw' => '1',
                ]
            ])
            ->add('street')
            ->add('streetnumber')
            ->add('postal_code')
            ->add('city')
            ->add('email')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
