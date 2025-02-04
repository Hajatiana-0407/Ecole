<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Niveau;
use App\Form\NiveauType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class NiveauController extends NiveauParent
{
    protected $active_onglet;
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet= 'Niveau';
    }

    #[Route('/niveau', name: 'niveau')]
    public function index(): Response
    {
        $niveau  = new Niveau();
        $form_niveau = $this->createForm(NiveauType::class, $niveau);

        return $this->render('parametrage/niveau/index.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView()
        ]);
    }
}
