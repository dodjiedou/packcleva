<?php

namespace App\Form;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportIndividuelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'numero',
                'label' => 'Numero du Bénéficiaire',
            ])
             ->add('date1', DateType::class, [
                'label' => 'De',
                'widget' => 'single_text',
                'input' => 'string'
            ])
             ->add('date2', DateType::class, [
                'label' => 'A',
                'widget' => 'single_text',
                'input' => 'string'
            ])
             ->add('save', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
