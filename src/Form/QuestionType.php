<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Lettre;
use App\Entity\Reponse;
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

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateQuestion', DateType::class, [
                'label' => "Date",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
             ->add('lettre', EntityType::class, [
                'class' => Lettre ::class,
                'choice_label' => 'Correspondant',
                'label' => 'Vruillez choisir la lettre',
                'disabled' => true,
            ])
            ->add('libelle',TextareaType::class,[ 'label' => 'Vruillez saisir la question'])
            
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
