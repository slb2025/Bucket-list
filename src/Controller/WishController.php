<?php

// Définit le namespace du contrôleur, une pratique standard pour l'organisation dans Symfony.
namespace App\Controller;

// Importe les classes et interfaces nécessaires.
use App\Entity\Wish; // L'entité Doctrine qui représente un souhait.
use App\Form\WishType; // Le formulaire Symfony pour créer/éditer un souhait.
use App\Repository\WishRepository; // Le repository pour accéder aux données des souhaits.
use Doctrine\ORM\EntityManagerInterface; // Le service de Doctrine pour gérer la persistance des entités (sauvegarde, suppression).
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // La classe de base des contrôleurs Symfony.
use Symfony\Component\HttpFoundation\Request; // Représente une requête HTTP.
use Symfony\Component\HttpFoundation\Response; // Représente une réponse HTTP.
use Symfony\Component\Routing\Attribute\Route; // Pour définir les routes via des attributs.

/**
 * Le mot-clé 'final' empêche l'héritage de cette classe.
 * C'est une bonne pratique pour les contrôleurs.
 */
final class WishController extends AbstractController
{
    /**
     * Affiche la liste de tous les souhaits.
     *
     * #[Route('/wish', name: 'app_wish')]
     * Définit la route pour cette méthode.
     * - URL : /wish
     * - Nom de la route : app_wish
     *
     * @param WishRepository $wishRepository Le service repository est injecté automatiquement par Symfony.
     * @return Response La réponse HTTP contenant la page rendue.
     */
    #[Route('/wish', name: 'app_wish')]
    public function list(WishRepository $wishRepository): Response
    {
        // Utilise le repository pour récupérer tous les objets Wish de la base de données.
        $wishes = $wishRepository->findAll();

        // Rend le template Twig 'all-wish.html.twig' en lui passant la liste des souhaits.
        return $this->render('bucket/all-wish.html.twig', [
            'wishes' => $wishes
        ]);
    }

    /**
     * Affiche les détails d'un souhait spécifique.
     *
     * #[Route('/wish/{id}', name: 'app_wish-detail', requirements:['id'=>'\d+'])]
     * Définit une route avec un paramètre dynamique {id}.
     * - URL : /wish/ suivi d'un nombre (ex: /wish/12)
     * - Nom de la route : app_wish-detail
     * - requirements:['id'=>'\d+'] : Contrainte qui assure que le paramètre {id} est bien un ou plusieurs chiffres.
     *
     * @param int $id L'identifiant du souhait, récupéré depuis l'URL.
     * @param WishRepository $wishRepository Le service repository injecté.
     * @return Response
     */
    #[Route('/wish/{id}', name: 'app_wish-detail', requirements:['id'=>'\d+'])]
    public function wishDetail(int $id, WishRepository $wishRepository): Response
    {
        // Cherche un souhait dans la base de données par son ID.
        $wish = $wishRepository->find($id);

        // Si aucun souhait n'est trouvé pour cet ID, on lève une exception 404.
        if (!$wish) {
            throw $this->createNotFoundException("Ce souhait n'existe pas !");
        }

        // Rend le template de détail en lui passant l'objet Wish trouvé.
        return $this->render('bucket/wish-detail.html.twig', ['wish' => $wish]);
    }

    /**
     * Gère la création d'un nouveau souhait.
     *
     * #[Route('/wish/create', name: 'app_create')]
     * Définit la route pour la page de création.
     *
     * @param Request $request L'objet qui contient les informations de la requête HTTP (données POST, etc.).
     * @param EntityManagerInterface $em Le service qui gère la persistance des entités.
     * @return Response
     */
    #[Route('/wish/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Crée une nouvelle instance vide de l'entité Wish.
        $wish = new Wish();
        // Crée une instance du formulaire en le liant à l'objet $wish.
        $form = $this->createForm(WishType::class, $wish);

        // Analyse la requête pour voir si le formulaire a été soumis.
        // Si c'est le cas, les données sont hydratées dans l'objet $wish.
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et si les données sont valides.
        if ($form->isSubmitted() && $form->isValid()) {
            // Prépare l'objet $wish pour la sauvegarde en base de données.
            $em->persist($wish);
            // Exécute la requête SQL pour insérer les données.
            $em->flush();

            // Ajoute un "message flash" qui sera affiché sur la page suivante.
            $this->addFlash('success', "Le souhait a bien été enregistré !");

            // Redirige l'utilisateur vers la page de détail du souhait nouvellement créé.
            return $this->redirectToRoute('app_wish-detail', ['id' => $wish->getId()]);
        }

        // Si le formulaire n'est pas soumis (premier affichage) ou n'est pas valide,
        // on affiche la page avec le formulaire.
        return $this->render('wish/edit.html.twig', [
            'wish_form' => $form, // Passe le formulaire au template pour l'affichage.
        ]);
    }
}