<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BucketController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function main(): Response
    {
        return $this->render('bucket/index.html.twig');
    }

    #[Route('/about-us', name: 'app_about')]
    public function aboutUs(): Response
    {
        return $this->render('bucket/about-us.html.twig');
    }

}
