<?php

namespace App\Controller\GestionEleve\Eleve;

use App\Controller\GestionEleve\GestionEleveController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gestion-eleve', name: 'gestion-eleve_')]
class EleveController extends GestionEleveController
{
    public function __construct()
    {
        parent::__construct() ; 
        $this->active_class = 'Eleve';
    }

    private function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
        ];
    }


    #[Route('/eleve', name: 'eleve')]
    public function index(): Response
    { 
        return $this->render('gestion_eleve/eleve/eleve.html.twig', [
            ...$this->get_params() 
        ]);
    }
}
