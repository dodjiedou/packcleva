<?php

namespace App\Form;

use App\Entity\Sensibilisation;
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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SensibilisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('domaine',TextType::class,[ 'label' => 'Domaine'])
            ->add('theme',TextType::class,[ 'label' => 'Thème'])
            ->add('datePrevue', DateType::class, [
                'label' => 'Date prévue pour la sensibilisation',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('animateur',TextType::class,[ 'label' => 'Animateur'])
            ->add('facilitateur',TextType::class,[ 'label' => 'Facilitateur'])
            ->add('participantCible',TextType::class,[ 'label' => 'Participant cible'])
            ->add('dateAnnonce', DateType::class, [
                'label' => "Date d'annonce",
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('dateRencontre', DateType::class, [
                'label' => 'Date de rencontre',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('heureDebut', TimeType::class, [
                'label' => 'Heure de debut de la sensibilisation',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('heureFin', TimeType::class, [
                'label' => 'Heure de fin de la sensibilisation',
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('pointcle',TextareaType::class,[ 'label' => 'Point clé de la sensibilisation'])
            ->add('depense',MoneyType::class, [
                'label' => "Depense",
                'currency'=> 'XOF',
                'required'=> false,
                ])
            ->add('indicateurImpact',TextareaType::class,[ 'label' => "Indicateur d'impact"])
             ->add('photo',FileType::class, [
                
                'label' => 'Photo',     
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sensibilisation::class,
        ]);
    }
}
