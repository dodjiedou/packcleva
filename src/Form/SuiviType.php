<?php

namespace App\Form;

use App\Entity\Suivi;
use App\Entity\Beneficiaire;
use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('observation',TextareaType::class, [
                'label' => "Observation",
                'required'=> false,
                ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de debut de suivi',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de debut de suivi',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('rapport',TextareaType::class, [
                'label' => "Rapport de suivi",
                'required'=> false,
                ])
           
            ->add('visite',EntityType::class, [
                'class' => Visite ::class,
                'choice_label' => 'description',
                'label' => 'Visite concernée',
                'required'=> true,
                'disabled'=> true,
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
