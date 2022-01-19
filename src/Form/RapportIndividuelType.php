<?php

namespace App\Form;

use App\Entity\Contracter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Beneficiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RapportIndividuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'De',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('finHospitalisation', DateType::class, [
                'label' => 'A',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Nom du Bénéficiaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contracter::class,
        ]);
    }
}
