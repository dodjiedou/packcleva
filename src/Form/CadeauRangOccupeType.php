<?php

namespace App\Form;

use App\Entity\CadeauRangOccupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CadeauRangOccupeType extends AbstractType
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
                ])            ->add('rang',IntegerType::class, [
                'label' => "Rang occupé",
                'required'=> false,
                ])
             ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CadeauRangOccupe::class,
        ]);
    }
}
