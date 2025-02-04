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
    protected $active_class;
    public function __construct()
    {
        // TItre du menu 
        $this->titleMenu = "Parametrage";
    }


    #[Route('/', name: 'index')]
    public function niveau(): Response
    {
        return $this->redirectToRoute('parametre_niveau');
    }


    protected function getNiveauClass_onglets($active_class): array
    {
        $datas =  [
            'Niveau' => [
                'icone' => '<i class="fa-solid fa-stairs"></i>',
                'href' => 'parametre_niveau',
            ],
            'Classe' => [
                'icone' => '<i class="fa-solid fa-graduation-cap"></i>',
                'href' => ''
            ],
        ];
        foreach ($datas as $key => $data) {

            if (strtoupper($key) == strtoupper($active_class)) {
                $datas[$key]['active'] = 'active';
            } else {
                $datas[$key]['active'] = '';
            }
        }
        return $datas;
    }


    public function get_menu_liste($active_menu) :array 
    {

        $datas  = [
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

        foreach ($datas as $key => $data) {

            if (strtoupper($key) == strtoupper($active_menu)) {
                $datas[$key]['active'] = 'active';
            } else {
                $datas[$key]['active'] = '';
            }
        }
        return $datas;
    }
}
