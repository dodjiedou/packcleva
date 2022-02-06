<?php

namespace App\Form;

use App\Entity\Lettre;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LettreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire ::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire ',
            ])
            ->add('correspondant',TextType::class,[ 'label' => 'Correspondant'])
            ->add('envoiReception', ChoiceType::class, [
             'label' => 'Lettre reçue ou envoyée', 
             'choices'  => [
             'Reçue' => 'Reçue',
             'Envoyée' => 'Envoyée',
                ]])
            ->add('dateExpedition', DateType::class, [
                'label' => "Date d'expédition",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date de reception',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Valider',
                  'attr' => ['class' => 'btn-primary w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lettre::class,
        ]);
    }
}
