<?php

namespace App\Form;

use App\Entity\Contracter;
use App\Entity\Beneficiaire;
use App\Entity\Maladie;
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





class ContracterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class, [
                'label' => "Date de debut de la maladie",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> true,
            ])
            ->add('infoAnalyse',TextareaType::class, [
                'label' => "Information d'analyse",
                'required'=> false,
                ])
            ->add('manifestationMaladie',TextareaType::class, [
                'label' => "Manifestation de la maladie",
                'required'=> false,
                ])
            ->add('produitPrescrit',TextareaType::class, [
                'label' => "Produits prescrits",
                'required'=> false,
                ])
            ->add('debutHospitalisation', DateType::class, [
                'label' => "Debut d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            ->add('finHospitalisation',DateType::class, [
                'label' => "Fin d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            ->add('montantSoin',MoneyType::class, [
                'label' => "Montant des soins",
                'currency'=> 'XOF',
                'required'=> false,
                ])
            ->add('etatBeneficiaire',TextType::class, [
                'label' => "Etat du bénéficiaire après manifestation de la maladie",
                'required'=> false,
                ])
            ->add('nombreVisite',IntegerType::class, [
                'label' => "Nombre de visite",
                'required'=> false,
                ])
            ->add('nombrePrayerSupport',IntegerType::class, [
                'label' => "Nombre de prayer support",
                'required'=> false,
                ])
            ->add('maladie',EntityType::class, [
                'class' => Maladie::class,
                'choice_label' => 'nom',
                'label' => 'Maladie',
                'required'=> true,
                
            ])
            ->add('beneficiaire',EntityType::class, [
                'class' => Beneficiaire::class,
                'choice_label' => 'nom',
                'label' => 'Beneficiaire',
                'required'=> true,
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn btn-primary w-100']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contracter::class,
        ]);
    }
}
