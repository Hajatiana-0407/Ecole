<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personnel', name: 'personnel_')]
class PersonnelController extends AbstractController
{
    // le nom serait presonnel_index
    // l'url est /personnel/
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('personnel/index.html.twig', [
            'controller_name' => 'PersonnelController',
        ]);
    }
}
