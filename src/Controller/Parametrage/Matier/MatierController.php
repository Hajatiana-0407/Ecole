<?php

namespace App\Controller\Parametrage\Matier;

use App\Controller\Parametrage\ParametrageController;
use App\Entity\Matier;
use App\Form\MatierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametre', name: 'parametre_')]
class MatierController extends ParametrageController
{
    public function __construct()
    {
        parent::__construct() ; 
        $this->active_class = 'Matiére' ; 
    }
    public function get_params(): array
    {
        return [
            'titleMenu' => $this->titleMenu,
            'menuListes' => $this->get_menu_liste($this->active_class),
        ];
    }

    #[Route('/matier', name: 'matier')]
    public function index( ): Response
    {
        $matier = new Matier() ; 
        $form = $this->createForm( MatierType::class , $matier ) ; 

        return $this->render('parametrage/matier/matier.html.twig', [
            ...$this->get_params()  ,
            'form_matier' => $form->createView(),  
        ]);
    }
}
