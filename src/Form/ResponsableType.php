<?php

namespace App\Form;

use App\Entity\Responsable;
use App\Entity\User;
use App\Repository\ResponsableRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
//            ->add('pharmacies')
            ->add('clause', ChoiceType::class,
                [
                    'choices' => ['CDD' => "CDD", 'CDI' => 'CDI'],
                    'mapped' => false
//                    'label' => false,
//                    'attr' => ['class' => 'form-control form-select']
                ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choices' => $this->userRepository->findUserNotResponsable()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
