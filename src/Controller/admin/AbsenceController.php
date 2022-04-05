<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RapportAbsence;
use App\Entity\RapportAbsenceCategorie;
use App\Entity\Classe;
use App\Entity\Categorie;
use App\Entity\Absence;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */


class AbsenceController extends AbstractController
{
     
#[Route('/absence/classe/seance', name: 'absence_classe')]
    public function rapportClasse(Request $request): Response
    {
       $tabAbsent =[[]];
       $classe =$this->getDoctrine()
            ->getRepository(Absence::class)->chooseRandomClasse();
        $seances =  $classe->getSeances();
        foreach ($seances as $key => $value) {
                $garcon=0;
                $fille=0;
                $seance=$value;
               $absences=$seance->getAbsences();
                foreach ($absences as $key => $value) {
                     $absence=$value;
                    if ($absence->getBeneficiaire()->getSexe()=='M') {
                     $garcon= $garcon+1;
                    } else {
                     $fille=$fille+1;
                    }
                }

            $tabAbsent[$key][0]=$seance->getActivite();
             $tabAbsent[$key][1]=$seance->getDateSeance();
             $tabAbsent[$key][2]=$seance->getHeureDebutSeance();
             $tabAbsent[$key][3]=$seance->getHeureFinSeance();
             $tabAbsent[$key][4]=$fille;
             $tabAbsent[$key][5]=$garcon;
             $tabAbsent[$key][6]=( $garcon+$fille);
            
            }

        $form = $this->createFormBuilder()
              ->add('classe', EntityType::class, ['class' => Classe::class,
                'choice_label' => 'nom',
                 'label' => '',
                //'placeholder' => 'choisir'
            ])

          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $classe = $form->get("classe")->getData();
            $seances =  $classe->getSeances();
            foreach ($seances as $key => $value) {
                $garcon=0;
                $fille=0;
                $seance=$value;
                $absences=$seance->getAbsences();
                foreach ($absences as $key => $value) {
                     $absence=$value;
                    if ($absence->getBeneficiaire()->getSexe()=='M') {
                     $garcon= $garcon+1;
                    } else {
                     $fille=$fille+1;
                    }
                }
               

             $tabAbsent[$key][0]=$seance->getActivite();
             $tabAbsent[$key][1]=$seance->getDateSeance();
             $tabAbsent[$key][2]=$seance->getHeureDebutSeance();
             $tabAbsent[$key][3]=$seance->getHeureFinSeance();
             $tabAbsent[$key][4]=$fille;
             $tabAbsent[$key][5]=$garcon;
             $tabAbsent[$key][6]=( $garcon+$fille);
            

            }
            
            return $this->render('admin/absence/absence_classe.html.twig', [
                'form' => $form->createView(),
                'tabAbsent'=> $tabAbsent,
                'classe'=> $classe
            ]);
        }
        
       
         
       
      return $this->render('admin/absence/absence_classe.html.twig', [
        'form' => $form->createView(),
        'tabAbsent'=> $tabAbsent,
        'classe'=> $classe
    ]);
    }




     #[Route('/absence/classe/date', name: 'absence_classe_date')]
     public function absenceClasseDate(Request $request): Response
     {
        $ab=5;
        $tabAbsent=[[]];
         $form = $this->createFormBuilder()
              ->add('date', DateType::class, [
                'label' => 'Date ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])

               ->add('classe', EntityType::class, ['class' => Classe::class,
                'choice_label' => 'nom',
                 'label' => 'Classe',
               
            ])


          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $classe = $form->get("classe")->getData();
            
             $date = $form->get("date")->getData();
             $seances=$this->getDoctrine()
            ->getRepository(Absence::class)->findSeanceByDate($date,$classe);
            $nombreAbsenceFille=0;
            $nombreAbsenceGarcon=0;
            $nombreAbsentFille=0;
            $nombreAbsentGarcon=0;
            $tabBeneficiaires=[];
            foreach ($seances as $key => $value) {
                
                $seance=$value;
                $absences=$seance->getAbsences();
                foreach ($absences as $key => $value) {
                     $absence=$value;
                    if(in_array($absence->getBeneficiaire(), $tabBeneficiaires)==false){
                        if ($absence->getBeneficiaire()->getSexe()=='M') {
                         $nombreAbsentGarcon= $nombreAbsentGarcon+1;
                        } else {
                         $nombreAbsentFille=$nombreAbsentFille+1;
                        }
                        array_push($tabBeneficiaires,$absence->getBeneficiaire());
                    }

                    
                }
               

            }
             $beneficiaires=$classe->getBeneficiaires();
             foreach ($beneficiaires as $key => $value) {
                 $beneficiaire=$value;
                 foreach ($seances as $key => $value) {
                     $seance=$value;
                 $absent=$this->getDoctrine()->getRepository(Absence::class)->verifierAbsence($seance,$beneficiaire);
                      if ( $absent!=null) {
                         if ($beneficiaire->getSexe()=='M') {
                         $nombreAbsenceGarcon= $nombreAbsenceGarcon+1;
                        } else {
                        $nombreAbsenceFille=$nombreAbsenceFille+1;
                        }
                      }
                 }
             }

             $tabAbsent[0][0]=$date;
             $tabAbsent[0][1]=$classe->getNom();
             $tabAbsent[0][2]=$nombreAbsentFille;
             $tabAbsent[0][3]=$nombreAbsentGarcon;
             $tabAbsent[0][4]=$nombreAbsentFille+$nombreAbsentGarcon;
             $tabAbsent[0][5]=$nombreAbsenceFille;
             $tabAbsent[0][6]=$nombreAbsenceGarcon;
             $tabAbsent[0][7]=$nombreAbsenceFille+$nombreAbsenceGarcon;
            
             return $this->render('admin/absence/absence_classe_date.html.twig', [
               'form' => $form->createView(),
                'tabAbsent'=> $tabAbsent,
                ]);
         }

         return $this->render('admin/absence/absence_classe_date.html.twig', [
            'form' => $form->createView(),
            'tabAbsent'=> $tabAbsent,
        ]);
        
     }


     #[Route('/absence/classe/periode', name: 'absence_classe_periode')]
     public function absenceClassePeriode(Request $request): Response
     {
        $ab=5;
        $tabAbsent=[[]];
         $form = $this->createFormBuilder()
              ->add('date1', DateType::class, [
                'label' => 'De ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])

              ->add('date2', DateType::class, [
                'label' => 'A ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])


               ->add('classe', EntityType::class, ['class' => Classe::class,
                'choice_label' => 'nom',
                 'label' => 'Classe',
               
            ])


          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $classe = $form->get("classe")->getData();
            
             $date1 = $form->get("date1")->getData();
              $date2 = $form->get("date2")->getData();
             $seances=$this->getDoctrine()
            ->getRepository(Absence::class)->findSeanceByPeriode($date1,$date2,$classe);
            $nombreAbsenceFille=0;
            $nombreAbsenceGarcon=0;
            $nombreAbsentFille=0;
            $nombreAbsentGarcon=0;
            $tabBeneficiaires=[];
            foreach ($seances as $key => $value) {
                
                $seance=$value;
                $absences=$seance->getAbsences();
                foreach ($absences as $key => $value) {
                     $absence=$value;
                    if(in_array($absence->getBeneficiaire(), $tabBeneficiaires)==false){
                        if ($absence->getBeneficiaire()->getSexe()=='M') {
                         $nombreAbsentGarcon= $nombreAbsentGarcon+1;
                        } else {
                         $nombreAbsentFille=$nombreAbsentFille+1;
                        }
                        array_push($tabBeneficiaires,$absence->getBeneficiaire());
                    }

                    
                }
               

            }
             $beneficiaires=$classe->getBeneficiaires();
             foreach ($beneficiaires as $key => $value) {
                 $beneficiaire=$value;
                 foreach ($seances as $key => $value) {
                     $seance=$value;
                 $absent=$this->getDoctrine()->getRepository(Absence::class)->verifierAbsence($seance,$beneficiaire);
                      if ( $absent!=null) {
                         if ($beneficiaire->getSexe()=='M') {
                         $nombreAbsenceGarcon= $nombreAbsenceGarcon+1;
                        } else {
                        $nombreAbsenceFille=$nombreAbsenceFille+1;
                        }
                      }
                 }
             }

             $tabAbsent[0][0]=$date1;
             $tabAbsent[0][1]=$date2;
             $tabAbsent[0][2]=$classe->getNom();
             $tabAbsent[0][3]=$nombreAbsentFille;
             $tabAbsent[0][4]=$nombreAbsentGarcon;
             $tabAbsent[0][5]=$nombreAbsentFille+$nombreAbsentGarcon;
             $tabAbsent[0][6]=$nombreAbsenceFille;
             $tabAbsent[0][7]=$nombreAbsenceGarcon;
             $tabAbsent[0][8]=$nombreAbsenceFille+$nombreAbsenceGarcon;
            
             return $this->render('admin/absence/absence_classe_periode.html.twig', [
               'form' => $form->createView(),
                'tabAbsent'=> $tabAbsent,
                ]);
          }

         return $this->render('admin/absence/absence_classe_periode.html.twig', [
            'form' => $form->createView(),
            'tabAbsent'=> $tabAbsent,
        ]);
        
     }


#[Route('/absence/categorie/date', name: 'absence_categorie_date')]
     public function absenceCategorieDate(Request $request): Response
     {
        $ab=5;
        $tabAbsent=[[]];
         $form = $this->createFormBuilder()
              ->add('date', DateType::class, [
                'label' => 'Date ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])

               ->add('categorie', EntityType::class, ['class' => Categorie::class,
                'choice_label' => 'nom',
                 'label' => 'Categorie',
               
            ])


          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $categorie = $form->get("categorie")->getData();
            
             $date = $form->get("date")->getData();
             $classes=$categorie->getClasses();

             $nombreAbsenceFille=0;
             $nombreAbsenceGarcon=0;
             $nombreAbsentFille=0;
             $nombreAbsentGarcon=0;
             $tabBeneficiaires=[];

             foreach ($classes as $key => $value) {
                 $classe=$value;

                  $seances=$this->getDoctrine()
                    ->getRepository(Absence::class)->findSeanceByDate($date,$classe);
                    
                    

                foreach ($seances as $key => $value) {
                        
                        $seance=$value;
                        $absences=$seance->getAbsences();
                        foreach ($absences as $key => $value) {
                             $absence=$value;
                            if(in_array($absence->getBeneficiaire(), $tabBeneficiaires)==false){
                                if ($absence->getBeneficiaire()->getSexe()=='M') {
                                 $nombreAbsentGarcon= $nombreAbsentGarcon+1;
                                } else {
                                 $nombreAbsentFille=$nombreAbsentFille+1;
                                }
                                array_push($tabBeneficiaires,$absence->getBeneficiaire());
                            }
                            
                        }
                    }



                    $beneficiaires=$classe->getBeneficiaires();
                     foreach ($beneficiaires as $key => $value) {
                         $beneficiaire=$value;
                         foreach ($seances as $key => $value) {
                             $seance=$value;
                         $absent=$this->getDoctrine()->getRepository(Absence::class)->verifierAbsence($seance,$beneficiaire);
                              if ( $absent!=null) {
                                 if ($beneficiaire->getSexe()=='M') {
                                 $nombreAbsenceGarcon= $nombreAbsenceGarcon+1;
                                } else {
                                $nombreAbsenceFille=$nombreAbsenceFille+1;
                                }
                              }
                         }
                     }

                }


             
            
             
             $tabAbsent[0][0]=$date;
             $tabAbsent[0][1]=$categorie->getNom();
             $tabAbsent[0][2]=$nombreAbsentFille;
             $tabAbsent[0][3]=$nombreAbsentGarcon;
             $tabAbsent[0][4]=$nombreAbsentFille+$nombreAbsentGarcon;
             $tabAbsent[0][5]=$nombreAbsenceFille;
             $tabAbsent[0][6]=$nombreAbsenceGarcon;
             $tabAbsent[0][7]=$nombreAbsenceFille+$nombreAbsenceGarcon;
            
             return $this->render('admin/absence/absence_categorie_date.html.twig', [
               'form' => $form->createView(),
                'tabAbsent'=> $tabAbsent,
                ]);
         }

         return $this->render('admin/absence/absence_categorie_date.html.twig', [
            'form' => $form->createView(),
            'tabAbsent'=> $tabAbsent,
        ]);
        
     }



     #[Route('/absence/categorie/periode', name: 'absence_categorie_periode')]
     public function absenceCategoriePeriode(Request $request): Response
     {
        $ab=5;
        $tabAbsent=[[]];
         $form = $this->createFormBuilder()
              ->add('date1', DateType::class, [
                'label' => 'De ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])

              ->add('date2', DateType::class, [
                'label' => 'A ',
                'widget' => 'single_text',
                'input' => 'string'
               
             ])


               ->add('categorie', EntityType::class, ['class' => Categorie::class,
                'choice_label' => 'nom',
                 'label' => 'Categorie',
               
            ])


          ->add('save', SubmitType::class, ['label' => 'Valider'])
          ->getForm();
        

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $categorie = $form->get("categorie")->getData();

             $classes=$categorie->getClasses();

             $nombreAbsenceFille=0;
             $nombreAbsenceGarcon=0;
             $nombreAbsentFille=0;
             $nombreAbsentGarcon=0;
             $tabBeneficiaires=[];

              foreach ($classes as $key => $value) {
                 $classe=$value;

             $date1 = $form->get("date1")->getData();
              $date2 = $form->get("date2")->getData();
             $seances=$this->getDoctrine()
            ->getRepository(Absence::class)->findSeanceByPeriode($date1,$date2,$classe);
            
            foreach ($seances as $key => $value) {
                
                $seance=$value;
                $absences=$seance->getAbsences();
                foreach ($absences as $key => $value) {
                     $absence=$value;
                    if(in_array($absence->getBeneficiaire(), $tabBeneficiaires)==false){
                        if ($absence->getBeneficiaire()->getSexe()=='M') {
                         $nombreAbsentGarcon= $nombreAbsentGarcon+1;
                        } else {
                         $nombreAbsentFille=$nombreAbsentFille+1;
                        }
                        array_push($tabBeneficiaires,$absence->getBeneficiaire());
                    }

                    
                }
               

            }
             $beneficiaires=$classe->getBeneficiaires();
             foreach ($beneficiaires as $key => $value) {
                 $beneficiaire=$value;
                 foreach ($seances as $key => $value) {
                     $seance=$value;
                 $absent=$this->getDoctrine()->getRepository(Absence::class)->verifierAbsence($seance,$beneficiaire);
                      if ( $absent!=null) {
                         if ($beneficiaire->getSexe()=='M') {
                         $nombreAbsenceGarcon= $nombreAbsenceGarcon+1;
                        } else {
                        $nombreAbsenceFille=$nombreAbsenceFille+1;
                        }
                      }
                 }
             }
         }

             $tabAbsent[0][0]=$date1;
             $tabAbsent[0][1]=$date2;
             $tabAbsent[0][2]=$categorie->getNom();
             $tabAbsent[0][3]=$nombreAbsentFille;
             $tabAbsent[0][4]=$nombreAbsentGarcon;
             $tabAbsent[0][5]=$nombreAbsentFille+$nombreAbsentGarcon;
             $tabAbsent[0][6]=$nombreAbsenceFille;
             $tabAbsent[0][7]=$nombreAbsenceGarcon;
             $tabAbsent[0][8]=$nombreAbsenceFille+$nombreAbsenceGarcon;
            
             return $this->render('admin/absence/absence_categorie_periode.html.twig', [
               'form' => $form->createView(),
                'tabAbsent'=> $tabAbsent,
                ]);
          }

         return $this->render('admin/absence/absence_categorie_periode.html.twig', [
            'form' => $form->createView(),
            'tabAbsent'=> $tabAbsent,
        ]);
        
     }




     

   



}
