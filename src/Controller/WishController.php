<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishController extends AbstractController
{

    #[Route('/wish', name: 'app_wish')]
    public function allWish(): Response
    {
        return $this->render('bucket/all-wish.html.twig');
    }


    #[Route('/wish-detail', name: 'app_wish-detail')]
    public function allWishDetail(): Response
    {
        return $this->render('bucket/all-wish.html.twig');
    }
}
