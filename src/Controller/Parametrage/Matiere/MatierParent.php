<?php

namespace App\Controller\Parametrage\Matiere;

use App\Controller\Parametrage\ParametrageController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametre', name: 'parametre_')]
class MatiereParent extends ParametrageController
{
    protected $active_onglet ; 
    public function __construct()
    {
        parent::__construct();
        $this->active_class = 'Matière';
    }
    public function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
            'onglets' => $this->getOnglets($this->active_onglet),
            'js' => 'Matiere'
        ];
    }

    protected function getOnglets($active_class): array
    {
        $datas =  [
            'Ajout' => [
                'icone' => '<i class="fa-solid fa-plus"></i>',
                'href' => 'parametre_Matiere',
            ],
            'Niveau et Coeficient' => [
                'icone' => '<i class="fas fa-percent"></i>',
                'href' => 'parametre_Matiere_coeficient'
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
