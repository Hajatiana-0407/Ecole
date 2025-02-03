<?php

namespace App\Controller\Parametrage;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class NiveauController extends ParametrageController
{
    public function __construct()
    {
        parent::__construct();
    }

    #[Route('/niveau', name: 'niveau')]
    public function index(): Response
    {
        return $this->render('parametrage/niveau/index.html.twig', [
            'controller_name' => 'ParametrageController',
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->menuListes
        ]);
    }
}
