<?php

namespace App\Form;
use App\Entity\Prendre;
use App\Entity\Vaccin;
use App\Entity\Beneficiaire;
use  App\Form\FormInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\VaccinRepository;


class RapportVaccinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
    $builder
         ->add('vaccin', EntityType::class, [
                'class' => Vaccin::class,
                'choice_label' => 'nom',
               'label' => '',
               'query_builder' =>function(VaccinRepository $vaccinRepo){
                return $vaccinRepo->createQueryBuilder('v')->orderBy('v.nom','ASC');

            },
                
            ])

          ->add('save', SubmitType::class, ['label' => 'Valider'])

         ;

      /*  $formModifier = function (Form $form, Vaccin $vaccin = null) 
        {

            $beneficiaires = (null === $vaccin) ? [] : $vaccin->getPrendres()->getBeneficiaire();
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
                $formModifier($event->getForm(), $data->getVaccin());
            }
        );


        $builder->get('vaccin')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $vaccin = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $vaccin);
            }
        )
        ;*/
        
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}



