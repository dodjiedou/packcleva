<?php

namespace App\Form;

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
            ->add('description')
            ->add('numero')
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
            ->add('classe')
            ->add('religion')
            ->add('nomTuteur',TextType::class,[ 'label' => 'Nom du tuteur'])
            ->add('village')
            ->add('rue')
            ->add('rangOccupe')
            ->add('classeCde')
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
