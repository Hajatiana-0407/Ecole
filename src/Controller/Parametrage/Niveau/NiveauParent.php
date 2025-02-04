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
}
