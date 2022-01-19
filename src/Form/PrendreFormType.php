<?php

namespace App\Form;

use App\Entity\Prendre;
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
use App\Entity\Beneficiaire;
use App\Entity\Vaccin;


class PrendreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datep', DateType::class, [
                'label' => 'Date de vaccination',
                'widget' => 'single_text',
                 'input' => 'string'
                
            ])
            ->add('dose', ChoiceType::class, [
             'choices'  => [
             'Premier dose' => '1',
             'Deuxième dose' => '2',
             'Troisième dose' => '3',
                ]])
            ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => 'nom',
            'label' => 'Numero du Bénéficiaire',])
            ->add('vaccin', EntityType::class, [
            'class' => Vaccin ::class,
            'choice_label' => 'nom'])
             ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prendre::class,
        ]);
    }
}
