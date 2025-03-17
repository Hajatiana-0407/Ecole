<?php

namespace App\Controller\Parametrage\Frais;

use App\Controller\Parametrage\ParametrageController;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class FraisParent extends ParametrageController
{
    protected $active_onglet;
    public function __construct()
    {
        parent::__construct();
        $this->active_class = 'Frais';
    }

    public function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
            'onglets' => $this->getOnglets( $this->active_onglet  ) ,
            'js' => 'frais'
        ];
    }

    protected function getOnglets($active_class): array
    {
        $datas =  [
            'Ecolage' => [
                'icone' => '<i class="fas fa-money-bill-wave"></i>',
                'href' => 'parametre_frais',
            ],
            'Droit d\'inscription' => [
                'icone' => '<i class="fas fa-file-signature"></i>',
                'href' => 'parametre_droit'
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
