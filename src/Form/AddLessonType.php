<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class AddLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'placeholder' => '12-01-2023',
                'attr' => [
                    'min' => strval(date('Y-m-d')),
                    'value' => strval(date('Y-m-d')),
                ],
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'value' => '00:00',
                ],
            ])
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'name',
            ])
            ->add('add', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
