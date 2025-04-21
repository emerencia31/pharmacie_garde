<?php

namespace App\Form;

use App\Entity\Garde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GardeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_garde')
            ->add('pharmacie')
            ->add('detailGarde', DetailGardeType::class, [
                'label' => false,
//                'entry_type' => DetailGardeType::class,
//                'entry_options' => ['label' => false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garde::class,
        ]);
    }
}
