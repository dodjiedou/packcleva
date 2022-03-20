<?php

namespace App\Form;

use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('activite',TextType::class, [
                'label' => "Activité ",
                'required'=> true,
            ])
            ->add('dateSeance',DateType::class, [
                'label' => "Date de la séance ",
                'widget' => 'single_text',
                'input' => 'datetime',
                'required'=> true,
            ])
            ->add('heureDebutSeance', TimeType::class, [
                'label' => 'Heure de debut de la séance',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('heureFinSeance', TimeType::class, [
                'label' => 'Heure de fin de la séance',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn btn-primary w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
