<?php

namespace App\Form;

use App\Entity\CadeauNiveauEtude;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CadeauNiveauEtudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('nomArticle',TextType::class,[ 'label' => 'Article'])
            ->add('mesureArticle',TextType::class,[ 'label' => 'Mesure'])
             ->add('nombreFille',IntegerType::class, [
                'label' => "Quantité pour les Filles",
                'required'=> false,
                ])
            ->add('nombreGarcon',IntegerType::class, [
                'label' => "Quantité pour les Garçons ",
                'required'=> false,
                ])
            ->add('niveauEtude',ChoiceType::class, [
            'label' => "Niveau d'étude ",
             'choices'  => [
             'CP1' => 'CP1',
             'CP2' => 'CP2',
             'CE1' => 'CE1',
             'CE2' => 'CE2',
             'CM1' => 'CM1',
             'CM2' => 'CM2',
             '6 ième' => '6 IEME',
             '5 ième' => '5 IEME',
             '4 ième' => '4 IEME',
             '3 ième' => '3 IEME',
             'Seconde' => 'Seconde',
             'Prémière' => 'Prémière',
             'Tle' => 'Tle',
                ]])
             ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CadeauNiveauEtude::class,
        ]);
    }
}
