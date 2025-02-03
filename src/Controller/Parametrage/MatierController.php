<?php

namespace App\Controller\Parametrage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametre', name: 'parametre_')]
class MatierController extends AbstractController
{
    #[Route('/matier', name: 'matier')]
    public function index(): Response
    {
        return $this->render('parametrage/matier/index.html.twig', [
            'controller_name' => 'MatierController',
        ]);
    }
}
