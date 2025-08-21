<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category; // Assurez-vous d'importer la classe Category si elle n'est pas déjà là

class WishFixtures extends Fixture implements DependentFixtureInterface
{
    // Définition de la liste de 100 souhaits classifiés
    // Les clés de ce tableau DOIVENT correspondre EXACTEMENT aux noms des catégories dans CategoryFixtures::CATEGORIES_DATA
    const WISH_LIST = [
        'Voyages et Aventures' => [
            ['title' => 'Visiter les 7 merveilles du monde', 'description' => 'Découvrir les sites les plus emblématiques de la planète, de la Grande Muraille au Taj Mahal.'],
            ['title' => 'Voir une aurore boréale en Islande', 'description' => 'Assister à ce spectacle céleste magique dans les cieux arctiques.'],
            ['title' => 'Faire un safari en Afrique', 'description' => 'Observer la faune sauvage dans son habitat naturel.'],
            ['title' => 'Randonner sur la Grande Muraille de Chine', 'description' => 'Marcher sur cette structure historique impressionnante.'],
            ['title' => 'Voyager en train à travers l\'Europe', 'description' => 'Explorer différentes cultures et paysages sans prendre l\'avion.'],
            ['title' => 'Faire une croisière en Antarctique', 'description' => 'Découvrir les paysages glacés et la faune unique du pôle Sud.'],
            ['title' => 'Explorer les temples d\'Angkor Wat au Cambodge', 'description' => 'Se plonger dans l\'histoire et l\'architecture ancienne.'],
            ['title' => 'Passer une nuit dans un igloo', 'description' => 'Vivre une expérience unique dans un habitat de glace.'],
            ['title' => 'Faire un road trip sur la Route 66 aux États-Unis', 'description' => 'Parcourir cette route mythique et découvrir l\'Amérique profonde.'],
            ['title' => 'Plonger sur la Grande Barrière de Corail', 'description' => 'Nager parmi les coraux et la vie marine colorée.'],
            ['title' => 'Visiter la Patagonie', 'description' => 'Admirer les paysages grandioses de l\'Amérique du Sud.'],
            ['title' => 'Aller à l\'Oktoberfest à Munich', 'description' => 'Participer à la célèbre fête de la bière allemande.'],
            ['title' => 'Faire du parapente au-dessus des Alpes', 'description' => 'Voler comme un oiseau au-dessus des montagnes majestueuses.'],
            ['title' => 'Voir le lever du soleil sur le Taj Mahal', 'description' => 'Assister à ce moment magique sur l\'un des plus beaux monuments du monde.'],
            ['title' => 'Faire une retraite de yoga en Inde', 'description' => 'Se ressourcer et approfondir sa pratique du yoga dans son berceau.'],
            ['title' => 'Traverser le désert du Sahara à dos de chameau', 'description' => 'Expérience immersive dans le plus grand désert du monde.'],
            ['title' => 'Assister au festival des lanternes en Thaïlande', 'description' => 'Participer à cette célébration illuminée et poétique.'],
            ['title' => 'Naviguer dans les fjords de Norvège', 'description' => 'Découvrir des paysages côtiers spectaculaires.'],
            ['title' => 'Se perdre dans les rues de Tokyo', 'description' => 'Explorer la culture vibrante et les quartiers animés de la capitale japonaise.'],
            ['title' => 'Visiter le Machu Picchu au Pérou', 'description' => 'Découvrir la cité inca perdue, nichée dans les montagnes.'],
        ],
        'Compétences et Apprentissage' => [
            ['title' => 'Apprendre une nouvelle langue', 'description' => 'Maîtriser une langue étrangère pour voyager ou travailler.'],
            ['title' => 'Savoir jouer d\'un instrument de musique', 'description' => 'Jouer mes chansons préférées au piano ou à la guitare.'],
            ['title' => 'Maîtriser un logiciel de montage vidéo', 'description' => 'Créer et éditer mes propres films et vidéos.'],
            ['title' => 'Apprendre à coder un site web', 'description' => 'Comprendre le fonctionnement du web et créer mes propres projets.'],
            ['title' => 'Suivre un cours de poterie', 'description' => 'Façonner des objets uniques avec mes mains.'],
            ['title' => 'Apprendre à faire du pain au levain', 'description' => 'Maîtriser l\'art de la boulangerie traditionnelle.'],
            ['title' => 'S\'initier à la méditation', 'description' => 'Développer la pleine conscience et la sérénité intérieure.'],
            ['title' => 'Devenir un expert en jardinage', 'description' => 'Cultiver mes propres légumes et créer un jardin fleuri.'],
            ['title' => 'Apprendre à prendre des photos professionnelles', 'description' => 'Capturer des moments inoubliables avec un regard artistique.'],
            ['title' => 'Obtenir son permis de bateau', 'description' => 'Naviguer sur les lacs et les mers en toute autonomie.'],
            ['title' => 'Apprendre à dessiner des portraits', 'description' => 'Reproduire les visages et les expressions humaines.'],
            ['title' => 'Suivre un cours d\'improvisation théâtrale', 'description' => 'Développer la spontanéité et la confiance en soi.'],
            ['title' => 'Apprendre à investir en bourse', 'description' => 'Comprendre les marchés financiers et faire fructifier mes économies.'],
            ['title' => 'Écrire un recueil de poèmes', 'description' => 'Exprimer mes émotions et mes pensées à travers la poésie.'],
            ['title' => 'Apprendre l\'art de la mixologie', 'description' => 'Créer des cocktails originaux et délicieux.'],
        ],
        'Carrière et Finances' => [
            ['title' => 'Créer ma propre entreprise', 'description' => 'Lancer un projet entrepreneurial qui me passionne.'],
            ['title' => 'Écrire et publier un livre', 'description' => 'Partager mes idées et mes histoires avec le monde.'],
            ['title' => 'Atteindre l\'indépendance financière', 'description' => 'Ne plus avoir à me soucier de l\'argent.'],
            ['title' => 'Donner une conférence devant un large public', 'description' => 'Partager mon expertise et inspirer les autres.'],
            ['title' => 'Devenir mentor pour une personne plus jeune', 'description' => 'Transmettre mes connaissances et mon expérience.'],
            ['title' => 'Avoir un investissement immobilier', 'description' => 'Construire un patrimoine durable.'],
            ['title' => 'Travailler en tant que digital nomad', 'description' => 'Combiner le travail et le voyage en toute liberté.'],
            ['title' => 'Lancer un podcast à succès', 'description' => 'Partager mes passions et mes réflexions avec une audience.'],
            ['title' => 'Créer un produit que les gens aiment', 'description' => 'Développer quelque chose d\'utile et d\'apprécié.'],
            ['title' => 'Rembourser toutes mes dettes', 'description' => 'Atteindre la liberté financière.'],
            ['title' => 'Avoir une source de revenu passive', 'description' => 'Gagner de l\'argent sans effort continu.'],
            ['title' => 'Créer une association caritative', 'description' => 'Contribuer à une cause qui me tient à cœur.'],
        ],
        'Santé et Bien-être' => [
            ['title' => 'Courir un marathon', 'description' => 'Repousser mes limites physiques et mentales.'],
            ['title' => 'Faire une détox digitale d\'un mois', 'description' => 'Me déconnecter pour me reconnecter à moi-même.'],
            ['title' => 'Atteindre mon poids de forme', 'description' => 'Me sentir bien dans mon corps et avoir une bonne énergie.'],
            ['title' => 'Faire un triathlon', 'description' => 'Réaliser cette épreuve sportive combinant natation, vélo et course.'],
            ['title' => 'Adopter une routine de sommeil régulière', 'description' => 'Améliorer ma qualité de vie grâce à un bon repos.'],
            ['title' => 'Apprendre à cuisiner des plats sains', 'description' => 'Manger équilibré et savoureux au quotidien.'],
            ['title' => 'Faire 100 pompes d\'affilée', 'description' => 'Développer ma force physique.'],
            ['title' => 'Faire un jeûne prolongé', 'description' => 'Expérience de purification et de régénération du corps.'],
            ['title' => 'Vivre sans sucre pendant 30 jours', 'description' => 'Réduire ma dépendance au sucre pour une meilleure santé.'],
            ['title' => 'Faire une retraite de silence', 'description' => 'Explorer mon monde intérieur dans le calme et la tranquillité.'],
        ],
        'Créativité et Loisirs' => [
            ['title' => 'Créer un tableau de ma famille', 'description' => 'Immortaliser les visages de mes proches sur toile.'],
            ['title' => 'Construire un meuble de mes propres mains', 'description' => 'Fabriquer une pièce unique pour ma maison.'],
            ['title' => 'Chanter dans un groupe de musique', 'description' => 'Partager ma passion pour la musique avec d\'autres.'],
            ['title' => 'Fabriquer mes propres vêtements', 'description' => 'Créer une garde-robe unique et personnalisée.'],
            ['title' => 'Créer une bande dessinée', 'description' => 'Raconter une histoire en images.'],
            ['title' => 'Participer à un atelier d\'écriture', 'description' => 'Affiner mes compétences narratives et ma créativité.'],
            ['title' => 'Faire un film amateur', 'description' => 'Réaliser un court-métrage avec mes amis.'],
            ['title' => 'Apprendre à jongler avec 3 balles', 'description' => 'Maîtriser cet art amusant et impressionnant.'],
            ['title' => 'Exposer mes œuvres dans une galerie', 'description' => 'Partager ma passion artistique avec le public.'],
            ['title' => 'Collectionner 100 vinyles de mes artistes préférés', 'description' => 'Construire une collection musicale unique.'],
            ['title' => 'Me faire tatouer un motif symbolique', 'description' => 'Marquer un événement ou une idée importante sur ma peau.'],
            ['title' => 'Créer un jeu de société', 'description' => 'Inventer un jeu amusant pour mes amis et ma famille.'],
        ],
        'Relations et Social' => [
            ['title' => 'Organiser une réunion de famille', 'description' => 'Rassembler tous les membres de ma famille pour un moment inoubliable.'],
            ['title' => 'Renouer avec un vieil ami', 'description' => 'Reprendre contact avec une personne chère perdue de vue.'],
            ['title' => 'Faire un voyage en famille', 'description' => 'Créer des souvenirs précieux avec mes proches.'],
            ['title' => 'Devenir bénévole pour une cause qui me tient à cœur', 'description' => 'Donner de mon temps pour aider les autres.'],
            ['title' => 'Adopter un animal de compagnie', 'description' => 'Accueillir un nouveau membre dans ma famille.'],
            ['title' => 'Écrire une lettre d\'amour à mes parents', 'description' => 'Exprimer ma gratitude et mon affection.'],
            ['title' => 'Organiser un grand dîner pour tous mes amis', 'description' => 'Rassembler mes amis pour une soirée festive.'],
            ['title' => 'Créer une tradition de Noël en famille', 'description' => 'Instaurer un rituel annuel pour les fêtes.'],
            ['title' => 'Faire partie d\'un club de lecture', 'description' => 'Discuter de livres et partager mes lectures.'],
            ['title' => 'Fêter mon anniversaire dans un autre pays', 'description' => 'Célébrer ma naissance dans un nouveau cadre.'],
        ],
        'Actes de Bonté' => [
            ['title' => 'Offrir un repas à une personne dans le besoin', 'description' => 'Apporter un peu de réconfort à quelqu\'un en difficulté.'],
            ['title' => 'Faire un don important à une association', 'description' => 'Soutenir financièrement une cause qui me tient à cœur.'],
            ['title' => 'Organiser une collecte de fonds', 'description' => 'Mobiliser des ressources pour une bonne cause.'],
            ['title' => 'Faire une bonne action chaque jour pendant un an', 'description' => 'Cultiver la gentillesse au quotidien.'],
            ['title' => 'Planter 100 arbres', 'description' => 'Contribuer à la reforestation et à la lutte contre le changement climatique.'],
            ['title' => 'Offrir des fleurs à un inconnu', 'description' => 'Apporter un sourire inattendu.'],
            ['title' => 'Devenir donneur de sang régulier', 'description' => 'Sauver des vies grâce à mon don.'],
            ['title' => 'Aider à la construction d\'une école', 'description' => 'Participer à l\'éducation des enfants dans le besoin.'],
            ['title' => 'Complimenter 5 inconnus chaque jour', 'description' => 'Répandre la positivité autour de moi.'],
        ],
        'Expériences uniques' => [
            ['title' => 'Faire un saut en parachute', 'description' => 'Vivre une montée d\'adrénaline inoubliable.'],
            ['title' => 'Nager avec des dauphins', 'description' => 'Rencontrer ces créatures marines intelligentes et gracieuses.'],
            ['title' => 'Assister à un concert de mon artiste préféré', 'description' => 'Vivre l\'énergie de la musique en live.'],
            ['title' => 'Monter à bord d\'une montgolfière', 'description' => 'Voir le monde d\'en haut dans une nacelle suspendue.'],
            ['title' => 'Voir une éclipse solaire totale', 'description' => 'Observer ce phénomène astronomique rare.'],
            ['title' => 'Manger dans un restaurant étoilé au guide Michelin', 'description' => 'Découvrir la gastronomie d\'exception.'],
            ['title' => 'Voir un volcan en éruption', 'description' => 'Assister à la puissance brute de la nature.'],
            ['title' => 'Faire une excursion en sous-marin', 'description' => 'Explorer les fonds marins dans un submersible.'],
            ['title' => 'Assister à la Coupe du Monde de Football', 'description' => 'Vivre l\'ambiance électrique de cet événement planétaire.'],
            ['title' => 'Faire une descente en rafting', 'description' => 'Naviguer les rapides d\'une rivière en équipe.'],
            ['title' => 'Survivre en autonomie dans la nature pendant une semaine', 'description' => 'Me reconnecter à la nature et tester mes capacités de survie.'],
            ['title' => 'Être figurant dans un film', 'description' => 'Découvrir les coulisses du cinéma et apparaître à l\'écran.'],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $authorName = "Utilisateur Anonyme";

        // IMPORTANT : Supprimez ou commentez la ligne ci-dessous.
        // Les méthodes hasReference et getReference sont directement disponibles.
        // $referenceRepository = $this->container->get('doctrine.fixtures.orm.manager');

        foreach (self::WISH_LIST as $categoryNameFromList => $wishesInCategory) {
            $categoryRefName = 'category_' . strtolower(str_replace([' ', '&'], ['_', 'and'], $categoryNameFromList));

            // Utilisez directement $this->hasReference()
            if (!$this->hasReference($categoryRefName, Category::class)) {
                throw new \RuntimeException("La catégorie de référence '{$categoryRefName}' n'a pas été trouvée. Assurez-vous que les noms dans WISH_LIST correspondent aux catégories de CategoryFixtures.");
            }

            // Utilisez directement $this->getReference()
            $categoryEntity = $this->getReference($categoryRefName, Category::class);

            foreach ($wishesInCategory as $wishData) {
                $wish = new Wish();
                $wish->setTitle($wishData['title']);
                $wish->setDescription($wishData['description']);
                $wish->setAuthor($authorName);
                $wish->setIsPublished(true);
                $wish->setDateCreated(new \DateTime());
                $wish->setDateUpdated(new \DateTime());
                $wish->setCategory($categoryEntity);

                $manager->persist($wish);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
