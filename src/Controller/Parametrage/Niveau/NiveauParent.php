<?php

namespace App\Controller\Parametrage\Niveau;

use App\Controller\Parametrage\ParametrageController;

class NiveauParent extends ParametrageController
{
    protected $active_onglet ;
    public function __construct( )
    {
        parent::__construct( );
        $this->active_class = 'Niveau' ; 
    }

    public function get_params():array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste( $this->active_class ) , 
            'onglets' => $this->getNiveauClass_onglets( $this->active_onglet  ) ,
        ] ; 
    }

    protected function getNiveauClass_onglets($active_class): array
    {
        $datas =  [
            'Niveau' => [
                'icone' => '<i class="fa-solid fa-layer-group"></i>',
                'href' => 'parametre_niveau',
            ],
            'Classe' => [
                'icone' => '<i class="fa-solid fa-graduation-cap"></i>',
                'href' => 'parametre_classe'
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
