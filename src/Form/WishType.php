<?php

// Définit le namespace du fichier, ce qui aide à organiser le code et à éviter les conflits de noms.
namespace App\Form;

// Importe les classes nécessaires depuis les composants Symfony et l'entité de l'application.
use App\Entity\Wish; // L'entité Doctrine à laquelle ce formulaire est lié.
use App\Entity\Category; // Importe l'entité Category
use Symfony\Component\Form\AbstractType; // La classe de base pour tous les types de formulaires dans Symfony.
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // Champ de formulaire pour du texte sur plusieurs lignes.
use Symfony\Component\Form\Extension\Core\Type\TextType; // Champ de formulaire pour du texte sur une seule ligne.
use Symfony\Component\Form\FormBuilderInterface; // L'interface pour construire le formulaire.
use Symfony\Component\OptionsResolver\OptionsResolver; // Permet de configurer les options du formulaire.
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Champ de formulaire pour le bouton de soumission.
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Importe le type de champ EntityType

/**
 * Classe WishType qui définit la structure du formulaire pour l'entité Wish.
 * Elle hérite de AbstractType, la classe de base des formulaires Symfony.
 */
class WishType extends AbstractType
{
    /**
     * Construit les champs du formulaire.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire qui permet d'ajouter les champs.
     * @param array $options Les options passées au formulaire.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Utilise le $builder pour ajouter les différents champs du formulaire.
        $builder
            // Ajoute le champ 'title'. Il est de type TextType (un simple champ de texte).
            ->add('title', TextType::class, [
                'label' => 'Votre souhait', // Le libellé qui sera affiché à côté du champ.
            ])
            // Ajoute le champ 'description'. Il est de type TextareaType (une zone de texte).
            ->add('description', TextareaType::class, [
                'label' => 'Petite description ?', // Le libellé du champ.
                'required' => false, // Indique que ce champ n'est pas obligatoire.
            ])
            // Ajoute le champ 'author'. Il est de type TextType.
            ->add('author', TextType::class, [
                'label' => 'Votre nom', // Le libellé du champ.
            ])
            // Ajoute le champ 'category' de type EntityType
            // Cela affichera une liste déroulante avec les catégories de la base de données
            ->add('category', EntityType::class, [
                'class' => Category::class, // Spécifie l'entité liée au champ
                'choice_label' => 'name', // Utilise la propriété 'name' de l'entité Category pour l'affichage dans la liste
                'label' => 'Catégorie', // Le libellé du champ
                'placeholder' => '-- Choisir une catégorie --', // Optionnel : texte affiché par défaut
            ])
            // Ajoute le bouton de soumission du formulaire.
            ->add("create", SubmitType::class, [
                'label' => 'Créer', // Le texte affiché sur le bouton.
            ]);
    }

    /**
     * Configure les options par défaut pour ce type de formulaire.
     *
     * @param OptionsResolver $resolver L'objet qui gère les options du formulaire.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Lie ce formulaire à la classe d'entité 'Wish'.
            // Symfony utilisera cette information pour hydrater un objet Wish
            // avec les données du formulaire et pour la validation.
            'data_class' => Wish::class,
        ]);
    }
}
