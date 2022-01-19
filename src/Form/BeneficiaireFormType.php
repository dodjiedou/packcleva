<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\Categorie;
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
use App\Entity\Classe;



class BeneficiaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone',NumberType::class, [
                'input'=>'number'])
            ->add('email',EmailType::class, [
                'invalid_message'=>'This value is not valid'])
            
            ->add('dateNaissance', DateType::class, [
                'label' => 'Né(e) le',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('sexe', ChoiceType::class, [
             'choices'  => [
             'Masculin' => 'M',
             'Feminun' => 'F',
                ]])
            ->add('classe' ,ChoiceType::class, [
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
            ->add('religion', ChoiceType::class, [
             'choices'  => [
             'Catholique' => 'Catholique',
             'Protestant' => 'Protestant',
                ]])
            ->add('nomTuteur',TextType::class,[ 'label' => 'Nom du tuteur'])
            ->add('adresse',TextType::class,[ 'label' => 'Rue ou village'])
            ->add('rangOccupe')
            ->add('categorie',EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Categorie',
                
            ])
            ->add('classecde',EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Classe au CDE',
                //'required'=> true,
                
            ])
            ->add('save', SubmitType::class, ['label' => 'Creer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}
