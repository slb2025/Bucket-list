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


    #[Route('/wish/{id}', name: 'app_wish-detail', requirements:['id'=>'/d+'], defaults:['id'=>0])]
    public function allWishDetail(int $id): Response
    {
        return $this->render('bucket/wish-detail.html.twig', ['id' => $id]);
    }
}
