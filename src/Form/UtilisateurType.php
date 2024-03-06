<?php

namespace App\Form;

use App\Entity\Utilisateur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ["class" =>'input'],
                
                'label' => 'Saisir votre nom :',
                'label_attr' => ['class'=>'label'],
                'required' => true,
            ])
            ->add('prenom', TextType::class,[
                'attr' => ["class" =>'input'],
                
                'label' => 'Saisir votre prénom :',
                'label_attr' => ['class'=>'label'],
                'required' => true,
            ])
            ->add('email',TextType::class,[
                'attr' => ["class" =>'input'],
                
                'label' => 'Saisir votre email :',
                'label_attr' => ['class'=>'label'],
                'required' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
            ])
            ->add('urlImg',TextType::class,[
                'attr' => ["class" =>'input'],
                'label' => 'Saisir votre image :',
                'label_attr' => ['class'=>'label'],
                'required' => false,
            ])
            /* ->add('ajouter', SubmitType::class) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
