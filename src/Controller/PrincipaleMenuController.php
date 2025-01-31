<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/principale/menu', name: 'principale_menu_')]
class PrincipaleMenuController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('principale_menu/index.html.twig', [
            'controller_name' => 'PrincipaleMenuController',
        ]);
    }
}
