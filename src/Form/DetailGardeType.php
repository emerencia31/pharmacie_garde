<?php

namespace App\Form;

use App\Entity\DetailGarde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailGardeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', DateType::class,
                [
                    'label' => "Date de début",
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add('date_fin', DateType::class,
                [
                    'label' => "Date de fin",
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add('heure_debut', TimeType::class,
                [
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => "Heure de début",
                    'attr' => [
                        'class' => 'heure form-control'
                    ]
                ]
            )
            ->add('heure_fin', TimeType::class,
                [
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => "Heure de fin",
                    'attr' => [
                        'class' => 'heure form-control'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailGarde::class,
        ]);
    }
}
