<?php

namespace App\Controller\Parametrage\Matier;

use App\Controller\Parametrage\ParametrageController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametre', name: 'parametre_')]
class MatierParent extends ParametrageController
{
    protected $active_onglet ; 
    public function __construct()
    {
        parent::__construct();
        $this->active_class = 'Matiére';
    }
    public function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
            'onglets' => $this->getOnglets($this->active_onglet),
            'js' => 'matiere'
        ];
    }

    protected function getOnglets($active_class): array
    {
        $datas =  [
            'Ajout' => [
                'icone' => '<i class="fa-solid fa-plus"></i>',
                'href' => 'parametre_matier',
            ],
            'Niveau et Coeficient' => [
                'icone' => '<i class="fa-solid fa-graduation-cap"></i>',
                'href' => 'parametre_matiere_coeficient'
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
}
