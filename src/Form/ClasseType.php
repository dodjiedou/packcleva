<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Categorie;
use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('categorie',EntityType::class, ['class' => Categorie::class,'choice_label' => 'nom','label' => 'Categorie'])
             ->add('annee', ChoiceType::class, [
             'label' => 'Année',
             'choices'  => [
             'Prémière année' => 'Prémière année',
             'Deuxième année' => 'Deuxième année',
             'Troisième année' => 'Troisième année',
             'Quatrième année' => 'Quatrième année',
                ]])
            ->add('save', SubmitType::class, ['label' => 'Creer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
