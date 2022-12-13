<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_guest')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig');
    }
}
