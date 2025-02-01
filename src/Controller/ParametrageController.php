<?php

namespace App\Controller;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parmetre_')]
class ParametrageController extends AbstractController
{
    private $titleMenu;
    private $menuListes;
    public function __construct()
    {
        // TItre du menu 
        $this->titleMenu = "Parametrage";

        // Liste des menu et icone 
        $this->menuListes = [
            "Frais de scolarité" => [
                'href' => '' , 
                'role' => '',
                'icone' => '<i class="fa-solid fa-dollar-sign"></i>'
            ],
            'Niveau' =>  [
                'href' => '' , 
                'role' => '',
                'icone' =>'<i class="fas fa-layer-group"></i>'
            ],
            'Matiére' =>  [
                'href' => '' , 
                'role' => '',
                'icone' => '<i class="fas fa-book"></i>'
            ],
            'Salaire personnel' =>  [
                'href' => '' , 
                'role' => '',
                'icone' => '<i class="fas fa-hand-holding"></i>'
            ],
            'Utilisateur' =>  [
                'href' => '' , 
                'role' => '',
                'icone' => '<i class="fas fa-user"></i>'
            ]
        ];
    }


    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('parametrage/index.html.twig', [
            'controller_name' => 'ParametrageController',
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->menuListes
        ]);
    }
}
