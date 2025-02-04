<?php

namespace App\Controller\Parametrage\Niveau;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parametre', name: 'parametre_')]
class NiveauController extends NiveauParent
{
    protected $active_onglet;
    public function __construct(private NiveauRepository $repository )
    {
        parent::__construct();
        $this->active_onglet = 'Niveau';
    }

    #[Route('/niveau', name: 'niveau')]
    public function index(Request $request , PaginatorInterface $paginator): Response
    {
        $niveau  = new Niveau();
        $form_niveau = $this->createForm(NiveauType::class, $niveau);
        $datas = $this->pagination( $paginator , $request , $this->repository->__get_all()) ; 
        dd( $datas ) ; 
        return $this->render('parametrage/niveau/index.html.twig', [
            ...$this->get_params(),
            'form_niveau' => $form_niveau->createView()
        ]);
    }
}
