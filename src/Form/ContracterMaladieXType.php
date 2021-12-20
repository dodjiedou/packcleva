<?php

namespace App\Form;

use App\Entity\Maladie;
use App\Entity\Beneficiaire;
use App\Entity\Contracter;
use  App\Form\FormInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContracterMaladieXType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maladie', EntityType::class, [
                'class' => Maladie::class,
                'choice_label' => 'nom',
                'label' => 'Maladie',
                //'placeholder' => 'choisir'
            ])

            ->add('save', SubmitType::class, ['label' => 'Valider'])

         ;

        /* $formModifier = function (Form $form, Maladie $maladie = null) 
        {

            $beneficiaires = (null === $maladie) ? [] : $maladie->getContracter()->getBeneficiaire();
            $form->add('beneficiaire', EntityType::class, [
                'class' => Beneficiaire::class,
                'choices' => $beneficiaires,
                'choice_label' => 'nom',
               // 'placeholder' => 'choisir',
                'label' => 'Bénéficiaire'
                
            ]);
        };

         $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getMaladie());
            }
        );


        $builder->get('maladie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $maladie = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $maladie);
            }
        ) ;*/

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
