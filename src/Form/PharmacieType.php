<?php

namespace App\Form;

use App\Entity\Pharmacie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PharmacieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_pharma')
            ->add('telephone')
            ->add('adresse')
            ->add('image', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Image',
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('localisation', CollectionType::class, [
                'label' => false,
                'entry_type' => LocalisationType::class,
                'entry_options' => ['label' => false],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pharmacie::class,
        ]);
    }
}
