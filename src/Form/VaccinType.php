<?php

namespace App\Form;

use App\Entity\Vaccin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VaccinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[ 'label' => 'Nom du vaccin'])
             ->add('save', SubmitType::class, ['label' => 'Creer',
                'attr'=>['class'=>'btn btn-primary w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccin::class,
        ]);
    }
}
