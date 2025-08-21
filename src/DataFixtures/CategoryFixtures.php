<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    // Définition des catégories requises
    public const CATEGORIES_DATA = [
        'Voyages et Aventures',
        'Compétences et Apprentissage',
        'Carrière et Finances',
        'Santé et Bien-être',
        'Créativité et Loisirs',
        'Relations et Social',
        'Actes de Bonté',
        'Expériences uniques',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES_DATA as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);

            // Stocker une référence pour pouvoir l'utiliser dans d'autres fixtures (ex: WishFixtures)
            // La clé de référence sera 'category_travel_and_adventure', 'category_sport', etc.
            $refName = 'category_' . strtolower(str_replace([' ', '&'], ['_', 'and'], $categoryName));
            $this->addReference($refName, $category);
        }

        $manager->flush();
    }
}
