<?php

namespace App\Controller\admin;
use App\Entity\Contracter;
use App\Entity\Maladie;
use App\Entity\Beneficiaire;
use App\Form\ContracterFormType;
use App\Repository\BeneficiaireRepository;
use App\Form\ContracterMaladieXType;
use app\Form\RapportType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */

class ContracterController extends AbstractController
{
    
/*
  /contracter
  /consultation
  /showconsultation/{id}
  /contracter_maladie
  /rapport_general
  /rapport_individuel

*/


    #[Route('/contracter', name: 'contracter')]
    public function index(Request $request): Response
    {


        $contracter = new Contracter();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ContracterFormType::class, $contracter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contracter = $form->getData();
            $entityManager->persist($contracter);
            $entityManager->flush();
            return $this->redirectToRoute('contracter');
        }

        
       
        return $this->render('admin/contracter/enregistrement_cas_maladie.html.twig',[
            'form' => $form->createView()]);
    }


    #[Route('/consultation', name: 'consultation')]
    public function consulter(): Response
    {


        $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findAll();
       
        return $this->render('admin/contracter/consultation_soin_medicaux.html.twig',[
            'contracters' => $contracters]);
    }


    #[Route('/showconsultation/{id}', name: 'showconsultation')]
    public function show($id): Response
    {
        
            $contracter = $this->getDoctrine()
            ->getRepository(Contracter::class)->find($id);
            
        return $this->render('admin//contracter/show_consultation.html.twig', compact('contracter'));
    }

    #[Route('/contracter_maladie', name: 'contracter_maladie')]
    public function contracter(Request $request): Response
    {

        $contracter = new Contracter();

        $form = $this->createForm(ContracterMaladieXType::class, $contracter);

        $maladie =  $this->getDoctrine()
            ->getRepository(Contracter::class)->findLastMaladie();
       
       /* Récuperation de tous les bénéficiaires qui n'ont jamais contracter une maladie */   
       $beneficiaireNonMalade =[];
       $beneficiaireMalade =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $listeCasDuBeneficiaire = $this->getDoctrine()
             ->getRepository(Contracter::class)->findContracterByBeneficiaire($beneficiaire,$maladie);

            if ($listeCasDuBeneficiaire == null) {

               array_push($beneficiaireNonMalade, $beneficiaire);

            }else{

                array_push( $beneficiaireMalade, $beneficiaire);

            }
           
       }
       /* !end */
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $maladie = $form->get("maladie")->getData();
           
            
        /* Récuperation de tous les bénéficiaires qui n'ont jamais contracter une maladie */   
        $beneficiaireNonMalade =[];
        $beneficiaireMalade =[];
       $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findAll();
       foreach ($beneficiaires as $key => $beneficiaire) {

        $listeCasDuBeneficiaire = $this->getDoctrine()
             ->getRepository(Contracter::class)->findContracterByBeneficiaire($beneficiaire,$maladie);

            if ($listeCasDuBeneficiaire == null) {

               array_push($beneficiaireNonMalade, $beneficiaire);

            }else{

                array_push( $beneficiaireMalade, $beneficiaire);

            }
           
       }
       /* !end */

                
            return $this->render('admin/contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),'maladie'=>$maladie,'beneficiaireNonMalades'=>$beneficiaireNonMalade,'beneficiaireMalades'=>$beneficiaireMalade]);
        }
        
         return $this->render('admin/contracter/contracter_maladiex.html.twig', ['form' => $form->createView(),'maladie'=>$maladie,'beneficiaireNonMalades'=>$beneficiaireNonMalade,'beneficiaireMalades'=>$beneficiaireMalade]);
        
        
    }

     #[Route('/ajouterCas /{idm}/{idb}', name: 'ajouter_cas')]
    public function ajouterCasMaladie(Request $request,$idm,$idb): Response
    {
        $contracter = new Contracter();
        $entityManager = $this->getDoctrine()->getManager();
        $beneficiaires = $this->getDoctrine()
             ->getRepository(Beneficiaire::class)->findById($idb);

       foreach ($beneficiaires as $key => $value) {

           $beneficiaire=$value;
           
        }
       $maladies = $this->getDoctrine()->getRepository(Maladie::class)->findById($idm);
        foreach ($maladies as $key => $value) {
           $maladie=$value;
        }
   
            
         $form = $this->createFormBuilder()
         ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => function($beneficiaire){
             return $beneficiaire->getNumero()."  "."(".$beneficiaire->getNom().")";
         },
            'label' => 'Numero du Bénéficiaire',
            'query_builder' =>function(BeneficiaireRepository $beneficiaireRepo){
                return $beneficiaireRepo->createQueryBuilder('b')->orderBy('b.nom','ASC');

            },
            'data'=>$beneficiaire,
            'disabled'=>true,
        ])
            ->add('date',DateType::class, [
                'label' => "Date de consultation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> true,
            ])
            
            ->add('manifestationMaladie',TextareaType::class, [
                'label' => "Description de la manifestation de la maladie",
                'required'=> false,
                ])

            ->add('infoAnalyse',TextareaType::class, [
                'label' => "Analyses demandées",
                'required'=> false,
                ])
            ->add('diagnostique',TextareaType::class, [
                'label' => "Diagnostique",
                'required'=> false,
                'mapped'=> false,
                ])

            ->add('produitPrescrit',TextareaType::class, [
                'label' => "Produits prescrits",
                'required'=> false,
                ])
            ->add('montantSoin',MoneyType::class, [
                'label' => "Montant des soins",
                'currency'=> 'XOF',
                'required'=> false,
                ])
            ->add('debutTraitement', DateType::class, [
                'label' => "Debut de traitement",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
                'mapped'=> false,
            ])
            ->add('debutHospitalisation', DateType::class, [
                'label' => "Debut d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            ->add('finHospitalisation',DateType::class, [
                'label' => "Fin d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            
            ->add('etatBeneficiaire',TextType::class, [
                'label' => "Etat du bénéficiaire après manifestation de la maladie",
                'required'=> false,
                ])
            ->add('nombreVisite',IntegerType::class, [
                'label' => "Nombre de visite",
                'required'=> false,
                ])
            ->add('nombrePrayerSupport',IntegerType::class, [
                'label' => "Nombre de prayer support",
                'required'=> false,
                ])
            ->add('maladie',EntityType::class, [
                'class' => Maladie::class,
                'choice_label' => 'nom',
                'label' => 'Maladie',
                'required'=> true,
                'data'=>$maladie,
                'disabled'=>true,

                
            ])
           
            ->add('save', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn btn-primary w-100']])
        
            ->getForm();
                

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
  
            $contracter->setDate($form->get('date')->getData())  ;
            $contracter->setInfoAnalyse($form->get('infoAnalyse')->getData());
            $contracter->setManifestationMaladie($form->get('manifestationMaladie')->getData());
            $contracter->setProduitPrescrit($form->get('produitPrescrit')->getData());
            $contracter->setDebutHospitalisation($form->get('debutHospitalisation')->getData());
            $contracter->setFinHospitalisation($form->get('finHospitalisation')->getData());
            $contracter->setMontantSoin($form->get('montantSoin')->getData());
            $contracter->setEtatBeneficiaire($form->get('etatBeneficiaire')->getData());
            $contracter->setNombreVisite($form->get('nombreVisite')->getData());
            $contracter->setNombrePrayerSupport($form->get('nombrePrayerSupport')->getData());
            $contracter->setMaladie($form->get('maladie')->getData());
             $contracter->setBeneficiaire($form->get('beneficiaire')->getData());          
            $entityManager->persist($contracter);
            $entityManager->flush();
            //$this->addFlash("modifierc", "Opération effectuée avec succès !");
            return $this->redirectToRoute('contracter_maladie');
            
        }

        
       
        return $this->render('admin/contracter/ajouter_cas_maladie.html.twig',[
            'form' => $form->createView()]);
    }



     #[Route('/rapport_general', name: 'rapport_general')]
    public function rapport(): Response
    {
       $casMaladie =[[]];
       
         $maladies=$this->getDoctrine()->getRepository(Maladie::class)->findAll();
         foreach ($maladies as $key => $nom) {
            $beneficiaireM=0;
            $beneficiaireF=0;
            $casF=0;
            $casM=0;
            $montantF=0;
             $montantM=0;
             $contracters=$this->getDoctrine()->getRepository(Contracter::class)->findBy(['maladie'=>$nom]);
             foreach ($contracters as $benef => $contracter) {

                $contract=$this->getDoctrine()->getRepository(Contracter::class)->findByIdContracter($contracter);
             
                if ($contracter->getBeneficiaire()->getSexe()=='M'&& $contract==null ) {
                    $beneficiaireM=$beneficiaireM+1;
                    
                }
                if ($contracter->getBeneficiaire()->getSexe()=='F' && $contract==null) 
                {
                     $beneficiaireF=$beneficiaireF+1;
                     
                }
                if ($contracter->getBeneficiaire()->getSexe()=='M') {
                    $casM=$casM+1;
                    $montantM=$montantM+$contracter->getMontantSoin();
                } else {
                     $casF=$casF+1;
                     $montantF=$montantF+$contracter->getMontantSoin();
                }
                //$montant=$montant+$contracter->getMontantSoin();
             }
              $casMaladie[$key][0]=$key+1;
             $casMaladie[$key][1]=$nom->getNom();
             $casMaladie[$key][2]=$beneficiaireF;
             $casMaladie[$key][3]=$beneficiaireM;
              $casMaladie[$key][4]=($beneficiaireF+$beneficiaireM);
             $casMaladie[$key][5]=$casF;
             $casMaladie[$key][6]=$casM;
             $casMaladie[$key][7]=($casF+$casM);
             $casMaladie[$key][8]=$montantF;  
             $casMaladie[$key][9]=$montantM; 
             $casMaladie[$key][10]=$montantM+$montantF;    

         }
       
        return $this->render('admin/contracter/rapport_general.html.twig',compact('casMaladie'));
    }

     #[Route('/rapport_individuel', name: 'rapport_individuel')]
    public function rapportIndividuel(Request $request): Response
    {
        
         //$contracters = $this->getDoctrine()->getRepository(Contracter::class)->findAll();;
         //$beneficiaire=null;
        
        $form = $this->createFormBuilder()
              ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => function($beneficiaire){
             return $beneficiaire->getNumero()."  "."(".$beneficiaire->getNom().")";
         },
            'label' => 'Numero du Bénéficiaire',
            'query_builder' =>function(BeneficiaireRepository $beneficiaireRepo){
                return $beneficiaireRepo->createQueryBuilder('b')->orderBy('b.nom','ASC');

            },
            'required'=>true,
           
        ])
             ->add('date1', DateType::class, [
                'label' => 'De',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('date2', DateType::class, [
                'label' => 'A',
                'widget' => 'single_text',
                'input' => 'string'
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider','attr'=>['class'=>'btn btn-primary w-100']])
            ->getForm();
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $id = $form->get("beneficiaire")->getData();

            $resultat =$this->getDoctrine()
            ->getRepository(Beneficiaire::class)->findById($id);
             foreach ($resultat as $key => $value) {

                 $beneficiaire=$value;
            }
            $date1 = $form->get("date1")->getData();
            $date2 = $form->get("date2")->getData();
            $contracters = $this->getDoctrine()
            ->getRepository(Contracter::class)->findByBeneficiaire($beneficiaire,$date1,$date2);

           
            return $this->render('admin/contracter/historique_sanitaire.html.twig', ['contracters' => $contracters,
                'date1'=> $date1,
                'date2'=> $date2,
                'beneficiaire'=> $beneficiaire]);
            
        }
        return $this->render('admin/contracter/rapport_individuel.html.twig', ['form'=>$form->createView()]);
    }

     #[Route('/edit_contracter/{id}', name: 'edit_contracter')]
   public function edit(Request $request,$id): Response
     {
        $contracteres = new Contracter();
        
         $entityManager = $this->getDoctrine()->getManager();
        // $firstElement = new Contracter();

         //$form = $this->createForm(ContracterFormType::class, $contracteres);

         $form = $this->createFormBuilder()
         ->add('beneficiaire', EntityType::class, [
            'class' => Beneficiaire ::class,
            'choice_label' => function($beneficiaire){
             return $beneficiaire->getNumero()."  "."(".$beneficiaire->getNom().")";
         },
            'label' => 'Numero du Bénéficiaire',
            'query_builder' =>function(BeneficiaireRepository $beneficiaireRepo){
                return $beneficiaireRepo->createQueryBuilder('b')->orderBy('b.nom','ASC');

            },
           
            'disabled'=>true,
        ])
            ->add('date',DateType::class, [
                'label' => "Date de consultation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> true,
            ])
            
            ->add('manifestationMaladie',TextareaType::class, [
                'label' => "Description de la manifestation de la maladie",
                'required'=> false,
                ])

            ->add('infoAnalyse',TextareaType::class, [
                'label' => "Analyses demandées",
                'required'=> false,
                ])
            ->add('diagnostique',TextareaType::class, [
                'label' => "Diagnostique",
                'required'=> false,
                'mapped'=> false,
                ])

            ->add('produitPrescrit',TextareaType::class, [
                'label' => "Produits prescrits",
                'required'=> false,
                ])
            ->add('montantSoin',MoneyType::class, [
                'label' => "Montant des soins",
                'currency'=> 'XOF',
                'required'=> false,
                ])
            ->add('debutTraitement', DateType::class, [
                'label' => "Debut de traitement",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
                'mapped'=> false,
            ])
            ->add('debutHospitalisation', DateType::class, [
                'label' => "Debut d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            ->add('finHospitalisation',DateType::class, [
                'label' => "Fin d'hospitalisation",
                'widget' => 'single_text',
                'input' => 'string',
                'required'=> false,
            ])
            
            ->add('etatBeneficiaire',TextType::class, [
                'label' => "Etat du bénéficiaire après manifestation de la maladie",
                'required'=> false,
                ])
            ->add('nombreVisite',IntegerType::class, [
                'label' => "Nombre de visite",
                'required'=> false,
                ])
            ->add('nombrePrayerSupport',IntegerType::class, [
                'label' => "Nombre de prayer support",
                'required'=> false,
                ])
            ->add('maladie',EntityType::class, [
                'class' => Maladie::class,
                'choice_label' => 'nom',
                'label' => 'Maladie',
                'required'=> true,
                'disabled'=>true,

                
            ])
           
            ->add('save', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn btn-primary w-100']])
        
            ->getForm();
                

        

       $resultat = $this->getDoctrine()
             ->getRepository(Contracter::class)->findById($id);
       foreach ($resultat as $key => $value) {

                 $contracter=$value;
            }
          
        $form->get('date')->setData($contracter->getDate());
        $form->get('infoAnalyse')->setData($contracter->getInfoAnalyse());
        $form->get('manifestationMaladie')->setData($contracter->getManifestationMaladie());
        $form->get('produitPrescrit')->setData($contracter->getProduitPrescrit());
        $form->get('debutHospitalisation')->setData($contracter->getDebutHospitalisation());
        $form->get('finHospitalisation')->setData($contracter->getFinHospitalisation());
        $form->get('montantSoin')->setData($contracter->getMontantSoin());
        $form->get('etatBeneficiaire')->setData($contracter->getEtatBeneficiaire());
        $form->get('nombreVisite')->setData($contracter->getNombreVisite());
        $form->get('nombrePrayerSupport')->setData($contracter->getNombrePrayerSupport());
        $form->get('maladie')->setData($contracter->getMaladie());
        $form->get('beneficiaire')->setData($contracter->getBeneficiaire());

        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

        $contracter->setDate($form->get('date')->getData())  ;
        $contracter->setInfoAnalyse($form->get('infoAnalyse')->getData());
        $contracter->setManifestationMaladie($form->get('manifestationMaladie')->getData());
        $contracter->setProduitPrescrit($form->get('produitPrescrit')->getData());
        $contracter->setDebutHospitalisation($form->get('debutHospitalisation')->getData());
        $contracter->setFinHospitalisation($form->get('finHospitalisation')->getData());
        $contracter->setMontantSoin($form->get('montantSoin')->getData());
        $contracter->setEtatBeneficiaire($form->get('etatBeneficiaire')->getData());
        $contracter->setNombreVisite($form->get('nombreVisite')->getData());
        $contracter->setNombrePrayerSupport($form->get('nombrePrayerSupport')->getData());
        $contracter->setMaladie($form->get('maladie')->getData());
         $contracter->setBeneficiaire($form->get('beneficiaire')->getData());

         $entityManager->persist($contracter);
          $entityManager->flush();   
         $this->addFlash("modifierc", "modification effectuée avec succès !");
             return $this->redirectToRoute('mes_cas',['idm'=>$contracter->getMaladie()->getId(),
                'idb'=>$contracter->getBeneficiaire()->getId()
         ]);

         
         }

 
        return $this->render('admin/contracter/edit_contracter.html.twig',[
            'form' => $form->createView(),
            'contracter' => $contracter,
        ]);
    }


 #[Route('/mesCas/{idm}/{idb}', name: 'mes_cas')]
   public function mesCas(Request $request,$idm,$idb): Response
     {

      $beneficiaires = $this->getDoctrine()->getRepository(Beneficiaire::class)->findById($idb);
        foreach ($beneficiaires as $key => $value) {
           $beneficiaire=$value;
        }

        $maladies = $this->getDoctrine()->getRepository(Maladie::class)->findById($idm);
        foreach ($maladies as $key => $value) {
           $maladie=$value;
        }

        $contracters =$this->getDoctrine()
             ->getRepository(Contracter::class)->findContracterByBeneficiaire($beneficiaire,$maladie);

             
       
          return $this->render('admin/contracter/mes_cas_maladie.html.twig',[
             'contracters' => $contracters,
             'maladie'=>$maladie,
             'beneficiaire'=>$beneficiaire,
             
         ]);
    }

    #[Route('/showhistorique/{id}', name: 'show_historique')]
    public function showhistorique($id): Response
    {
        
            $contracter = $this->getDoctrine()
            ->getRepository(Contracter::class)->find($id);
            
        return $this->render('admin/contracter/show_historique_sanitaire.html.twig', compact('contracter'));
    }




    
}
