<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Niveau;
use App\Form\NiveauType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class ClasseController extends NiveauParent
{
    protected $active_onglet;
    public function __construct()
    {
        parent::__construct();
        $this->active_onglet= 'Classe';
    }

    #[Route('/niveau/classe', name: 'classe')]
    public function index(): Response
    {
        $niveau  = new Niveau();
        $form_niveau = $this->createForm(NiveauType::class, $niveau);

        return $this->render('parametrage/niveau/classe.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView()
        ]);
    }
}
