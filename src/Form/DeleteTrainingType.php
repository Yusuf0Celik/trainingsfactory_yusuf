<?php

namespace App\Form;

use App\Entity\Sport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('delete', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-transarent font-semibold text-red-600 p-2 rounded border-2 border-red-600 transition-all hover:bg-red-600 hover:text-white',
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sport::class,
        ]);
    }
}
