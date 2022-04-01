<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

         $Roles = array(
               'Coordonnateur' => 'ROLE_COORDONNATEUR',
               'Assistant' => 'ROLE_ASSISTANT',
               'Agent de santé' => 'ROLE_AGENTDESANTE',
               'Agent de survie' => 'ROLE_AGENTDESURVIE',
               'Comptable' => 'ROLE_COMPTABLE',
            );

        $builder
            ->add('userName', TextType::class, [
                'label' => "Nom d'utilisateur",
                'attr' => ['class' => 'fas fa-user']
                
            ])
            ->add('email',EmailType::class, [
                'invalid_message'=>'This value is not valid',
                'attr' => ['class' => 'fas fa-envelope']
            ])
           ->add('roles',ChoiceType::class,[ 
                'choices'  => [
                'Coordonnateur' => 'ROLE_COORDONNATEUR',
               'Assistant' => 'ROLE_ASSISTANT',
               'Agent de santé' => 'ROLE_AGENTDESANTE',
               'Agent de survie' => 'ROLE_AGENTDESURVIE',
               'Comptable' => 'ROLE_COMPTABLE',
                ],
                'label' => 'Role',
                'multiple' => true,
                //'expanded'=>true,
            
                
               
                
             ])
            ->add('Pleinpassword',RepeatedType::class, [
                'mapped'=>false,
                'type'=>PasswordType::class,
                'invalid_message'=>'The password fields must match',
                 'options'=>[
                 'attr' => ['class' => 'fas fa-lock password-field']],
                 'required'=>true,
                 'first_options'=>['label'=>'Password'],
                 'second_options'=>['label'=>'Confirm Password'],
                 'constraints'=>[
                    new NotBlank,
                    new Length(['min'=>6,'max'=>4096])
                 ]
               
               
            ])
             ->add('save', SubmitType::class, ['label' => 'Valider',
                'attr' => ['class' => 'btn-info w-100']
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
