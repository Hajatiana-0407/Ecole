<?php

namespace App\Controller\Parametrage;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class ParametrageController extends AbstractController
{
    protected $titleMenu;
    protected $menuListes;
    public function __construct()
    {
        // TItre du menu 
        $this->titleMenu = "Parametrage";

        // Liste des menu et icone 
        $this->menuListes = [
            'Niveau' =>  [
                'href' => 'parametre_niveau',
                'role' => '',
                'icone' => '<i class="fas fa-layer-group"></i>'
            ],
            "Frais de scolarité" => [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fa-solid fa-dollar-sign"></i>'
            ],
            'Matiére' =>  [
                'href' => 'parametre_matier',
                'role' => '',
                'icone' => '<i class="fas fa-book"></i>'
            ],
            'Utilisateur' =>  [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-user"></i>'
            ],
            'Salaire personnel' =>  [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-hand-holding"></i>'
            ],
        ];
    }


    // #[Route('/niveau', name: 'niveau')]
    // public function niveau(): Response
    // {
    //     return $this->render('parametrage/index.html.twig', [
    //         'controller_name' => 'ParametrageController',
    //         'titleMenu' => $this->titleMenu,
    //         'menuListes' => $this->menuListes
    //     ]);
    // }
}
