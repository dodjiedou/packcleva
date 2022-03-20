<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'input' => 'string'
            ])

            ->add('lieuNaissance', TextType::class, [
                'label' => 'Lieu de naissance',
                
            ])
            ->add('sexe', ChoiceType::class, [
             'choices'  => [
             'Masculin' => 'M',
             'Feminun' => 'F',
             
                ],
            'attr' => ['class'=>' w-100'],
            ])
           
            ->add('pays',ChoiceType::class,[ 
                'choices'  => [
               'Togo' => 'Togo',
                ],
                'label' => 'Pays',
                'attr' => ['class'=>' w-100'],
                
             ])
             ->add('region',ChoiceType::class,[ 
                'choices'  => [
               'kara' => 'Kara',
               'Savane' => 'Savane',
               'Centrale' => 'Centrale',
               'Plateaux' => 'Plateaux',
               'Maritime' => 'Maritime',
                ],
                'label' => 'Region',
                 'attr' => ['class'=>' w-100'],
                
             ])
             ->add('prefecture',ChoiceType::class,[ 
                'label' => 'préfecture/Zone',
               'choices'  => [
                'Kpendjal (Mandouri)' => 'Kpendjal (Mandouri)'  ,     
                'Kpendjal-Ouest2 (Naki Est)'=>'Kpendjal-Ouest2 (Naki Est)',
                'Oti (Sansanné-Mango)'=>'Oti (Sansanné-Mango)',
                'Oti-Sud3 (Gando)'=>'Oti-Sud3 (Gando)',
                'Tandjouaré (Tandjouaré)'=>'Tandjouaré (Tandjouaré)',
                'Tone (Dapaong)'=>'Tone (Dapaong)',
                'Kozah (Kara)'=>'Kozah (Kara)',
                'Assoli (Bafilo)'=>'Assoli (Bafilo)',
                'Bassar (Bassar)'=>'Bassar (Bassar)',
                'Binah (Pagouda)'=>'Binah (Pagouda)',
                'Dankpen (Guérin-Kouka)'=>'Dankpen (Guérin-Kouka)',
                'Doufelgou (Niamtougou)'=> 'Doufelgou (Niamtougou)',
                'Kéran (Kandé)'=>'Kéran (Kandé)',
               ' Blitta (Blitta)'=>' Blitta (Blitta)',
                'Mô (Djarkpanga)'=> 'Mô (Djarkpanga)',
                'Sotouboua (Sotouboua)'=>'Sotouboua (Sotouboua)',
                'Tchamba (Tchamba)'=>'Tchamba (Tchamba)',
                'Tchaoudjo (Sokodé)'=>'Tchaoudjo (Sokodé)',
               ' Agou (Agou-Gadjepe)'=>' Agou (Agou-Gadjepe)',
                'Akébou( KOUGNOHOU) '=>'Akébou( KOUGNOHOU) ',
                'Amou (Amlamé)'=>'Amou (Amlamé)',
               ' Anié(ANIE) '=>' Anié(ANIE) ',
                'Danyi (Danyi-Apéyémé)'=>'Danyi (Danyi-Apéyémé)',
                'Est-Mono (Elavagnon)'=>'Est-Mono (Elavagnon)',
                'Haho (Notsé)'=>'Haho (Notsé)',
                'Kloto (Kpalimé)'=>'Kloto (Kpalimé)',
                'Moyen-Mono (Tohoun)'=>'Moyen-Mono (Tohoun)',
                'Ogou (Atakpamé)'=>'Ogou (Atakpamé)',
               ' Wawa (Badou)'=>' Wawa (Badou)',
                'Kpélé (Adéta)'=>'Kpélé (Adéta)',
                'Avé (Kévé)'=>'Avé (Kévé)',
               ' Golfe (Lomé)'=>' Golfe (Lomé)',
                'Lacs (Aného)'=>'Lacs (Aného)',
                'Vo (Vogan)'=>'Vo (Vogan)',
                'Yoto (Tabligbo)'=>'Yoto (Tabligbo)',
               ' Zio (Tsévié)'=>' Zio (Tsévié)',
                ],
                'attr' => ['data-live-search' => true,
                          'class'=>'selectpicker w-100']
             ])
              ->add('adresse',TextType::class,[ 'label' => 'Ville/village'])

               ->add('domicile',TextType::class,[ 
                'label' => 'Domicile/Quartier',
                
             ])

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
                ],
            'attr' => ['class'=>' w-100']
            ])
            ->add('religion', ChoiceType::class, [
             'choices'  => [
             'Catholique' => 'Catholique',
             'Protestant' => 'Protestant',
                ],
                'attr' => ['class'=>' w-100']
            ])
            ->add('nomTuteur',TextType::class,[ 'label' => 'Nom du tuteur/Tutrice'])

            ->add('rangOccupe')
            /*->add('categorie',EntityType::class, [
                //'class' => Categorie::class,
                //'choice_label' => 'nom',
                //'label' => 'Categorie',
               //'attr' => ['data-live-search' => true,
                         // 'class'=>'selectpicker w-100']
                
            //])
            ->add('classecde',EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Classe au CDE',
                //'required'=> true,
                'attr' => ['class'=>' w-100 h-100'],
                
            ])*/
            /*->add('classeaucde', ChoiceType::class, [
            
            'placeholder'=>'veuillez choisir une categorie',
             'label' => 'Classe au CDE',
              'mapped' => false,
            ]);

            $formModifier = function (FormInterface $form, Categorie $category = null) 
           {



                $classeCdes = (null === $category) ? [] : $category->getclasseCdes();

                $form->add('classecde',EntityType::class, [
                     'class' => Classe::class,
                     'choice_label' => 'nom',
                     'label' => 'Classe au CDE',
                     'choices' => $classeCdes
                   
                    
                ]);
           };
         
         $builder->get('categorie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $category = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }
        );*/

                
          
         ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
        ])
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}



/*
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
            ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
        ])
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}

*/