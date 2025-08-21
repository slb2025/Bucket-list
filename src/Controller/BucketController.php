<?php

// Définit le namespace du contrôleur. C'est une convention dans Symfony
// de placer les contrôleurs dans le namespace App\Controller.
namespace App\Controller;

// Importe les classes nécessaires qui seront utilisées dans ce fichier.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // La classe de base pour les contrôleurs dans Symfony, qui fournit des méthodes utiles (comme render(), getDoctrine(), etc.).
use Symfony\Component\HttpFoundation\Response; // La classe qui représente une réponse HTTP (ce que le contrôleur renvoie au navigateur).
use Symfony\Component\Routing\Attribute\Route; // La classe utilisée pour définir les routes via des attributs PHP 8.

/**
 * Le mot-clé 'final' signifie que cette classe ne peut pas être étendue (on ne peut pas en hériter).
 * C'est une bonne pratique pour les contrôleurs qui ne sont pas destinés à être des classes parentes.
 */
final class BucketController extends AbstractController
{
    /**
     * #[Route('/main', name: 'app_main')]
     * C'est un attribut qui définit une route.
     * - '/main' est l'URL qui déclenchera l'exécution de cette méthode.
     * - name: 'app_main' est le nom de la route. Ce nom est très utile pour générer des URLs
     * dans les templates Twig (avec la fonction path()) ou dans d'autres contrôleurs.
     *
     * @return Response L'objet Response contenant le HTML à afficher.
     */
    #[Route('/main', name: 'app_main')]
    public function main(): Response
    {
        // La méthode render() est héritée de AbstractController.
        // Elle prend en paramètre le chemin vers un template Twig et le "rend",
        // c'est-à-dire qu'elle génère le HTML final à partir de ce template.
        // Le résultat est encapsulé dans un objet Response qui est ensuite retourné.
        return $this->render('bucket/index.html.twig');
    }

    /**
     * #[Route('/about-us', name: 'app_about')]
     * Définit une autre route pour la page "À propos de nous".
     * - '/about-us' est l'URL.
     * - name: 'app_about' est le nom de la route.
     *
     * @return Response
     */
    #[Route('/about-us', name: 'app_about')]
    public function aboutUs(): Response
    {
        // Rend le template Twig situé dans templates/bucket/about-us.html.twig.
        return $this->render('bucket/about-us.html.twig');
    }
}