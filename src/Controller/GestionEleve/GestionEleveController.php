<?php

namespace App\Controller\GestionEleve;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class GestionEleveController extends BaseController
{
    protected $titleMenu;
    protected $menuListes;
    protected $active_class;
    public function __construct()
    {
        // TItre du menu 
        $this->titleMenu = "Etudiant";
    }

    public function get_menu_liste($active_menu) :array 
    {
        $this->titleMenu = "texte";
        $datas  = [
            'Eleve' =>  [
                'href' => 'gestion-eleve_eleve',
                'role' => '',
                'icone' => '<i class="fas fa-user-graduate"></i>'
            ],
            "Inscription" => [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-pen"></i>'
            ],
            'Pointage' =>  [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-clock"></i>'
            ],
            'Paiement' =>  [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-credit-card"></i>'
            ],
            'Note' =>  [
                'href' => '',
                'role' => '',
                'icone' => '<i class="fas fa-clipboard-list"></i>'
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
