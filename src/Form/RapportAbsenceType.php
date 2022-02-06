<?php

namespace App\Form;

use App\Entity\RapportAbsence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Classe;


class RapportAbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutPeriode', DateType::class, [
                'label' => 'Debut de période',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('finPeriode', DateType::class, [
                'label' => 'Fin de période',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('effectif',IntegerType::class, ['label' => "Effectif",
                'required'=> false,
                ])
            ->add('nombreAbsence',IntegerType::class, ['label' => "Nombre d'absence",
                'required'=> false,
                ])
            ->add('nombreAbsent',IntegerType::class, ['label' => "Nombre d'absent",
                'required'=> false,
                ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Classe',
                //'placeholder' => 'choisir'
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider','attr'=>['class'=>'btn btn-info w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RapportAbsence::class,
        ]);
    }
}
