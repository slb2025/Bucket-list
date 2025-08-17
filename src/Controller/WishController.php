<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishController extends AbstractController
{

    #[Route('/wish', name: 'app_wish')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAll();

        return $this->render('bucket/all-wish.html.twig', [
            'wishes' => $wishes
        ]);
    }


    #[Route('/wish/{id}', name: 'app_wish-detail', requirements:['id'=>'\d+'], defaults:['id'=>0])]
    public function wishDetail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Wish not found");
        }

        return $this->render('bucket/wish-detail.html.twig', ['wish' => $wish]);
    }
}
