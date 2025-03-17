<?php

namespace App\Controller\Parametrage;

use App\Controller\BaseController;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class ParametrageController extends BaseController
{
    protected $titleMenu;
    protected $menuListes;
    protected $active_class;
    public function __construct()
    {
        // TItre du menu 
        $this->titleMenu = "Parametrage";
    }

    public function get_menu_liste($active_menu) :array 
    {

        $datas  = [
            'Niveau et classe' =>  [
                'href' => 'parametre_niveau',
                'role' => '',
                'icone' => '<i class="fas fa-layer-group"></i>'
            ],
            "Frais" => [
                'href' => 'parametre_frais',
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
