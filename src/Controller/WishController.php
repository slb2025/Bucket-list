<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/wish/create', name: 'app_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em->persist($wish);
            $em->flush();

            $this->addFlash('success', "Un souhait a été enregistré avec sucès");

            return $this->redirectToRoute('app_wish-detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/edit.html.twig', [
            'wish_form' => $form,
        ]);
    }

}
