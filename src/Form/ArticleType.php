<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'input'],
                'label' => 'Saisir le titre de l\'article',
                'label_attr' => ['class' => 'label_input'],
                'empty_data' => '',
                'required' => true,
            ])
            ->add('dateCreation', DateType::class,[
                'html5' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'input_date'],
                'label' => 'Saisir la date de l\'article',
                'required' => true,
            ])
            ->add('contenu', TextareaType::class,[
                'attr' => ['class' => 'input'],
                'label' => 'Saisir le contenu de l\'article',
                'label_attr' => ['class' => 'label_input'],
                'empty_data' => '',
                'required' => true,
            ])
            ->add('urlImg', TextType::class, [
                'attr' => ['class' => 'input'],
                'label' => 'Saisir l\'image de l\'article',
                'label_attr' => ['class' => 'label_input'],
                'empty_data' => '',
                'required' => false,
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'input_liste'],
                'label' => 'Choisir un utilisateur dans la liste',
                'required' => true,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'input_liste'],
                'label' => 'Choisir des catégories dans la liste',
                'label_attr' => ['class' => 'label_input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
