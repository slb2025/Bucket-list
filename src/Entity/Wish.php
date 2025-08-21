<?php

// Définit le namespace pour cette classe, essentiel pour l'organisation et l'autoloading.
namespace App\Entity;

// Importe les classes et les types nécessaires depuis les bibliothèques externes.
use App\Repository\WishRepository; // Le repository associé à cette entité.
use Doctrine\DBAL\Types\Types; // Contient les constantes pour les types de colonnes de la base de données.
use Doctrine\ORM\Mapping as ORM; // Importe les fonctionnalités de l'ORM Doctrine pour le mapping.

/**
 * #[ORM\Entity(repositoryClass: WishRepository::class)]
 * Cette ligne est un attribut PHP 8. Elle déclare que cette classe est une entité Doctrine.
 * L'ORM saura qu'il doit la gérer et la persister en base de données.
 * 'repositoryClass' spécifie la classe repository qui contiendra les requêtes personnalisées pour cette entité.
 */
#[ORM\Entity(repositoryClass: WishRepository::class)]
class Wish
{
    /**
     * @var int|null L'identifiant unique du souhait.
     *
     * #[ORM\Id]
     * Indique que cette propriété est la clé primaire de la table.
     *
     * #[ORM\GeneratedValue]
     * Spécifie que la valeur de cette clé primaire sera auto-générée (par ex: auto-incrémentation).
     *
     * #[ORM\Column]
     * Définit cette propriété comme une colonne dans la table de la base de données.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null Le titre du souhait.
     *
     * #[ORM\Column(length: 255)]
     * Mappe cette propriété à une colonne de type VARCHAR avec une longueur maximale de 255 caractères.
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var string|null La description détaillée du souhait.
     *
     * #[ORM\Column(type: Types::TEXT, nullable: true)]
     * Mappe à une colonne de type TEXT, qui peut contenir de longues chaînes de caractères.
     * 'nullable: true' signifie que cette colonne peut contenir des valeurs NULL.
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var string|null Le nom de l'auteur du souhait.
     *
     * #[ORM\Column(length: 255)]
     * Mappe à une colonne VARCHAR(255).
     */
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    /**
     * @var bool|null Indique si le souhait est publié ou non.
     *
     * #[ORM\Column(nullable: true)]
     * Mappe à une colonne de type booléen (généralement TINYINT(1) en SQL).
     * 'nullable: true' permet à la colonne d'être NULL.
     */
    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    /**
     * @var \DateTime|null La date de création du souhait.
     *
     * #[ORM\Column(nullable: true)]
     * Mappe à une colonne de type DATETIME.
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateCreated = null;

    /**
     * @var \DateTime|null La date de la dernière mise à jour du souhait.
     *
     * #[ORM\Column(nullable: true)]
     * Mappe à une colonne de type DATETIME.
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateUpdated = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    // --- GETTERS ET SETTERS ---
    // Les méthodes ci-dessous permettent d'accéder (get) et de modifier (set)
    // les propriétés privées de la classe, respectant le principe d'encapsulation.

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this; // 'return $this' permet de chaîner les appels de setters (ex: $wish->setTitle(...)->setAuthor(...)).
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTime $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(?\DateTime $dateUpdated): static
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}