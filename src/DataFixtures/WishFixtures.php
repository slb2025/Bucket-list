<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 25; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->realText(15));
            $wish->setDescription($faker->realText (120));
            $wish->setAuthor($faker->name());
            $wish->setIsPublished($faker->boolean());
            $wish->setDateCreated($faker->dateTime);
            $wish->setDateUpdated($faker->dateTime);

            $manager->persist($wish);
        }


        $manager->flush();
    }
}
